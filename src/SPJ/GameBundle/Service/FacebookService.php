<?php
namespace SPJ\GameBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use SPJ\GameBundle\Entity\User;

class FacebookService
{
    protected $facebookSdk;
    protected $router;
    protected $userRepository;
    protected $securityContext;
    protected $encoderFactory;
    protected $entityManager;

    public function __construct($appId, $appSecret, $router, $userRepository, $securityContext, $encoderFactory, $entityManager)
    {
        require_once __DIR__ . '/../../../../vendor/facebook/php-sdk/src/facebook.php';
        $this->facebookSdk = new \Facebook(array(
            'appId' => $appId,
            'secret' => $appSecret
        ));
        $this->router = $router;
        $this->securityContext = $securityContext;
        $this->userRepository = $userRepository;
        $this->securityContext = $securityContext;
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManager;
    }

    public function getLoginUrl()
    {
        return $this->facebookSdk->getLoginUrl(array(
            'scope' => 'email',
            'redirect_uri' => $this->router->generate('facebook_login_check', array(), true)
        ));
    }

    public function getRandomPassword()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7);
    }

    public function login()
    {
        $facebookUserData = $this->facebookSdk->api('/me');

        try {
            $user = $this->userRepository->findOneByEmail($facebookUserData['email']);
            $user->setFacebookId($facebookUserData['id']);
        } catch (\Exception $e) {
            $user = new User();
            $user->setFacebookData($facebookUserData);
            $user->setPassword($this->encoderFactory->getEncoder($user)->encodePassword($this->getRandomPassword(), $user->getSalt()));
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->securityContext->setToken($token);
    }
}
