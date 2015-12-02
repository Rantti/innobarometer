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
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository('AppBundle:Questionnaire')->find($this->getRequest()->get('id'));
        $answers = $em->getRepository('AppBundle:Answer')->findBy(array('questionnaire' => $questionnaire));
        $averages = [];
        foreach ($answers as $answer){
            if (array_key_exists($answer->getStatement()->getStatement(), $averages)) {
                $old_avg = $averages[$answer->getStatement()->getStatement()];
                $averages[$answer->getStatement()->getStatement()] = ($old_avg + $answer->getValue())/2;
            }
            else{
                $averages[$answer->getStatement()->getStatement()]=$answer->getValue();
            }
        }
        $labels = [];
        foreach ($averages as $key => $value) {
            $labels[]=$key;
        }
        $chartValues = [];
        foreach ($averages as $key => $value) {
            $chartValues[]=$value;
        }
        return $this->render('graph/show.html.twig', array('answers'=>$answers, 'averages'=>$averages, 'labels'=>$labels, 'values'=>$chartValues));   
    }

    /**
     * @Route("/graphs/demos", name="demos")
     */
    public function demoAction(){
        return $this->render('graph/demo.html.twig');
    }
}
