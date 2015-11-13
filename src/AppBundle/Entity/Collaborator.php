<?php 


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Antti Eloranta <antti.o.eloranta@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="collaborator")
 */
class Collaborator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="collaborators")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="projects")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * */
    protected $team;


     



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
     * @param \AppBundle\Entity\Project $project
     *
     * @return Collaborator
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set team
     *
     * @param \AppBundle\Entity\Team $team
     *
     * @return Collaborator
     */
    public function setTeam(\AppBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \AppBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}