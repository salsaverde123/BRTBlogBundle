<?php
/**
 * Created by PhpStorm.
 * User: Bartolome Rojas
 * Date: 28/08/2017
 * Time: 16:34
 */

namespace BRT\BlogBundle\Controller;



use BRT\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin/entries")
*/
class AdminEntriesController extends Controller
{

    /**
     * Lists all post entities.
     *
     * @Route("/", name="brt_blog_admin_entry_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('BRTBlogBundle:Post')->findBy([],["id"=>"DESC"]);

        return $this->render('@BRTBlog/Admin/post/index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="brt_blog_admin_entry_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('BRT\BlogBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setCreated(\DateTime::createFromFormat('d/m/Y H:i:s',$post->getCreated()));
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('brt_blog_admin_entry_index');
        } else {
            /*
            foreach ($form->getErrors(true) as $error){
                var_dump($error);
            }
            */
        }

        return $this->render('@BRTBlog/Admin/post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="brt_blog_admin_entry_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {

        $editForm = $this->createForm('BRT\BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setCreated(\DateTime::createFromFormat('d/m/Y H:i:s',$post->getCreated()));
            $post->setUpdated(new \DateTime());

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('brt_blog_admin_entry_edit', array('id' => $post->getId()));
        }

        return $this->render('@BRTBlog/Admin/post/edit.html.twig', array(
            'post' => $post,
            'form' => $editForm->createView()

        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="brt_blog_admin_entry_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Post $post)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();


        return $this->redirectToRoute('brt_blog_admin_entry_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entry_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}