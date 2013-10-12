<?php
namespace SPJ\GameBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class UserService
{
    protected $userRepository;
    protected $passwordEncoder;
    protected $entityManager;

    public function __construct($userRepository, $entityManager, $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function signup($user)
    {
        return $this->facebookSdk->getLoginUrl(array(
            'scope' => 'email',
            'redirect_uri' => $this->router->generate('facebook_login_check', array(), true)
        ));
    }

    public function login()
    {
        $facebookUser = $this->facebookSdk->api('/me');

        
    }
}
