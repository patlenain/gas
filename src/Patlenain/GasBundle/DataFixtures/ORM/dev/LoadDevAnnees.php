<?php
namespace Patlenain\GasBundle\DataFixtures\ORM\dev;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Patlenain\GasBundle\Entity\Annee;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadDevAnnees extends AbstractFixture implements OrderedFixtureInterface {

	/**
	 * @{inheritDoc}
	 */
	public function load(ObjectManager $manager) {
		// Année 1
		$annee = new Annee();
		$annee->setLibelle("Année 2013/2014");
		$manager->persist($annee);
		$this->addReference("annee-2013", $annee);
		// Année 2
		$annee = new Annee();
		$annee->setLibelle("Année 2012/2013");
		$manager->persist($annee);
		$this->addReference("annee-2012", $annee);
		// Flush
		$manager->flush();
	}

	public function getOrder() {
		return 101;
	}
}