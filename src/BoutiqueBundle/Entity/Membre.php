<?php

namespace BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Membre
 *
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\MembreRepository")
 */
class Membre
{
    /**
     * @var integer
     * @ORM\Column(name="id_membre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMembre;

    /**
     * @var string
     * @ORM\Column(name="pseudo", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $pseudo;

    /**
     * @var string
     * @ORM\Column(name="mdp", type="string", length=32, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $mdp;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="civilite", type="string", length=1, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $civilite;

    /**
     * @var string
     * @ORM\Column(name="ville", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $ville;

    /**
     * @var integer
     * @ORM\Column(name="code_postal", type="integer", nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $codePostal;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $adresse;

    /**
     * @var integer
     * @ORM\Column(name="statut", type="integer", nullable=false)
     */
    private $statut = '0';

    /**
     * Get idMembre
     *
     * @return integer
     */
    public function getIdMembre()
    {
        return $this->idMembre;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Membre
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return Membre
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Membre
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Membre
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Membre
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Membre
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Membre
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Membre
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Membre
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Membre
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
