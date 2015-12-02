<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AnswerType;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Statement;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\TeamMember;
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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {

        /**
         * get all questionnaires for the user
         * then list them
         */
        $em = $this->getDoctrine()->getManager();

        $inviteForm = $this->createFormBuilder()
          ->add('id', 'text', array('label' => 'Team id'))
          ->add('save', 'submit', array('label' => 'Submit'))
          ->getForm();
          $inviteForm->handleRequest($request);
          if ($inviteForm->isSubmitted() && $inviteForm->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $team = $em->getRepository('AppBundle:Team')->find($inviteForm["id"]->getData());
          if (!$team) {
            $this->get('session')->getFlashBag()->add(
            'danger',
            'No team found!'
        );
          return $this->redirectToRoute('answer');
          }
          $membership = new TeamMember();
          $membership->setUser($this->getUser());
          $membership->setTeam($team);
          $membership->setRole("user");
          $em->persist($membership);
          $this->getUser()->addTeam($membership);
          $team->addMember($membership);
          $em->flush();
          $this->get('session')->getFlashBag()->add(
            'notice',
            'Joined new team succesfully!'
        );
    }

        $userTeams = $this->getUser()->getTeams();
        $questionnaires = Array();
        foreach ($userTeams as $membership) {
          foreach ($membership->getTeam()->getProjects() as $project){
            if ($project->getQuestionnaire() != null )
              foreach ($project->getQuestionnaire() as $q){
                if (!in_array($q, $questionnaires)) {
                  $questionnaires[] = $q;
                }

              }
            }
          }
          
    

          return $this->render('Questionnaire/Answer/answer.html.twig', array('questionnaires' => $questionnaires, 'inviteForm' => $inviteForm->createView()));
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


      /**
      * Creates new answer entity.
      *
      * @Route("/new", name="answer_post_new")
      * @Method({"GET", "POST", "DELETE"})
      *
      * NOTE: the Method annotation is optional, but it's a recommended practice
      * to constraint the HTTP methods each controller responds to (by default
      * it responds to all methods).
      */
      public function newAction(Request $request)
      {
        $answer = new Answer();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new AnswerType($em), $answer);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {

          $questionnaire = $form["questionnaire"]->getData();
          $id = $questionnaire->getId();
          $dbQuestionnaire = $em->getRepository('AppBundle:Questionnaire')->find($id);

          if (!$dbQuestionnaire) {
            throw $this-createNotFoundException(
              'No $dbQuestionnaire found for id '.$id);
          }
          $dbQuestionnaire->addAnswer($answer);

          $statements = $form["statements"]->getData();

          foreach ($statements as $statement) {
            $id = $statement->getId();
            $dbStatement = $em->getRepository('AppBundle:Statement')->find($id);

            if (!$dbStatement) {
              throw $this-createNotFoundException(
                'No dbStatement found for id '.$id);
            }
            $dbStatement->addAnswer($answer);

          }

          $em->persist($answer);
          $em->flush();

          return $this->redirectToRoute('answer');
        }

        return $this->render('Questionnaire/Answer/new.html.twig', array(
          'answer' => $answer,
          'form' => $form->createView(),
          ));
      }



    /**
     * Displays a form to edit an existing answer entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="answer_post_edit")
     * @Method({"GET", "POST"})
     */
    public function EditAnswer(Answer $answer, Request $request)
    {
      // $id = $this->getRequest()->get('id');
      // $em = $this->getDoctrine()->getManager();
      // $questionnaire = $em->getRepository('AppBundle:Questionnaire')->find($id);
      // $statements = $questionnaire->getStatements();
      // return $this->render('Questionnaire/Answer/form.html.twig', array('statements' => $statements, 'id' => $id));

      $em = $this->getDoctrine()->getManager();

      $editForm = $this->createForm(new AnswerType(), $answer);
      $deleteForm = $this->createDeleteForm($answer);

      $editForm->handleRequest($request);

      if($editForm->isSubmitted() && $editForm->isValid()) {
        $em->flush();

        return $this->redirectToRoute('answer_post_edit', array('id' => $answer->getId()));
      }

      return $this->render('Questionnaire/Answer/edit.html.twig', array(
        'answer'    => $answer,
        'edit_form'    => $editForm->createView(),
        'delete_form'  => $deleteForm->createView(),
        ));
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
