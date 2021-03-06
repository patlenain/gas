<?php

namespace Patlenain\GasBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * AdherentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdherentRepository extends EntityRepository
{
	/**
	 * @return QueryBuilder
	 */
	function listAll($nom = null, $prenom = null, $annee = null)
	{
		$query = $this->createQueryBuilder('adherent');
		if ($nom) {
			$query->andWhere('lower(adherent.nom) like :nom')
				->setParameter('nom', '%'.strtolower($nom).'%');
		}
		if ($prenom) {
			$query->andWhere('lower(adherent.prenom) like :prenom')
				->setParameter('prenom', '%'.strtolower($prenom).'%');
		}
		if ($annee) {
			$query->andWhere('adherent.annee = :annee')
				->setParameter('annee', $annee);
		}
		return $query
			->addOrderBy('adherent.nom', 'ASC')
			->addOrderBy('adherent.prenom', 'ASC');
	}
}
