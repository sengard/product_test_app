<?php

namespace App\Controller;

use App\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

class SecurityController extends SymfonyController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();



        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        $error = $form->getErrors()->current();
        return $this->render(
            'security/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
