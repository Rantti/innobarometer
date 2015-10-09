<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Statement;

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
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Statement", mappedBy="statements")
  */
  protected $statements;

  public function __construct(){
    $this->statements = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
  * Add statements
  * @param AppBundle\Entity\Statement $statements
  */

  public function addStatement(Statement $statement)
  {
      if (!$this->statements->contains($statement)){
          $this->statements->add($statement);
        }
      return $this;
  }

  /**
   * Get Statements
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getStatements()
  {
    return $this->statements;
  }

  /**
   * Remove statements
   * @param  AppBundle\Entity\Statement $statements
   * @return AppBundle\Entity\Statement
   */
  public function removeStatement(Statement $statement)
  {
      if ($this->statements->contains($statement)){
          $this->statements->remove($statement);
        }
  }


  /**
   * Get questionnaire
   *
   * @return \AppBundle\Entity\Questionnaire
   */
  public function getQuestionnaire()
  {
      return $this->questionnaire;
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
  public function getQuestionnaire_id()
  {
    return $this->questionnaire_id;
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
