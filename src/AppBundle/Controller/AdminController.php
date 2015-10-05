<?php

namespace AppBundle\Controller;
/**
 * @author  Antti Eloranta <anttioeloranta+work@gmail.com>
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class AdminController extends Controller
{
    
    /**
     * @Route("/users", name="users")
     */
    public function userPageAction(Request $request)
    {
    	$userManager = $this->get('fos_user.user_manager');
    	$users = $userManager->findUsers();
        return $this->render('admin/users.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'users' =>   $users,
        ));
    }

    /**
     * @Route("/removeuser", name="removeuser")
     * 
     */
    public function userRemoveAction(Request $request ){

    }
    /**
     * Creates a form to delete a Post entity by id.
     *
     * This is necessary because browsers don't support HTTP methods different
     * from GET and POST. Since the controller that removes the blog posts expects
     * a DELETE method, the trick is to create a simple form that *fakes* the
     * HTTP DELETE method.
     * See http://symfony.com/doc/current/cookbook/routing/method_parameters.html.
     *
     * @param Post $post The post object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
?>