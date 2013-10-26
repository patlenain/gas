<?php

namespace Patlenain\GasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints;

/**
 * Patlenain\GasBundle\Entity\Utilisateur
 *
 * @ORM\Table("utilisateur")
 * @ORM\Entity(repositoryClass="Patlenain\GasBundle\Entity\UtilisateurRepository")
 * @UniqueEntity(fields = "username")
 */
class Utilisateur implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=32, unique=true)
     * @Constraints\NotBlank
     * @Constraints\Length(min=3, max=32)
     * @Constraints\Regex(pattern="/^[a-z0-9]+$/",
     * 		message="patlenain_gas.utilisateur.usernameRegex")
     */
    private $username;

    /**
     * @var string $name
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Constraints\NotBlank
     * @Constraints\Length(min=3, max=255)
     */
    private $nom;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Constraints\NotBlank
     * @Constraints\Email
     * @Constraints\Length(max=255)
     */
    private $email;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=32)
     * @Constraints\NotNull
     */
    private $salt;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=128)
     * @Constraints\Length(min=6)
     * @Constraints\Regex(pattern="/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",
     * 		message="patlenain_gas.utilisateur.passwordStrength")
     */
    private $password;

    /**
     * @var boolean $admin
     *
     * @ORM\Column(name="admin", type="boolean")
     * @Constraints\NotNull
     */
    private $admin;

    public function __construct()
    {
    	$this->salt = md5(uniqid(null, true));
    	$this->admin = false;
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
     * @return string
     */
    public function getUsername()
    {
    	return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
    	$this->username = $username;
    }

    /**
     * @return string
     */
    public function getNom()
    {
    	return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
    	$this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
    	return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
    	$this->email = $email;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
    	return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
    	$this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
    	return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
    	$this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
    	return $this->admin;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin($admin)
    {
    	$this->admin = $admin;
    }

    public function eraseCredentials()
    {
    	// Ne pas effacer le mot de passe, sinon la
    	// fonctionnalité Remember me ne fonctionne plus
    }

    /**
     * @return array
     */
    public function getRoles()
    {
    	if ($this->admin)
    	{
    		return array('ROLE_USER', 'ROLE_ADMIN');
    	}
    	else
    	{
    		return array('ROLE_USER');
    	}
    }
}