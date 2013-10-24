<?php
namespace Patlenain\GasBundle\DataFixtures\ORM\initial;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Patlenain\GasBundle\Entity\Utilisateur;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAdminUser implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {
	/**
	 * @var ContainerInterface
	 */
	var $container;

	/**
	 * @{inheritDoc}
	 */
	public function load(ObjectManager $manager) {
		$userAdmin = new Utilisateur();
		$userAdmin->setUsername("admin");
		$userAdmin->setNom("Administrateur");
		$userAdmin->setEmail("root");
		$encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
		$userAdmin->setPassword($encoder->encodePassword('Password1', $userAdmin->getSalt()));
		$userAdmin->setAdmin(true);
		$manager->persist($userAdmin);
		$manager->flush();
	}

	public function getOrder() {
		return 1;
	}

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

}
