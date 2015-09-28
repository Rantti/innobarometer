<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
	
	
	
	/**
	* @Route("/signUp", name="signUp")
	*/
	public function signUpAction(Request $request){
		$appUser = new AppUser();
		$appUser->setNickName('NickName');
        $appUser->setPassword('Password');
		$appUser->setAdmin(0);
        $form = $this->createFormBuilder($appUser)
            ->add('NickName', 'text')
            ->add('password', 'password')
			->add('admin', 'integer')
            ->add('save', 'submit', array('label' => 'Create User'))
            ->getForm();
			
        return $this->render('SignViews/signUp.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
			'form' => $form->createView(),
        ));
    }
	
	/**
     * @Route("/user/signedUp", name="Created")
     */
    public function createUserAction(){
		$appUser = new AppUser();
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

		return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
	}
	/**
	 * @Route("/admin")
	 */
	public function adminAction(){
		return new Response('<html><body>Admin page xD</body></html>');
	}
}
?>