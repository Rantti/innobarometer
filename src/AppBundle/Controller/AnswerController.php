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
use AppBundle\Controller\QuestionnaireController;

/**
* @Route("/answer")
* @author Antti Eloranta <anttioeloranta@gmail.com>
* @author Turo Mikkonen <turo.mikkonen@gmail.com>
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
        $userTeams = $this->getUser()->getTeams();
        $questionnaires = Array();
        foreach ($userTeams as $membership) {
          foreach ($membership->getTeam()->getProjects() as $project){
            if ($project->getQuestionnaire() != null )
            foreach ($project->getQuestionnaire() as $q){
              $questionnaires[] = $q;
            }
          }
        }
        //$questionnaires = $em->getRepository('AppBundle:Questionnaire')->findAll();



        return $this->render('Questionnaire/Answer/answer.html.twig', array('questionnaires' => $questionnaires));
    }

    /**
     * Finds and displays Answer entity.
     *
     * @Route("/show", name="showanswers")
     * @Method("GET")
     */
    public function showAction(){
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('AppBundle:Answer')->findAll();
        return $this->render('Questionnaire/Answer/show.html.twig', array(
          'answers' => $answers,
        ));
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
    public function EditAnswer(Answer $answer, $statements, Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $editForm = $this->createForm(new AnswerType(), $answer);
      $deleteForm = $this->createDeleteForm($answer);

      $editForm->handleRequest($request);

      if($editForm->isSubmitted() && $editForm->isValid()) {
        $em->flush();

        $questionnaire = $editForm["questionnaire"]->getData();
        return $this->redirectToRoute('answer_post_edit', array('id' => $statement , ));

      }
    }

  /**
   * Deletes Answer entity.
   * @Route("/{id}", name="answer_post_delete")
   * @Method("DELETE")
   */
    public function deleteAction(Request $request, Answer $answer)
    {
      $form = $this->createDeleteForm($answer);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        $em->remove($answer);
        $em->flush();
      }
      return $this->redirectToRoute('answer');
    }

  /**
   * Creates a form to delete Answer entity by id.
   * @param  Answer $answer The answer object
   * @return \Symfony\Component\Form the form
   */
    private function createDeleteForm(Answer $answer)
    {
      return $this->createFormBuilder()
        ->setAction($this->generateUrl('answer_post_delete', array('id' => $answer->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }

}



?>
