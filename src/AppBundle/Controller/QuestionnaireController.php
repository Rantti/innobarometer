<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Questionnaire\QuestionnaireType;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Statement;
use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @Route("/questionnaire")
* @author Turo Mikkonen <turo.mikkonen@gmail.com>
*/

class QuestionnaireController extends controller {
  /**
  * Lists all questionnaire entities.
  *
  * This controller responds to two different routes with the same URL:
  *   * 'questionnaire_post_index' is the route with a name that follows the same
  *     structure as the rest of the controllers of this class.
  *   * 'questionnaire_index' is a nice shortcut to the backend homepage. This allows
  *     to create simpler links in the templates. Moreover, in the future we
  *     could move this annotation to any other controller while maintaining
  *     the route name and therefore, without breaking any existing link.
  *
  * @Route("/questionnaire", name="questionnaire")
  * @Route("/questionnaire_post", name="questionnaire_post_index")
  * @Method("GET")
  */
  public function questionnaireAction()
  {
    $em = $this->getDoctrine()->getManager();
    $questionnaires = $em->getRepository('AppBundle:Questionnaire')->findAll();

    return $this->render('Questionnaire/questionnaire.html.twig', array('questionnaires' => $questionnaires));
  }

  /**
  * Creates new questionnaire entity.
  *
  * @Route("/new", name="questionnaire_post_new")
  * @Method({"GET", "POST", "DELETE"})
  *
  * NOTE: the Method annotation is optional, but it's a recommended practice
  * to constraint the HTTP methods each controller responds to (by default
  * it responds to all methods).
  */
  public function newAction(Request $request)
  {
    $questionnaire = new Questionnaire();
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(new QuestionnaireType($em), $questionnaire);

    $form->handleRequest($request);

    // the isSubmitted() method is completely optional because the other
    // isValid() method already checks whether the form is submitted.
    // However, we explicitly add it to improve code readability.
    // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
    if ($form->isSubmitted() && $form->isValid()) {

      $projects = $form["projects"]->getData();

      foreach ($projects as $project) {
        $id = $project->getId();
        $dbProject = $em->getRepository('AppBundle:Project')->find($id);

        if (!$dbProject) {
          throw $this-createNotFoundException(
          'No $dbProject found for id '.$id);
        }
        $dbProject->addQuestionnaire($questionnaire);
      }

      $statements = $form["statements"]->getData();

      foreach ($statements as $statement) {
        $id = $statement->getId();
        $dbStatement = $em->getRepository('AppBundle:Statement')->find($id);

        if (!$dbStatement) {
          throw $this-createNotFoundException(
          'No dbStatement found for id '.$id);
        }
        $dbStatement->addQuestionnaire($questionnaire);

      }

      $em->persist($questionnaire);
      $em->flush();

      return $this->redirectToRoute('questionnaire_post_index');
    }

    return $this->render('Questionnaire/new.html.twig', array(
      'questionnaire' => $questionnaire,
      'form' => $form->createView(),
    ));
  }

  /**
  * Finds and displays Questionnaire entity.
  *
  * @Route("/{id}", requirements={"id" = "\d+"}, name="questionnaire_post_show")
  * @Method("GET")
  */

  public function showAction(Questionnaire $questionnaire)
  {
    $deleteForm = $this->createDeleteForm($questionnaire);

    return $this->render('Questionnaire/show.html.twig', array(
      'questionnaire'   => $questionnaire,
      'delete_form'     => $deleteForm->createView(),
    ));
  }

  /**
  * Displays a form to edit an existing questionnaire entity.
  *
  * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="questionnaire_post_edit")
  * @Method({"GET", "POST"})
  */
  public function editAction(Questionnaire $questionnaire, Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $editForm = $this->createForm(new QuestionnaireType(), $questionnaire);
    $deleteForm = $this->createDeleteForm($questionnaire);
    $oldStatements = new ArrayCollection();
    foreach ($questionnaire->getStatements() as $statement) {
      $oldStatements->add($statement);
    }

    $editForm->handleRequest($request);


    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $statements = $editForm["statements"]->getData();
      foreach ($oldStatements as $statement) {
        if (false === $questionnaire->getStatements()->contains($statement)) {
          $statement->getQuestionnaire()->removeElement($questionnaire);

          $em->persist($statement);
        }
      }

      foreach ($statements as $statement) {

        $id = $statement->getId();
        $dbStatement = $em->getRepository('AppBundle:Statement')->find($id);
        if ($em->getRepository('AppBundle:Statement')) {
          $dbStatement->addQuestionnaire($questionnaire);
        }
      }
      $em->persist($questionnaire);
      $em->flush();
      return $this->redirectToRoute('questionnaire_post_edit', array('id' => $questionnaire->getId()));
    }

    return $this->render('Questionnaire/edit.html.twig', array(
      'questionnaire'    => $questionnaire,
      'edit_form'    => $editForm->createView(),
      'delete_form'  => $deleteForm->createView(),
    ));
  }

  /**
  * Deletes a Questionnaire entity.
  *
  * @Route("/{id}", name="questionnaire_post_delete")
  * @Method("DELETE")
  *
  */
  public function deleteAction(Request $request, Questionnaire $questionnaire)
  {
    $form = $this->createDeleteForm($questionnaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      $em->remove($questionnaire);
      $em->flush();
    }
    return $this->redirectToRoute('questionnaire_post_index');
  }

  /**
  * Creates a form to delete a Questionnaire entity by id.
  *
  * This is necessary because browsers don't support HTTP methods different
  * from GET and POST. Since the controller that removes the blog posts expects
  * a DELETE method, the trick is to create a simple form that *fakes* the
  * HTTP DELETE method.
  * See http://symfony.com/doc/current/cookbook/routing/method_parameters.html.
  *
  * @param  Questionnaire $questionnaire The questionnaire object
  * @return \Symfony\Component\Form\Form The form
  */
  private function createDeleteForm(Questionnaire $questionnaire)
  {
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('questionnaire_post_delete', array('id' => $questionnaire->getId())))
    ->setMethod('DELETE')
    ->getForm();
  }
}

?>
