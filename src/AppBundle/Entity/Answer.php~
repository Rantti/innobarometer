<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="answer")
 *
 * @author  Antti Eloranta <anttioeloranta@gmail.com>
 */
class Answer{
/**
 * @ORM\Column(type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="answers")
     * @ORM\JoinColumn(name="questionnaire_id", referencedColumnName="id", nullable=FALSE)
     **/
protected $questionnaire;

    /**
     * @ORM\ManyToOne(targetEntity="Statement")
     * @ORM\JoinColumn(name="statement_id", referencedColumnName="id", nullable=FALSE)
     **/
protected $statement;
    /**
     * @ORM\Column(type="integer")
     */
protected $value;
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
     * Set value
     *
     * @param integer $value
     *
     * @return Answer
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Answer
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
     * Set statement
     *
     * @param \AppBundle\Entity\Statement $statement
     *
     * @return Answer
     */
    public function setStatement(\AppBundle\Entity\Statement $statement = null)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * Get statement
     *
     * @return \AppBundle\Entity\Statement
     */
    public function getStatement()
    {
        return $this->statement;
    }
}
