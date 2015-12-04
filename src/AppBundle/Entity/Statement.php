<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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

  //TARVITAAN
  //
  //oma id (decima/string)
  //
  //class (sc_engineering_wtf eli category oikeastaan)
  //
  //indicator (en tiedä en muista :-D)

  /**
  * @ORM\Column(type="string", length=255)
  */
  protected $external_id;


  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Questionnaire", inversedBy="statements")
  * @ORM\JoinTable(name="questionnaire_statements")
  */
  protected $questionnaire;

  /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Answer", mappedBy="statement", cascade={"persist", "remove"})
   */
  protected $answers;


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

  public function __toString()
  {
      return strval($this->id);
  }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Statement
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set externalId
     *
     * @param string $externalId
     *
     * @return Statement
     */
    public function setExternalId($externalId)
    {
        $this->external_id = $externalId;

        return $this;
    }

    /**
     * Get externalId
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }
}
