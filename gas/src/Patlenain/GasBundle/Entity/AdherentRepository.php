<?php

namespace Patlenain\GasBundle\Entity;

use Doctrine\ORM\EntityRepository;

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
	function listAll()
	{
		return $this->createQueryBuilder('adherent')
			->addOrderBy('adherent.nom', 'ASC')
			->addOrderBy('adherent.prenom', 'ASC');
	}
}