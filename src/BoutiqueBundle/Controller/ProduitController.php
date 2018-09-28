<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use BoutiqueBundle\Entity\Produit;

class ProduitController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        // Ici on récupère les données de la table produit
        // Méthode 1: On récupère le repository d'une entité précise
        // $repository = $this -> getDoctrine() -> getRepository('BoutiqueBundle\Entity\Produit');
        // Ou
        $repository = $this -> getDoctrine() -> getRepository(Produit::class);
        // Ici on stocke les données dans la variable $produits
        $produits = $repository->findAll();

        // Méthode 2: Pour récupèrer tous les répository
        // $em = $this -> getDoctrine() -> getManager();
        // $produits = $em -> getRepository(Produit::class) -> findAll();

         // Récupère les catégories(sans doublon)
         $em = $this -> getDoctrine() -> getManager();
         // /!\ Attention toujours utiliser les alias
         $query = $em -> createQuery('SELECT DISTINCT p.categorie FROM BoutiqueBundle\Entity\Produit p');
         $categories = $query -> getResult();

        $params = array(
            'produits' => $produits,
            'categories' => $categories,
            'title' => 'Accueil'
        );
        return $this->render('@Boutique/Produit/index.html.twig', $params);
    }

    /**
     * On créé une route pour les catégories
     * @Route("/categorie/{slug}", name="categorie")
    */
    public function categorieAction($slug)
    {
        $repository = $this -> getDoctrine() -> getRepository(Produit::class);
        $produits = $repository -> findBy(['categorie' => $slug]);

        // Récupère les catégories(sans doublon)
        $em = $this -> getDoctrine() -> getManager();
        // /!\ Attention toujours utiliser les alias
        $query = $em -> createQuery('SELECT DISTINCT p.categorie FROM BoutiqueBundle\Entity\Produit p');
        $slugs = $query -> getResult();

        $params = array(
            'produits' => $produits,
            'categories' => $slug,
            'title' => 'Catégorie ' . $slug
        );
        return $this->render('@Boutique/Produit/index.html.twig', $params);
    }

    /**
     * On créé une route pour les produits
     * @Route("/produit/{id}", name="produit")
    */
    public function produitAction($id)
    {
        // Méthode 1
        $repository = $this -> getDoctrine() -> getRepository(Produit::class);
        $produit = $repository -> find($id);

        // Méthode 2
        // $em = $this -> getDoctrine() -> getManager();
        // $produit = $em -> find(Produit::class, $id);

        // Méthode 1: On récupère les suggestions
        // $suggestions = $repository -> findBy(['categorie' => $produit -> getCategorie()]);

        // Méthode 2
        // On récupère les suggestions aavec une requête créé en php(queryBuilder)
        $em = $this -> getDoctrine() -> getManager();
        $query = $em -> createQueryBuilder();
        $query
            -> select('p')
            -> from(Produit::class, 'p')
            -> where('p.categorie = :categorie')
            -> orderby('p.prix', 'DESC')
            -> setParameter('categorie', $produit -> getCategorie());

        $suggestions = $query -> getQuery() -> getResult();

        $params = array(
            'produit' => $produit,
            'suggestions' => $suggestions,
            'title' => 'Produit: ' . $produit -> getTitre()
        );

        return $this -> render('@Boutique/Produit/produit.html.twig', $params);
    }
}
