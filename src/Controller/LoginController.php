<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * Description of LoginController
 *
 * @author Gilou
 */
class LoginController {
    
    public function loginAction(Request $request, Application $app) {
        $fil = ' / page d\'authentification';
        return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
        'fil' => $fil
        ));
    }
}
