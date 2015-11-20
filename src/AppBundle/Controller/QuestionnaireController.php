<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Questionnaire\QuestionnaireType;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Statement;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

   if ($form->isSubmitted() && $form->isValid()) {

     $em->persist($questionnaire);
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

     $editForm->handleRequest($request);

     if ($editForm->isValid()) {
        $ihanVittuKaikki = $em->getRepository('AppBundle:Statement')->findAll();
        foreach ($ihanVittuKaikki as $vittuSaatana) {
          if($vittuSaatana->getQuestionnaire()->contains($questionnaire)){
            $vittuSaatana->removeQuestionnaire($questionnaire);
          }
          $questionnaire->clearStatements();
        }
        foreach ($questionnaire->getStatements() as $statement) {
        $statement->addQuestionnaire($questionnaire);
        $questionnaire->addStatement($statement);
      }
        $em->flush();  

      // $repository = $this->getDoctrine()->getRepository('AppBundle:Statement');
      // $query = $repository->createQueryBuilder('s')
      // ->where('s.questionnaire > :price')
      // ->setParameter('price', '19.99')
      // ->orderBy('s.price', 'ASC')
      // ->getQuery();

      // $products = $query->getResult();
      // $statements = $editForm["statements"]->getData();
      // $oldQ = $em->getRepository('AppBundle:Questionnaire')->find($questionnaire->getId());
      // $oldStatements = $oldQ->getStatements();
      // foreach ($oldStatements as $oldStatement) {
      //   $oldStatement->getQuestionnaire()->clear();
      //   $questionnaire->removeStatement($oldStatement);
      // }
      
      // $questionnaire->clearStatements();
      // foreach ( $statements as $statement) {
      //   $questionnaire->addStatement($statement);
      //   $statement->addQuestionnaire($questionnaire);
      // }
      // $em->flush();
      return $this->redirectToRoute('questionnaire');
    }

    foreach ($questionnaire->getStatements() as $statement) {
        $statement->getQuestionnaire()->clear();
      }
    $questionnaire->clearStatements();
    return $this->render('Questionnaire/edit.html.twig', array(
     'edit_form'    => $editForm->createView(),
     'delete_form'  => $deleteForm->createView(),
     'questionnaire' => $questionnaire,
     ));
  }

  private function deleteCollections($em, $init, $final)
{
   $em = $this->getDoctrine()->getManager();
    if (empty($init)) {
        return;
    }

    if (!$final->getStatements() instanceof \Doctrine\ORM\PersistentCollection) {
        foreach ($init['statements'] as $addr) {
            $em->remove($addr);
        }
    }
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
