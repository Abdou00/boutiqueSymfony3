<?php
namespace BoutiqueBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use BoutiqueBundle\Entity\Produit;
use BoutiqueBundle\Entity\Membre;
use BoutiqueBundle\Entity\Commande;
use BoutiqueBundle\Entity\DetailsCommande;

class AdminController extends Controller
{
    /**
     * @Route("/admin/product/show", name="showAllProducts")
    */
    public function allProductsAction()
    {
        // Produits
        $em = $this -> getDoctrine() -> getManager();
        $produits = $em -> getRepository(Produit::class) -> findAll();

        // Categories
        $em = $this -> getDoctrine() -> getManager();
        $query = $em -> createQuery('SELECT DISTINCT p.categorie FROM BoutiqueBundle\Entity\Produit p');

        $categories = $query -> getResult();


        // Paramètres
        $params = array(
            'produits' => $produits,
            'categories' => $categories
        );

        return $this -> render('@Boutique/Admin/allProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/{id}", name="showProduct")
    */
    public function showProductAction($id)
    {
         $em = $this -> getDoctrine() -> getManager();
        $produit = $em -> find(Produit::class, $id);

        $params = array(
            'title' => 'Dashboard',
            'produit' => $produit
        );

        return $this -> render('@Boutique/Admin/showProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/add", name="addProduct")
    */
    public function addProductAction(Request $request)
    {
        $product = new Produit;

        $form = $this -> get('form.factory') -> create(ProduitType::class, $product);

        if ($request -> isMethod('POST') && $form -> handleRequest($request) -> isValid()) {
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($product);
            $em -> flush();

            $request -> getSession() -> getFlashBag() -> add('sucess', "Le produit à bien à été ajouté !!");
            // return $this -> redirectToRoute('showProduct', array('id' => $product -> getId()));
        }

        $params = array(
            'title' => 'Ajouter produit',
            'productForm' => $form -> createView(),
        );

        return $this -> render('@Boutique/Admin/addProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/update/{id}", name="updateProduct")
    */
    public function updateProductAction($id)
    {
        return $this -> render('@Boutique/Admin/updateProduct.html.twig');
    }

    /**
     * @Route("/admin/product/delete/{id}", name="deleteProduct")
    */
    public function deleteProductAction($id)
    {
        return $this -> render('@Boutique/Admin/deleteProduct.html.twig');
    }
}
