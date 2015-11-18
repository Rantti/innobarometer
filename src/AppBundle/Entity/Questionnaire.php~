<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Statement;
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
   * @ORM\OneToMany(targetEntity="Assignment", mappedBy="questionnaire")
   */
  protected $assignedUsers;

  /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Answer", mappedBy="questionnaire", cascade={"persist", "remove"}, orphanRemoval=TRUE)
   */
  protected $answers;
  /**
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", inversedBy="questionnaires")
  * @ORM\JoinTable(name="project_questionnaires")
  */
  protected $project;

  /**
  * @ORM\Column(type="integer")
  */
  protected $sprintRound;

  /**
  * @ORM\Column(type="integer")
  */
  protected $extraRound;



  public function __construct(){
    $this->statements = new \Doctrine\Common\Collections\ArrayCollection();
    $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Questionnaire
     */
    public function addProject(Project $project)
    {
        if (!$this->project->contains($project)){
          $this->project->add($project);
        }
      return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(Project $project)
    {
        if ($this->project->contains($project)){
          $this->project->remove($project);
        }
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProject()
    {
        return $this->project;
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
     * Add assignedUser
     *
     * @param \AppBundle\Entity\Assignment $assignedUser
     *
     * @return Questionnaire
     */
    public function addAssignedUser(\AppBundle\Entity\Assignment $assignedUser)
    {
        $this->assignedUsers[] = $assignedUser;

        return $this;
    }

    /**
     * Remove assignedUser
     *
     * @param \AppBundle\Entity\Assignment $assignedUser
     */
    public function removeAssignedUser(\AppBundle\Entity\Assignment $assignedUser)
    {
        $this->assignedUsers->removeElement($assignedUser);
    }

    /**
     * Get assignedUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignedUsers()
    {
        return $this->assignedUsers;
    }
}
