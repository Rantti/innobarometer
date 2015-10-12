<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

/**
* @Route("/profile")
* @author Antti Eloranta <anttioeloranta@gmail.com>
*/

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     */
    public function indexAction(Request $request)
    {
        return $this->render('profile/profile.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

}
?>