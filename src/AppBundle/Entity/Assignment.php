<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Turo Mikkonen <turo.mikkonen@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="assignment")
 */

class Assignment
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="assignedUsers")
   * @ORM\JoinColumn(name="questionnaire_id", referencedColumnName="id")
   */
  protected $questionnaire;

  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="assignments")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\Column(name="assigned", type="boolean")
   */
  protected $assigned;

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
     * Set assigned
     *
     * @param boolean $assigned
     *
     * @return Assignment
     */
    public function setAssigned($assigned)
    {
        $this->assigned = $assigned;

        return $this;
    }

    /**
     * Get assigned
     *
     * @return boolean
     */
    public function getAssigned()
    {
        return $this->assigned;
    }

    /**
     * Set questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Assignment
     */
    public function setQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Assignment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
