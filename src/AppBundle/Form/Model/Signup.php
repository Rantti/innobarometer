<?php 
namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\User;

class Signup
{
    /**
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
?>