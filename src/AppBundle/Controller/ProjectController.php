<?php

namespace AppBundle\Controller;
/**
 * @author  Antti Eloranta <anttioeloranta+work@gmail.com>
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Team;
use AppBundle\Entity\Project;

use AppBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Collections\ArrayCollection;

class ProjectController extends Controller
{

 /**
     * @Route("/projects", name="projects")
     */
 public function projectAction(Request $request){
        //$form = $this->createForm(new TeamType(), $post);
    $em = $this->getDoctrine()->getManager();
    $projects = $em->getRepository('AppBundle:Project')->findAll();
    return $this->render('admin/project/projects.html.twig', array(
        'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        'projects' => $projects,
        ));
}

    /**
     * New project action
     * @Route("/projects/new", name="project_new")
     */
    public function newProjectAction(Request $request)
    {
        $project = new Project();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ProjectType(), $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project);
         $em->flush();
         return $this->redirectToRoute('projects');
     }
     return $this->render('admin/project/project_new.html.twig', array(
         'project' => $project,
         'form' => $form->createView(),
         ));
 }


/**
  * Displays a form to edit an existing questionnaire entity.
  *
  * @Route("/project/{id}/edit", requirements={"id" = "\d+"}, name="project_edit")
  * @Method({"GET", "POST"})
  */
  public function editProjectAction(Project $project, Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $editForm = $this->createForm(new ProjectType(), $project);
    $oldTeams = new ArrayCollection();
    foreach ($project->getTeams() as $team) {
      $oldTeams->add($team);
    }

    $editForm->handleRequest($request);


    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $teams = $editForm["teams"]->getData();
      foreach ($oldTeams as $team) {
        if (false === $project->getTeams()->contains($team)) {
          $team->getProject()->removeElement($project);

          $em->persist($team);
        }
      }

      foreach ($teams as $team) {

        $id = $team->getId();
        $dbTeam = $em->getRepository('AppBundle:Team')->find($id);
        if ($em->getRepository('AppBundle:Team')) {
          $dbTeam->addProject($project);
        }
      }
      $em->persist($project);
      $em->flush();
      return $this->redirectToRoute('projects', array('id' => $project->getId()));
    }

    return $this->render('admin/project/edit.html.twig', array(
      'project'    => $project,
      'edit_form'    => $editForm->createView(),
    ));
  }

    /**
     * @Route("/project/{id}/delete", name="project_delete",
     * requirements = { "id" = "\d+" },
     * methods = { "GET" })
     *
     */
    public function projectRemoveAction(Request $request){
        $em = $this->getDoctrine()->getManager();
      $id = $this->getRequest()->get('id');
      $project = $this->getDoctrine()->getRepository('AppBundle:Project')->find($id);
      $teams = $project->getTeams();
      foreach ($teams as $team) {
        $team->removeProject($project);
      }
      $em->remove($project);
      $em->flush();
      $this->get('session')->getFlashBag()->add(
            'notice',
            'Project was removed succesfully!'
        );
      return $this->redirectToRoute('projects');
    }
}
?>