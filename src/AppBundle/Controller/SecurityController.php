<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login_route")
	 */
	public function loginAction(Request $request){
		$authenticationUtils = $this->get("security.authentication_utils");

    // get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render(
			"security/login.html.twig",
			array(
            // last username entered by the user
				"last_username" => $lastUsername,
				"error"         => $error,
				)
			);
	}

	/**
	 * @Route("/login_check", name="login_check")
	 */
	public function loginCheckAction(){}


	/**
	 * @Route("/signup", name="signup")
	 */
	public function signUpAction()
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('account_create'),
        ));

        return $this->render(
            'user/signup.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route ("/signup/create")
     */
    public function createUserAction(Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $user = new User();
    $form = $this->createForm(new UserType(), $user);

    $form->handleRequest($request);

    if ($form->isValid()) {
        $user = $form->getData();

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    return $this->render(
        'user/signup.html.twig',
        array('form' => $form->createView())
    );
}

}

?>
