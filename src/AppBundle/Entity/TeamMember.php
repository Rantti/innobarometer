<?php 


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Antti Eloranta <antti.o.eloranta@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="team_member")
 */
class TeamMember
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="team")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="members")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * */
    protected $team;

    /**
     * @ORM\Column(name="role", type="text")
     */
     private $role;

     /**
      * Does the user have a certain role
      *
      * @return boolean
      */
     public function isRole($roleToCheck){
        if ($this->role == $roleToCheck){
            return True;
        }
        else{
            return False;
        }
     }
     


}
