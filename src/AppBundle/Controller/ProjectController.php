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
     * @Route("/projects/{id}/remove", name="project_remove")
     */
}
?>