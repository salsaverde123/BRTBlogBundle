<?php
/**
 * Created by PhpStorm.
 * User: Bartolome Rojas
 * Date: 28/08/2017
 * Time: 16:14
 */

namespace BRT\BlogBundle\Controller;

use BRT\BlogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
*/
class AdminController extends Controller
{
    /**
     * @Route("/", name="brt_blog_adminpage")
    */
    public function indexAction(){

        return $this->render('@BRTBlog/Admin/brt_blog_admin_index.html.twig');

    }

    /**
     * @Route("/profile", name="brt_blog_admin_profile")
     */
    public function profileAction(){

        $user = $this->getUser();

        return $this->render('@BRTBlog/Admin/profile/edit_profile.html.twig', ['user' => $user]);

    }


    /**
     * @Route("/profile/edit", name="brt_blog_admin_profile_edit")
     */
    public function editProfileAction(Request $request){

        /** @var User $user */
        $user = $this->getUser();

        if($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $user->setUsername($request->get('username'));
            $user->setName($request->get('name'));
            $user->setEmail($request->getMethod('email'));
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Perfil modificado correctamente');
        }

        return $this->render('@BRTBlog/Admin/profile/edit_profile.html.twig', ['user' => $user]);

    }


    /**
     * @Route("/edit_password", name="brt_blog_admin_profile_edit_password")
     */
    public function editPasswordAction(Request $request){

        $currentPassword = $request->get('current_password');
        $newPassword = $request->get('new_password');
        $repeatNewPassword = $request->get('repeat_new_password');

        $encoder = $this->get('security.password_encoder');

        /** @var User $user */
        $user = $this->getUser();

        $isValid = $encoder->isPasswordValid($user,$currentPassword);

        if(!$isValid) {
            $this->get('session')->getFlashBag()->add('danger', 'La contraseña no es válida');
            return $this->redirect($this->generateUrl('brt_blog_admin_profile'));
        }

        if($newPassword != $repeatNewPassword){
            $this->get('session')->getFlashBag()->add('danger', 'Las nuevas contraseñas no coinciden.');
            return $this->redirect($this->generateUrl('brt_blog_admin_profile'));
        }


        $encodedPassword = $encoder->encodePassword($user,$newPassword);
        $user->setPassword($encodedPassword);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Se ha cambiado la contraseña correctamente');

        return $this->redirect($this->generateUrl('brt_blog_admin_profile'));


    }

}