<?php
namespace Patlenain\GasBundle\Manager;

use Doctrine\ORM\EntityManager;
use Patlenain\GasBundle\Entity\Utilisateur;
use Patlenain\GasBundle\Entity\UtilisateurRepository;

class UtilisateurManager
{
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
	public function listAll()
	{
		return $this->getRepository()
			->listAll()
			->getQuery()
			->getResult();
	}

	/**
	 * @param integer $id
	 * @return Utilisateur
	 */
	public function loadUtilisateur($id)
	{
		return $this->getRepository()->findOneBy(array('id' => $id));
	}

	/**
	 *
	 * @param Utilisateur $utilisateur
	 */
	public function saveUtilisateur($utilisateur)
	{
		$this->em->persist($utilisateur);
		$this->em->flush();
	}

	/**
	 * @param Utilisateur $utilisateur
	 */
	public function deleteUtilisateur($utilisateur)
	{
		$this->em->remove($utilisateur);
		$this->em->flush();
	}

	/**
	 * @return UtilisateurRepository
	 */
	public function getRepository()
	{
		return $this->em->getRepository('PatlenainGasBundle:Utilisateur');
	}
}