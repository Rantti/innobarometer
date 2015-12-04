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
      $this->get('session')->getFlashBag()->add(
            'notice',
            'User was removed succesfully.'
        );
      return new RedirectResponse("users");
    }

    /**
     * @Route("/removeteam", name="removeteam",
     * requirements = { "id" = "\d+" },
     * methods = { "GET" })
     *
     */
    public function teamRemoveAction(Request $request){
      $id = $this->getRequest()->get('id');
      $team = $this->getDoctrine()->getRepository('AppBundle:Team')->find($id);
      $members = $team->getMembers();
      foreach ($members as $member) {
        $member->getUser()->removeTeam($member);
        $em->remove($member);

      }
      $em->remove($team);
      $em->flush;
      $this->get('session')->getFlashBag()->add(
            'notice',
            'Team was removed succesfully!'
        );
      return new RedirectResponse("teams");
    }


    /**
     * @Route("/teams", name="teams")
     */
    public function teamAction(Request $request){
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

        $team->setInviteToken(substr(uniqid(),0,6));

        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'New team was created succesfully!'
        );
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

      $teamForm = $this->get("form.factory")->createNamedBuilder("teamForm", "form", $team)
      ->add('teamName', 'text', array('label' => 'Team Name'))
      ->add('country', 'choice', array('choices' => array('FIN' => 'Finland', 'EST' => 'Estonia', 'NOR' => 'Norway', 'RU' => 'Russia', 'SWE' => 'Sweden'),
        'required' => true,))
      // ->add('save', 'submit', array('label' => 'Save Changes'))
      ->getForm();


    $teamMembers = $team->getMembers();
    $users = array();
    foreach ($teamMembers as $teamMember) {
      $users[] = $teamMember->getUser();
    }
    $allUsers = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
    $choiceArray = array_diff($allUsers, $users);
    $memberForm = $this->get("form.factory")->createNamedBuilder("memberForm")
    ->add('user', 'entity', array(
      'class' => 'AppBundle:User',
      'property' => 'username',
      'choices' => $choiceArray,
      ))
    ->add('save', 'submit', array('label' => 'Add Member',
      'attr' => array('class' => 'btn btn-primary')))
    ->getForm();

    if('POST' === $request->getMethod()) {

        if ($request->request->has('memberForm')) {
        $memberForm->handleRequest($request);
        $newMember = new TeamMember();
        $newUser = $memberForm['user']->getData();
        $newMember->setUser($newUser);
        $newMember->setTeam($team);
        $newMember->setRole("user");
        $newUser->addTeam($newMember);
        $team->addMember($newMember);
        $em->persist($newMember);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'New member was added succesfully!'
        );
        }

        if ($request->request->has('teamForm')) {
        $teamForm->handleRequest($request);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Your changes were saved!'
        );
        }
    }

      return $this->render('admin/team/team_edit.html.twig', array(
        'team'    => $team,
        'teamForm'    => $teamForm->createView(),
        'memberForm' => $memberForm->createView()
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
      $this->get('session')->getFlashBag()->add(
            'notice',
            'User was removed succesfully!'
        );
      return $this->redirectToRoute('team_edit', array(
        'id' => $team->getId()));
    }


  }
  ?>
