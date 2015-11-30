<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="questionnaire")
*
* @author Antti Eloranta <antti.o.eloranta@gmail.com>
*/
class Questionnaire
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;


  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Statement", mappedBy="questionnaire")
  *
  * @Assert\Count(
  *      min = "5",
  *      max = "5",
  *      minMessage = "Only 5 statements per questionnaire. :(",
  *      maxMessage = "You cannot specify more than {{ limit }} statements"
  * )
  */
  protected $statements;

  /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Answer", mappedBy="questionnaire", cascade={"persist", "remove"})
   */
  protected $answers;

  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", mappedBy="questionnaire")
  */
  protected $projects;

  /**
  * @ORM\Column(type="integer")
  */
  protected $sprintRound;

  /**
  * @ORM\Column(type="integer")
  */
  protected $extraRound;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sprintRound
     *
     * @param integer $sprintRound
     *
     * @return Questionnaire
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
     * @param integer $extraRound
     *
     * @return Questionnaire
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

    /**
     * Add statement
     *
     * @param \AppBundle\Entity\Statement $statement
     *
     * @return Questionnaire
     */
    public function addStatement(\AppBundle\Entity\Statement $statement)
    {
        $this->statements[] = $statement;

        return $this;
    }

    /**
     * Remove statement
     *
     * @param \AppBundle\Entity\Statement $statement
     */
    public function removeStatement(\AppBundle\Entity\Statement $statement)
    {
        $this->statements->removeElement($statement);
    }

    /**
     * Get statements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Questionnaire
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
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Questionnaire
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
