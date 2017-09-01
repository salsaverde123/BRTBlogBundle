<?php
/**
 * Created by PhpStorm.
 * User: Bartolome Rojas
 * Date: 28/08/2017
 * Time: 16:14
 */

namespace BRT\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    public function indexAction(){

        return $this->render('@BRTBlog/Admin/brt_blog_admin_index.html.twig');

    }

}