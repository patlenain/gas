<?php
namespace Patlenain\GasBundle\DataFixtures\ORM\dev;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Patlenain\GasBundle\Entity\Adherent;

class LoadDevAdherents extends AbstractFixture implements OrderedFixtureInterface {

	/**
	 * @{inheritDoc}
	 */
	public function load(ObjectManager $manager) {
		// Adhérent 1
		$adherent = new Adherent();
		$adherent->setNom("Nom 1");
		$adherent->setPrenom("Prenom 1");
		$adherent->setEmail("email@localhost");
		$adherent->setAdresse("1bis rue de la Fosse");
		$adherent->setCodePostal("44000");
		$adherent->setVille("Nantes");
		$adherent->setDateNaissance(\DateTime::createFromFormat("Y-m-d", "1980-07-15"));
		$adherent->setDateAdhesion(\DateTime::createFromFormat("Y-m-d", "2013-09-20"));
		$adherent->setAnnee($this->getReference("annee-2013"));
		$manager->persist($adherent);
		// Adhérent 2
		$adherent = new Adherent();
		$adherent->setNom("Nom 2");
		$adherent->setPrenom("Prenom 2");
		$adherent->setEmail("email2@localhost");
		$adherent->setAdresse("Appartement 12\n17 Paul Bellamy");
		$adherent->setCodePostal("44000");
		$adherent->setVille("Nantes");
		$adherent->setDateNaissance(\DateTime::createFromFormat("Y-m-d", "1970-01-13"));
		$adherent->setDateAdhesion(\DateTime::createFromFormat("Y-m-d", "2013-10-25"));
		$adherent->setAnnee($this->getReference("annee-2013"));
		$manager->persist($adherent);
		// Flush
		$manager->flush();
	}

	public function getOrder() {
		return 102;
	}
}