<?php

namespace App\Security;

use App\Application\Sonata\UserBundle\Entity\User;
use App\Form\LoginForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $em;
    private $router;
    private $passwordEncoder;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory = $formFactory;
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository(User::class)
            ->findOneBy(['username' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }

        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = null;

        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->router->generate('sonata_admin_dashboard');
        }

        return new RedirectResponse($targetPath);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        return  $request->getPathInfo() == '/login' && $request->isMethod('POST');
    }
}
