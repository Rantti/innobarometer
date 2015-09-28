<?php

// src/AppBundle/Controller/UserSignUpController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\AppUser;

class UserSignUpController extends Controller
{
    /**
     * @Route("/user/signUp", name="Created")
     */
    public function createUserAction(){
		$appUser = new user();
		$appUser->setNickName($_POST["nickName"]);
		$appUser->setPassword($_POST["userPassword"]);
		if (isset($_POST["adminBox"])){
			$user->setAdmin("1");
		}else{
			$user->setAdmin("0");
		}

		$em = $this->getDoctrine()->getManager();

		$em->persist($appUser);
		$em->flush();

		return new Response("{{ path('homepage') }}");
	}
}
?>