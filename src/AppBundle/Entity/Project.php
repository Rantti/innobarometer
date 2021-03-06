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
  protected $project;

  /** @ORM\Column(type="datetime", name="startDate") */
  protected $startDate;

  /** @ORM\Column(type="datetime", name="endDate") */
  protected $endDate;

    /**
   * @var \Doctrine\Common\Collections\ArrayCollection
  * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Team", inversedBy="projects")
  * @ORM\JoinTable(name="teams_projects")
  */
  protected $teams;

  /**
   * @var \Doctrine\Common\Collections\ArrayCollection
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Questionnaire", inversedBy="projects")
   * @ORM\JoinTable(name="questionnaire_projects")
   */
  protected $questionnaire;

  /**
   * @ORM\Column(type="integer")
   */
  protected $sprintRound;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaire = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set project
     *
     * @param string $project
     *
     * @return Project
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return string
     */
    public function getProject()
    {
        return $this->project;
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

    /**
     * Add questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Project
     */
    public function addQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaire[] = $questionnaire;

        return $this;
    }

    /**
     * Remove questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     */
    public function removeQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaire->removeElement($questionnaire);
    }

    /**
     * Get questionnaire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
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
}
