<?php

namespace Patlenain\GasBundle\Manager;

use Doctrine\ORM\EntityManager;

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
	 * @return array
	 */
	public function listAdherents()
	{
		return $this->getRepository()
			->listAll()
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
		$this->em->delete($adherent);
		$this->em->flush();
	}

	/**
	 * @return AdherentRepository
	 */
	public function getRepository()
	{
		return $this->em->getRepository('PatlenainGasBundle:Adherent');
	}
}