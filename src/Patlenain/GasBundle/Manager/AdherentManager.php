<?php

namespace Patlenain\GasBundle\Manager;

use Doctrine\ORM\EntityManager;
use Patlenain\GasBundle\Entity\Adherent;

class AdherentManager {
	/**
	 * @var EntityManager
	 */
	protected $em;

	/**
	 * @param EntityManager $em
	 */
	public function __construct($em)
	{
		$this->em = $em;
	}

	/**
	 * @param string $nom
	 * @param string $prenom
	 * @param Annee $annee
	 * @return array
	 */
	public function listAdherents($nom = null, $prenom = null, $annee = null)
	{
		return $this->getRepository()
			->listAll($nom, $prenom, $annee)
			->getQuery()
			->getResult();
	}

	/**
	 * @param integer $id
	 * @return Adherent
	 */
	public function loadAdherent($id)
	{
		return $this->getRepository()->findOneBy(array('id' => $id));
	}

	/**
	 *
	 * @param Adherent $adherent
	 */
	public function saveAdherent($adherent)
	{
		$this->em->persist($adherent);
		$this->em->flush();
	}

	/**
	 * @param Adherent $adherent
	 */
	public function deleteAdherent($adherent)
	{
		$this->em->remove($adherent);
		$this->em->flush();
	}

	/**
	 * @param Adherent $adherent
	 * @return Adherent
	 */
	public function readhesion($adherent) {
		$copie = new Adherent();
		$copie->setNom($adherent->getNom());
		$copie->setPrenom($adherent->getPrenom());
		$copie->setAdresse($adherent->getAdresse());
		$copie->setCodePostal($adherent->getCodePostal());
		$copie->setVille($adherent->getVille());
		$copie->setEmail($adherent->getEmail());
		$copie->setDateNaissance($adherent->getDateNaissance());
		$copie->setDateAdhesion($adherent->getDateAdhesion());
		$copie->setAnnee($adherent->getAnnee());
		$this->em->persist($copie);
		$this->em->flush();
		return $copie;
	}

	/**
	 * @return AdherentRepository
	 */
	public function getRepository()
	{
		return $this->em->getRepository('PatlenainGasBundle:Adherent');
	}
}