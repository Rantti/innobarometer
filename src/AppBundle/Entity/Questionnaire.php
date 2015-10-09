<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="questionnaire")
*/
class Questionnaire
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $questionnaire_id;

  /**
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Statement", inversedBy="questionnaires")
  * @ORM\JoinTable(name="questionnaires_statements",
  * 		joinColumns={@ORM\JoinColumn(name="questionnaire_id", referencedColumnName="questionnaire_id")},
 *      inverseJoinColumns={@ORM\JoinColumn(name="statement_id", referencedColumnName="statement_id")})
  */
  private $statements;

  /**
   * add statements
   *
   * @param AppBundle\Entity\Statement $statement
   */

  public function addStatements(AppBundle\Entity\Statement $statement){
    $this->statements[] = $statements;
  }

  /**
   * Get statements
   * @return Doctrine\Common\Collections\Collection
   */
  public function getStatements()
  {
    return $this->statements;
  }

  /**
  * @ORM\Column(type="integer")
  */
  protected $sprintRound;

  /**
  * @ORM\Column(type="integer")
  */
  protected $extraRound;


  /**
  * Get questionnaire_id
  *
  * @return integer
  */
  public function getQuestionnaireID()
  {
    return $this->questionnaireID;
  }

  /**
  * Set sprintRound
  *
  * @return integer SprintRound
  */
  public function setSprintRound($sprintRound)
  {
    $this->sprintRound = $sprintRound;

    return $this;
  }

  /**
  * Get sprintRound
  *
  * @return integer
  */
  public function getSprintRound()
  {
    return $this->sprintRound;
  }

  /**
  * Set extraRound
  *
  * @return SprintRound
  */
  public function setExtraRound($extraRound)
  {
    $this->extraRound = $extraRound;

    return $this;
  }

  /**
  * Get extraRound
  *
  * @return integer
  */
  public function getExtraRound()
  {
    return $this->extraRound;
  }
}
?>
