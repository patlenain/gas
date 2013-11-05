<?php

namespace Patlenain\GasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

/**
 * Adherent
 *
 * @ORM\Table(name="adherent")
 * @ORM\Entity(repositoryClass="Patlenain\GasBundle\Entity\AdherentRepository")
 */
class Adherent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     * @Constraints\NotBlank()
     * @Constraints\Length(max="50")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     * @Constraints\NotBlank()
     * @Constraints\Length(max="50")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Constraints\NotBlank
     * @Constraints\Length(max="255")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5)
     * @Constraints\NotBlank
     * @Constraints\Length(max="5")
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     * @Constraints\NotBlank
     * @Constraints\Length(max="255")
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     * @Constraints\Length(max="50")
     * @Constraints\Email()
     */
    private $email;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_naissance", type="date")
     * @Constraints\NotNull()
     * @Constraints\Date()
     */
    private $dateNaissance;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_adhesion", type="date", nullable=true)
     * @Constraints\Date()
     */
    private $dateAdhesion;

    /**
     * @var \Date
     *
     * @Orm\Column(name="numero_fixe", type="string", length=15, nullable=true)
     * @Constraints\Length(max="15")
     */
    private $numeroFixe;

    /**
     * @var \Date
     *
     * @Orm\Column(name="numero_portable", type="string", length=15, nullable=true)
     * @Constraints\Length(max="15")
     */
    private $numeroPortable;

    /**
     * @var Annee
     *
     * @ORM\ManyToOne(targetEntity="Annee")
     * @ORM\JoinColumn(name="annee_id", referencedColumnName="id", nullable=false)
     * @Constraints\NotNull
     */
    private $annee;

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
     * Set nom
     *
     * @param string $nom
     * @return Adherent
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Adherent
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Adherent
     */
    public function setAdresse($adresse)
    {
    	$this->adresse = $adresse;

    	return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
    	return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Adherent
     */
    public function setCodePostal($codePostal)
    {
    	$this->codePostal = $codePostal;

    	return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
    	return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Adherent
     */
    public function setVille($ville)
    {
    	$this->ville = $ville;

    	return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
    	return $this->ville;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Adherent
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateNaissance
     *
     * @param \Date $dateNaissance
     * @return Adherent
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \Date
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateAdhesion
     *
     * @param \Date $dateAdhesion
     * @return Adherent
     */
    public function setDateAdhesion($dateAdhesion)
    {
        $this->dateAdhesion = $dateAdhesion;

        return $this;
    }

    /**
     * Get dateAdhesion
     *
     * @return \Date
     */
    public function getDateAdhesion()
    {
        return $this->dateAdhesion;
    }

    /**
     * Set numeroFixe
     *
     * @param string $numeroFixe
     * @return Adherent
     */
    public function setNumeroFixe($numeroFixe)
    {
        $this->numeroFixe = $numeroFixe;

        return $this;
    }

    /**
     * Get numeroFixe
     *
     * @return string
     */
    public function getNumeroFixe()
    {
        return $this->numeroFixe;
    }

    /**
     * Set numeroPortable
     *
     * @param string $numeroPortable
     * @return Adherent
     */
    public function setNumeroPortable($numeroPortable)
    {
        $this->numeroPortable = $numeroPortable;

        return $this;
    }

    /**
     * Get numeroPortable
     *
     * @return string
     */
    public function getNumeroPortable()
    {
        return $this->numeroPortable;
    }

    /**
     * Set annee
     *
     * @param Annee $annee
     * @return Adherent
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return Annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }
}
