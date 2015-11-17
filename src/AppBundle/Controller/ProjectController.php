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
use AppBundle\Entity\Collaborator;
use AppBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProjectController extends Controller
{

 /**
     * @Route("/projects", name="projects")
     */
    public function teamAction(Request $request){
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
    public function newTeamAction(Request $request)
    {
        $project = new Project();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ProjectType($em), $project);
        $form->handleRequest($request);

     // the isSubmitted() method is completely optional because the other
     // isValid() method already checks whether the form is submitted.
     // However, we explicitly add it to improve code readability.
     // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setStartDate($form["startDate"]->getData());
            $project->setEndDate($form["endDate"]->getData());
            
         $teams = $form["teams"]->getData();
         foreach($teams as $team){
            $projectCollaborator = new Collaborator();
            $projectCollaborator->setTeam($team);
            $projectCollaborator->setProject($project);
            $team->addProject($projectCollaborator);
            $project->addCollaborator($projectCollaborator);
            $em->persist($projectCollaborator);
        }
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('projects');
    }
    return $this->render('admin/project/project_new.html.twig', array(
     'project' => $project,
     'form' => $form->createView(),
     ));
}
}
?>