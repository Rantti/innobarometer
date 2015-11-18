<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Team;
use AppBundle\Entity\Questionnaire;


/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */

class Project{
    /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;

  /**
   * @ORM\Column(type="string", length=255)
   */
  protected $projectName;

  /** @ORM\Column(type="datetime", name="startDate") */
  protected $startDate;

  /** @ORM\Column(type="datetime", name="endDate") */
  protected $endDate;


 
 /**
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Team", inversedBy="projects", onDelete="SET NULL" cascade={"all"})
  * @ORM\JoinTable(name="projects_teams")
  */
  protected $teams;

  /**
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Questionnaire", mappedBy="project")
   * @ORM\JoinTable(name="project_questionnaires")
   */
  protected $questionnaires;

  /**
   * @ORM\Column(type="integer")
   */
  protected $sprintRound;
  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set projectName
     *
     * @param string $projectName
     *
     * @return Project
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Project
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Project
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set sprintRound
     *
     * @param integer $sprintRound
     *
     * @return Project
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
     * Add questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Project
     */
    public function addQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaires[] = $questionnaire;

        return $this;
    }

    /**
     * Remove questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     */
    public function removeQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaires->removeElement($questionnaire);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }



    /**
     * Add team
     *
     * @param \AppBundle\Entity\Team $team
     *
     * @return Project
     */
    public function addTeam(\AppBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \AppBundle\Entity\Team $team
     */
    public function removeTeam(\AppBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
