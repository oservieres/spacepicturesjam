<?php
namespace SPJ\GameBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class FacebookService
{
    protected $facebookSdk;
    protected $router;

    public function __construct($appId, $appSecret, $router, $userRepostiory, )
    {
        require_once __DIR__ . '/../../../../vendor/facebook/php-sdk/src/facebook.php';
        $this->facebookSdk = new \Facebook(array(
            'appId' => $appId,
            'secret' => $appSecret
        ));
        $this->router = $router;
    }

    public function getLoginUrl()
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
