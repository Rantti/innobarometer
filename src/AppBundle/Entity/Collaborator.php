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
