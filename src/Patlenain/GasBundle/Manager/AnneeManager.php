<?php

namespace Patlenain\GasBundle\Manager;

use Doctrine\ORM\EntityManager;
use Patlenain\GasBundle\Entity\Annee;

class AnneeManager {
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
	 * @return array
	 */
	public function listAnnees()
	{
		return $this->getRepository()
			->listAll()
			->getQuery()
			->getResult();
	}

	/**
	 * @return Annee
	 */
	public function getDerniereAnnee()
	{
		return $this->getRepository()
			->getDerniereAnnee()
			->getQuery()
			->getScalarResult();
	}

	/**
	 * @param integer $id
	 * @return Annee
	 */
	public function loadAnnee($id)
	{
		return $this->getRepository()->findOneBy(array('id' => $id));
	}

	/**
	 *
	 * @param Annee $annee
	 */
	public function saveAnnee($annee)
	{
		$this->em->persist($annee);
		$this->em->flush();
	}

	/**
	 * @param Annee $annee
	 */
	public function deleteAnnee($annee)
	{
		$this->em->remove($annee);
		$this->em->flush();
	}

	/**
	 * @return AnneeRepository
	 */
	public function getRepository()
	{
		return $this->em->getRepository('PatlenainGasBundle:Annee');
	}
}