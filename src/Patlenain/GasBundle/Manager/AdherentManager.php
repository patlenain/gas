<?php

namespace Patlenain\GasBundle\Manager;

use DateTime;
use Doctrine\ORM\EntityManager;
use Patlenain\GasBundle\Entity\Adherent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Translation\Translator;

class AdherentManager {
	/**
	 * @var EntityManager
	 */
	protected $em;

	/**
	 * @var Translator
	 */
	protected $translator;

	/**
	 * @param EntityManager $em
	 * @param Translator $translator
	 */
	public function __construct($em, $translator)
	{
		$this->em = $em;
		$this->translator = $translator;
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
		$copie->setNumeroFixe($adherent->getNumeroFixe());
		$copie->setNumeroPortable($adherent->getNumeroPortable());
		$copie->setDateNaissance($adherent->getDateNaissance());
		$copie->setDateAdhesion($adherent->getDateAdhesion());
		$copie->setAnnee($adherent->getAnnee());
		$this->em->persist($copie);
		$this->em->flush();
		return $copie;
	}

	/**
	 * @param Annee $annee
	 * @return string
	 */
	public function exportAdherents($annee) {
		$adherents = $this->listAdherents(null, null, $annee);
		$handle = fopen('php://temp', 'r+');

		// Entêtes
		$header = array(
			$this->translator->trans('patlenain_gas.adherent.nom'),
			$this->translator->trans('patlenain_gas.adherent.prenom'),
			$this->translator->trans('patlenain_gas.adherent.email'),
			$this->translator->trans('patlenain_gas.adherent.adresse'),
			$this->translator->trans('patlenain_gas.adherent.codePostal'),
			$this->translator->trans('patlenain_gas.adherent.ville'),
			$this->translator->trans('patlenain_gas.adherent.numeroFixe'),
			$this->translator->trans('patlenain_gas.adherent.numeroPortable'),
			$this->translator->trans('patlenain_gas.adherent.dateNaissance'),
			$this->translator->trans('patlenain_gas.adherent.dateAdhesion'),
			$this->translator->trans('patlenain_gas.adherent.annee')
		);
		fputcsv($handle, $header);

		// Lignes
		foreach ($adherents as $adherent) {
			$strDateAdhesion = '';
			if ($adherent->getDateAdhesion()) {
				$strDateAdhesion = $adherent->getDateAdhesion()->format('d/m/Y');
			}
			$line = array(
				$adherent->getNom(),
				$adherent->getPrenom(),
				$adherent->getEmail(),
				$adherent->getAdresse(),
				$adherent->getCodePostal(),
				$adherent->getVille(),
				$adherent->getNumeroFixe(),
				$adherent->getNumeroPortable(),
				$adherent->getDateNaissance()->format('d/m/Y'),
				$strDateAdhesion,
				$adherent->getAnnee()->getLibelle()
			);
			fputcsv($handle, $line);
		}

		// Fermeture et obtention des données
		rewind($handle);
		$content = stream_get_contents($handle);
		fclose($handle);

		return $content;
	}

	/**
	 * @param UploadedFile $fichier
	 * @return number
	 */
	public function importAdherents($annee, $fichier) {
		$this->em->beginTransaction();
		try {
			$nbLignes = 0;
			$handle = fopen($fichier->getRealPath(), "r");
			$headers = fgetcsv($handle);
			while (($data = fgetcsv($handle))) {
				$adherent = new Adherent();
				$adherent->setNom($data[0]);
				$adherent->setPrenom($data[1]);
				$adherent->setEmail($data[2]);
				$adherent->setAdresse($data[3]);
				$adherent->setCodePostal($data[4]);
				$adherent->setVille($data[5]);
				$adherent->setNumeroFixe($data[6]);
				$adherent->setNumeroPortable($data[7]);
				$dateNaissance = DateTime::createFromFormat("d/m/Y", $data[8]);
				$adherent->setDateNaissance($dateNaissance);
				$dateAdhesion = null;
				if ($data[9]) {
					$dateAdhesion = DateTime::createFromFormat("d/m/Y", $data[9]);
				}
				$adherent->setDateNaissance($dateNaissance);
				$adherent->setAnnee($annee);
				$this->em->persist($adherent);
				$nbLignes++;
			}
			$this->em->commit();
			fclose($handle);
		}
		catch (\Exception $e) {
			$this->em->rollback();
			fclose($handle);
			throw $e;
		}
		return $nbLignes;
	}

	/**
	 * @return AdherentRepository
	 */
	public function getRepository()
	{
		return $this->em->getRepository('PatlenainGasBundle:Adherent');
	}
}