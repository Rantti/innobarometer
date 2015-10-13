<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Statement;
use AppBundle\Entity\Answer;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
* @Route("/answer")
* @author Antti Eloranta <anttioeloranta@gmail.com>
*/

class AnswerController extends Controller
{
    /**
     * @Route("/", name="answer")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        /**
         * get all questionnaires for the user
         * then list them
         */
        $em = $this->getDoctrine()->getManager();
        $questionnaires = $em->getRepository('AppBundle:Questionnaire')->findAll();



        return $this->render('Questionnaire/Answer/answer.html.twig', array('questionnaires' => $questionnaires));
    }

    /**
     * @Route("/show", name="showanswers")
     */
    public function showAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('AppBundle:Answer')->findAll();
        return $this->render('Questionnaire/Answer/show.html.twig', array('answers' => $answers));
    }


    /**
     * @Route("/form", name="answerform")
     */
    public function answerAction(Request $request)
    {   
        $id = $this->getRequest()->get('id');
        $em = $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository('AppBundle:Questionnaire')->find($id);
        $statements = $questionnaire->getStatements();
        return $this->render('Questionnaire/Answer/form.html.twig', array('statements' => $statements, 'id' => $id));
    }
    /**
     * @Route("/post", name="postnew")
     * @Method("POST")
     */
    public function postAnswerAction(Request $request)
    {
        $qid = $this->get('request')->request->get('questionnaireid');
        
            //$qid = $post->request->get('questionnaireid');
        $em = $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository('AppBundle:Questionnaire')->find($qid);
        $statements = $questionnaire->getStatements();
        foreach ($statements as $statement) {
            $answer = new Answer();
            $answer->setStatement($statement);
                // $value = $post->request->get($statement->getId());
            $value = $this->get('request')->request->get($statement->getId());
            $answer->setValue($value);
            $answer->setQuestionnaire($questionnaire);
            $em->persist($answer);
            $em->flush();
        }
        return $this->redirectToRoute('answer');

        
    }

}



?>