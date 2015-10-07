<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="statement")
 */
class Statement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $statementID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $statement;

    /**
     * @ORM\Column(type="string", scale=255)
     */
    protected $category;


    /**
     * Get statementID
     *
     * @return integer
     */
    public function getStatementID()
    {
        return $this->statementID;
    }

    /**
     * Set statement
     *
     * @param string $statement
     *
     * @return Statement
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * Get statement
     *
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Statement
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}
