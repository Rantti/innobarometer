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
use AppBundle\Entity\Team;
use AppBundle\Form\TeamType;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * @Route("/removeuser", name="removeuser",
     * requirements = { "id" = "\d+" },
     * methods = { "GET" })
     * 
     */
    public function userRemoveAction(Request $request){
        $id = $this->getRequest()->get('id');
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found for id ' . $id);
        }
        $userManager->deleteUser($user);
        return new RedirectResponse("users");
    }
    

    /**
     * @Route("/teams", name="teams")
     */
    public function teamAction(Request $request){
        //$form = $this->createForm(new TeamType(), $post);
        return $this->render('admin/teams.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            
            ));
    }

    /**
     * New team action
     * @Route("/newteam", name="team_new")
     */
public function newTeamAction(Request $request)
   {
    $team = new Team();
    $em = $this->getDoctrine()->getManager();
    $users = $em->getRepository('AppBundle:User')->findBy(array('team' => null));
    foreach($users as $user)
    {
    $teamlessUsers[] = array($user->getUsername()=>$user->getUsername());
    }
     $form = $this->createForm(new TeamType(), $team, $users);

     $form->handleRequest($request);

     // the isSubmitted() method is completely optional because the other
     // isValid() method already checks whether the form is submitted.
     // However, we explicitly add it to improve code readability.
     // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
     if ($form->isSubmitted() && $form->isValid()) {
       $em = $this->getDoctrine()->getManager();
       $em->persist($team);
       $em->flush();

       return $this->redirectToRoute('teams');
     }
     return $this->render('admin/teams_new.html.twig', array(
       'team' => $team,
       'form' => $form->createView(),
     ));
   }
    

}
?>