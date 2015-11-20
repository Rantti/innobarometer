<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="project_team")
 */
class ProjectTeam{
/**
 * @ORM\Column(type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="projects")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     **/
protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="teams")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     **/
protected $project;


}