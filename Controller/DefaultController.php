<?php

namespace BRT\BlogBundle\Controller;

use BRT\BlogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/default")
*/
class DefaultController extends Controller
{

    /**
     * @Route("/index")
    */
    public function indexAction()
    {
        return $this->render('BRTBlogBundle:Default:index.html.twig');
    }

    /**
     * @Route("/login", name="brt_blog_login")
    */
    public function loginAction(Request $request){

        $authUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('@BRTBlog/Default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @Route("/logout", name="brt_blog_logout")
     */
    public function logoutAction(Request $request){
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        return $this->redirectToRoute('brt_blog_login');
    }


    /**
     * @Route("/creation-admin", name="brt_blog_creation_admin")
    */
    public function creationAdminAction(Request $request){

        $response = new StreamedResponse();

        $response->setCallback(function(){

            echo "Creandop admin... <br>";

            $passwordText = "123456";
            $user = new User();

            $user->setName("Admin");
            $user->setUsername("admin");
            $user->setCreated(new \DateTime());
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user,$passwordText));
            $user->setAdmin(1);
            $user->setEmail("admin@email.com");
            $user->setSalt("");

            echo "Propiedades de usuario establecidas <br>";

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            echo "Usuario guardado en base de datos.<br>";

            echo "usuario: admin <br> password: 123456<br>";


        });

        return $response;

    }
}
