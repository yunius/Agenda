<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Security;

use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Silex\Application;

/**
 * Description of CustomAuthenticationSuccessHandler
 *
 * @author inpiron
 */
class CustomAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler{
    
    protected $app = null;

    public function __construct(HttpUtils $httpUtils, array $options, Application $app)
    {
      parent::__construct($httpUtils, $options);
      $this->app = $app;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
      $user = $token->getUser();
      $data = array(
          'last_login' => date('Y-m-d H:i:s')
      );
      // save the last login of the user
      $this->app['account']->updateUserData($user->getUsername(), $data);

      return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }
}
