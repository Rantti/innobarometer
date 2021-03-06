<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;
use AppBundle\Entity\Project;
use AppBundle\Entity\Questionnaire;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 *
 * @author  Antti Eloranta <anttioeloranta@gmail.com>
 */

class Team
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=6)
     * @var string 
     */
    protected $inviteToken;
    
    /**
     * name of the team
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $teamName;

    /**
     * team-country
     * @var string
     * @ORM\Column(type="string", length=255)
     *
     */
    protected $country;


    /**
    * @ORM\OneToMany(targetEntity="TeamMember" , mappedBy="team", cascade={"persist", "remove"})
    * */
    protected $members;

      /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", mappedBy="teams")
        */
  protected $projects;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set teamName
     *
     * @param string $teamName
     *
     * @return Team
     */
    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;

        return $this;
    }

    /**
     * Get teamName
     *
     * @return string
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Team
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add member
     *
     * @param \AppBundle\Entity\TeamMember $member
     *
     * @return Team
     */
    public function addMember(\AppBundle\Entity\TeamMember $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \AppBundle\Entity\TeamMember $member
     */
    public function removeMember(\AppBundle\Entity\TeamMember $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Team
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

    /**
     * Set inviteToken
     *
     * @param string $inviteToken
     *
     * @return Team
     */
    public function setInviteToken($inviteToken)
    {
        $this->inviteToken = $inviteToken;

        return $this;
    }

    /**
     * Get inviteToken
     *
     * @return string
     */
    public function getInviteToken()
    {
        return $this->inviteToken;
    }
}
