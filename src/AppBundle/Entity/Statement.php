<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
  protected $statement_id;

  /**
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Questionnaire", mappedBy="statements")
  */

  private $questionnaires;

  /**
  * Add questionnaires
  * @param AppBundle\Entity\Questionnaire $questionnaires
  */

  public function addQuestionnaires(AppBundle\Entity\Questionnaire $questionnaires)
  {
    $item->addStatement($this);
    $this->questionnaires[] = $questionnaire;
  }


  /**
  * Get Questionnaires
  * @return Doctrine\Common\Collections\Collection
  */

  public function getQuestionnaires()
  {
    return $this->questionnaires;
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
  * Get $statement_id
  *
  * @return integer
  */
  public function getStatement_id()
  {
    return $this->statement_id;
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
