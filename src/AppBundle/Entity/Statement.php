<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Questionnaire;

/**
 * @author Turo Mikkonen <turo.mikkonen@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="statement")
 */
class Statement
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;

  /**
  * @ORM\OneToMany(targetEntity="Assignment", inversedBy="statement")
  *
  */
  protected $questionnaire;



  public function __construct()
  {
    $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
  }
  /**
  * Add questionnaires
  * @param AppBundle\Entity\Questionnaire $questionnaires
  */

  public function addQuestionnaire(Questionnaire $questionnaire)
  {
      if (!$this->questionnaire->contains($questionnaire)){
          $this->questionnaire->add($questionnaire);
        }
      return $this;
  }

  /**
   * Remove questionnaire
   * @param  AppBundle\Entity\Questionnaire $questionnaires
   * @return AppBundle\Entity\Questionnaire
   */
  public function removeQuestionnaire(Questionnaire $questionnaire)
  {
      if ($this->questionnaire->contains($questionnaire)){
          $this->questionnaire->remove($questionnaire);
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
  * @ORM\Column(type="string", length=255)
  */
  protected $statement;

  /**
  * @ORM\Column(type="string", scale=255)
  */
  protected $category;


  /**
  * Get $id
  *
  * @return integer
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set statement
  *
  * @param string $statement
  *
  * @return Statement
  */
  public function setStatement($statement)
  {
    $this->statement = $statement;

    return $this;
  }

  /**
  * Get statement
  *
  * @return string
  */
  public function getStatement()
  {
    return $this->statement;
  }

  /**
  * Set category
  *
  * @param string $category
  *
  * @return Statement
  */
  public function setCategory($category)
  {
    $this->category = $category;

    return $this;
  }

  /**
  * Get category
  *
  * @return string
  */
  public function getCategory()
  {
    return $this->category;
  }
}
