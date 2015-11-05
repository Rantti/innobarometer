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


class GraphController extends Controller
{

    /**
     * @Route("/graphs", name="graphs")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $questionnaires = $em->getRepository('AppBundle:Questionnaire')->findAll();
        return $this->render('default/graph.html.twig', array('questionnaires'=>$questionnaires));
    }

    /**
     * @Route("/graphs/{id}/show", name="graph_show")
     */
    public function showAction(Questionnaire $Questionnaire)
    {
        
        // $projects = array();    
        // foreach ($userprojects as $userproject) {
        //     $projects[] = $userproject->getProject();
        // }
    }
}
