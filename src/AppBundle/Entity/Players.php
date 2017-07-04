<?php 
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Players")
 */

class Players
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /* These 3 funcions below (getId, getName, getEmail) ARE mandatory to return PRIVATE variables EVEN if we don't use
    explicit in the query. In this example if we don't have these 3 funcions we won't have the
    3 variables because they are private: 

    $em = $this->getDoctrine()->getManager();

    $players = $em->getRepository('AppBundle:Players') ->findAll(); 

    */

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setNewPlayer($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}