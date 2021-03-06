<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Team;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @author  Antti Eloranta <antti.o.eloranta@gmail.com>
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="TeamMember", mappedBy="user", cascade={"remove", "persist"})
     * */
    protected $teams;

    public function __construct(){
        parent::__construct();

    }

    /**
     * Add team
     *
     * @param \AppBundle\Entity\TeamMember $team
     *
     * @return User
     */
    public function addTeam(\AppBundle\Entity\TeamMember $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \AppBundle\Entity\TeamMember $team
     */
    public function removeTeam(\AppBundle\Entity\TeamMember $team)
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
