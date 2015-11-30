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
use AppBundle\Entity\TeamMember;
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
      $em = $this->getDoctrine()->getManager();
      $teams = $em->getRepository('AppBundle:Team')->findAll();
      return $this->render('admin/teams.html.twig', array(
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        'teams' => $teams,
        ));
    }

    /**
     * New team action
     * @Route("/teams/new", name="team_new")
     */
    public function newTeamAction(Request $request)
    {
      $team = new Team();
      $em = $this->getDoctrine()->getManager();
      $form = $this->createForm(new TeamType($em), $team);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        foreach($form["users"]->getData() as $user){
          $member = new TeamMember();
          $member->setUser($user);
          $member->setRole("user");
          $member->setTeam($team);
          $team->addMember($member);
          $user->addTeam($member);
        }
        $em->persist($team);
        $em->flush();
        return $this->redirectToRoute('teams');
      }
      return $this->render('admin/teams_new.html.twig', array(
       'team' => $team,
       'form' => $form->createView(),
       ));
    }

    /**
  * Displays a form to edit an existing team entity.
  *
  * @Route("team/{id}/edit", requirements={"id" = "\d+"}, name="team_edit")
  * @Method({"GET", "POST"})
  */
    public function editAction(Team $team, Request $request)
    {

      $em = $this->getDoctrine()->getManager();

      $teamForm = $this->createFormBuilder($team)
      ->add('teamName', 'text', array('label' => 'label.teamName'))
      ->add('country', 'choice', array('choices' => array('FIN' => 'Finland', 'EST' => 'Estonia', 'NOR' => 'Norway', 'RU' => 'Russia', 'SWE' => 'Sweden'), 
        'required' => true,))
      ->getForm();


    $teamMembers = $team->getMembers();
    $users = array();
    foreach ($teamMembers as $teamMember) {
      $users[] = $teamMember->getUser();
    }
    $allUsers = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
    $choiceArray = array_diff($allUsers, $users);
    $memberForm = $this->createFormBuilder($team)

    ->add('users', 'entity', array(
            'class' => 'AppBundle:User',
            'choice_label' => 'username',
            'property' => 'user',
            'multiple' => 'true',
            'expanded' => 'true'
            ))


    ->add('save', 'submit', array('label' => 'Add Member'))
    ->getForm();

      $teamForm->handleRequest($request);


      if ($teamForm->isSubmitted() && $teamForm->isValid()) {
        $em->flush();
        return $this->render('admin/team/team_edit.html.twig', array(
        'team'    => $team,
        'teamForm'    => $teamForm->createView()
        ));
        }

      return $this->render('admin/team/team_edit.html.twig', array(
        'team'    => $team,
        'teamForm'    => $teamForm->createView()
        ));
    }
    /**
     * @Route("/team/removemember/{id}", name="removemember",
     * requirements = { "id" = "\d+" },
     * methods = { "GET", "POST" })
     *
     */
    public function memberRemoveAction(Request $request, TeamMember $member){
      $em = $this->getDoctrine()->getManager();
      $team = $member->getTeam();
      $team->removeMember($member);
      $user = $member->getUser();
      $user->removeTeam($member);
      $em->remove($member);
      $em->flush();
      return $this->redirectToRoute('team_edit', array(
        'id' => $team->getId()));
    }


  }
  ?>
