<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AssignmentType;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Assignment;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * @Route("\assignment")
 * @author Turo Mikkonen <turo.mikkonen@gmail.com>
 */
class AssignmentController extends Controller
{
  /**
   * Lists questionnaires and the teams/projects that you can
   * assign those questionnaires to.
   * @Route("/assign", name="assign")
   * @Route("assignment_post", name="assignment_post_index")
   * @Method("GET")
   */
  public function assignmentAction()
  {
    $em = $this->getDoctrine()->getManager();
    $assignment = $em->getRepository('AppBundle:Assignment')->findAll();

    return $this->render('');
  }
}






 ?>
