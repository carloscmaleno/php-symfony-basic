<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="page.index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/login", name="page.login")
     * @Method("GET")
     */
    public function showLoginAction(Request $request)
    {
        return $this->render('default/login.html.twig');
    }

    /**
     * @Route("/login", name="action.index")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();

        if (is_object($user) && $user instanceof UserInterface) {
            return new RedirectResponse($this->generateUrl('page.index'));
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($request->get('email'));

        //comprobarmos is existe el usuario
        if ($user) {
            //comporbamos si el password es correcto
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            if ($encoder->isPasswordValid($user->getPassword(), $request->get('password'), $user->getSalt())) {
                $loginManager = $this->get('fos_user.security.login_manager');
                $loginManager->logInUser(
                    $this->container->getParameter('fos_user.firewall_name'),
                    $user
                );
            } else {
                $user = null;
            }
        }

        $content = $this->renderView(
            'ajax.html.twig',
            array(
                'status' => ($user ? true : false),
                'message' => ($user ? $user->getUsername() : 'No user found')
            )
        );
        $response = new Response($content, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Show page Legal Terms
     * @Route("/legal", name="page.legal")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function legalPageAction(Request $request)
    {
        return $this->render('default/legal.html.twig');
    }

    /**
     * Show page contact form
     * @Route("/contact", name="page.contact")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function contactPageAction(Request $request)
    {
        return $this->render('default/contact.html.twig');
    }

    /**
     * Show page about
     * @Route("/about", name="page.about")
     * @Method("GET")
     * @return Response
     */
    public function aboutPageAction(){
        return $this->render('default/about.html.twig');
    }
}
