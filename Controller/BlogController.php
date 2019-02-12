<?php

namespace BRT\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
*/
class BlogController extends Controller {


    /**
     * @Route("/", name="brt_blog_blog_list")
    */
    public function postsListAction(Request $request){

        // Obtain the template of config
        $template = $this->getParameter('brt_blog_list_template');

        $em = $this->getDoctrine()->getManager();

        $query = " SELECT post FROM BRTBlogBundle:Post post ORDER BY post.id DESC";

        $query = $em->createQuery($query);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            10
        );

        return $this->render($template, [ 'pagination' => $pagination ]);

    }

    /**
     * @Route("/post/{slug}", name="brt_blog_blog_show")
    */
    public function showPostAction(Request $request){

        // Obtain the template of config
        $template = $this->getParameter('brt_blog_show_template');

        $em = $this->getDoctrine()->getManager();

        $lastPosts = $em->getRepository('BRTBlogBundle:Post')->getLastPosts(10);

        $post = $em->getRepository('BRTBlogBundle:Post')->findOneBy(["slug" => $request->get('slug')]);

        $post->setViews($post->getViews() ? $post->getViews() + 1 : 1);

        return $this->render($template,["post" => $post, "lastPosts" => $lastPosts]);

    }


}