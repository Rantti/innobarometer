<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Questionnaire\StatementType;
use AppBundle\Entity\Statement;

/**
 * @Route("/statement")
 * @author Turo Mikkonen
 */

class statementController extends controller {


  /**
  * Lists all statement entities.
  *
  * This controller responds to two different routes with the same URL:
  *   * 'statement_post_index' is the route with a name that follows the same
  *     structure as the rest of the controllers of this class.
  *   * 'statement_index' is a nice shortcut to the backend homepage. This allows
  *     to create simpler links in the templates. Moreover, in the future we
  *     could move this annotation to any other controller while maintaining
  *     the route name and therefore, without breaking any existing link.
  *
  * @Route("/statement", name="statement")
  * @Route("/statement_post", name="statement_post_index")
  * @Method("GET")
  */

  public function statementAction()
  {
    $em = $this->getDoctrine()->getManager();
    $statements = $em->getRepository('AppBundle:Statement')->findAll();

    return $this->render('Questionnaire/Statement/statements.html.twig', array('statements' => $statements));
  }

  /**
   * Creates new Statement entity.
   *
   * @Route("/new", name="statement_post_new")
   * @Method({"GET", "POST", "DELETE"})
   *
   * NOTE: the Method annotation is optional, but it's a recommended practice
   * to constraint the HTTP methods each controller responds to (by default
   * it responds to all methods).
   */
   public function newAction(Request $request)
   {
     $statement = new Statement();
     $form = $this->createForm(new StatementType(), $statement);

     $form->handleRequest($request);

     // the isSubmitted() method is completely optional because the other
     // isValid() method already checks whether the form is submitted.
     // However, we explicitly add it to improve code readability.
     // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
     if ($form->isSubmitted() && $form->isValid()) {
       $em = $this->getDoctrine()->getManager();
       $em->persist($statement);
       $em->flush();

       return $this->redirectToRoute('statement_post_index');
     }

     return $this->render('Questionnaire/Statement/new.html.twig', array(
       'statement' => $statement,
       'form' => $form->createView(),
     ));
   }

   /**
    * Finds and displays Statement entity.
    *
    * @Route("/{id}", requirements={"id" = "\d+"}, name="statement_post_show")
    * @Method("GET")
    */

   public function showAction(Statement $statement)
   {
     $deleteForm = $this->createDeleteForm($statement);

     return $this->render('Questionnaire/Statement/show.html.twig', array(
       'statement'   => $statement,
       'delete_form' => $deleteForm->createView(),
     ));
   }

   /**
    * Displays a form to edit an existing statement entity.
    *
    * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="statement_post_edit")
    * @Method({"GET", "POST"})
    */
   public function editAction(Statement $statement, Request $request)
   {
     $em = $this->getDoctrine()->getManager();

     $editForm = $this->createForm(new StatementType(), $statement);
     $deleteForm = $this->createDeleteForm($statement);

     $editForm->handleRequest($request);

     if ($editForm->isSubmitted() && $editForm->isValid()) {
       $em->flush();

       return $this->redirectToRoute('statement_post_edit', array('id' => $statement->getStatement_id()));
     }

     return $this->render('Questionnaire/Statement/edit.html.twig', array(
       'statement'    => $statement,
       'edit_form'    => $editForm->createView(),
       'delete_form'  => $deleteForm->createView(),
     ));
   }

   /**
    * Deletes a Statement entity.
    *
    * @Route("/{id}", name="statement_post_delete")
    * @Method("DELETE")
    *
    */
   public function deleteAction(Request $request, Statement $statement)
   {
     $form = $this->createDeleteForm($statement);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
       $em = $this->getDoctrine()->getManager();

       $em->remove($statement);
       $em->flush();
     }
     return $this->redirectToRoute('statement_post_index');
   }

   /**
    * Creates a form to delete a Statement entity by id.
    *
    * This is necessary because browsers don't support HTTP methods different
    * from GET and POST. Since the controller that removes the blog posts expects
    * a DELETE method, the trick is to create a simple form that *fakes* the
    * HTTP DELETE method.
    * See http://symfony.com/doc/current/cookbook/routing/method_parameters.html.
    *
    * @param  Statement $statement The statement object
    * @return \Symfony\Component\Form\Form The form
    */
   private function createDeleteForm(Statement $statement)
   {
     return $this->createFormBuilder()
          ->setAction($this->generateUrl('statement_post_delete', array('id' => $statement->getStatement_id())))
          ->setMethod('DELETE')
          ->getForm();
   }
}

?>
