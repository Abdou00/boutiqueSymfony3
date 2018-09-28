<?php
namespace BoutiqueBundle\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use BoutiqueBundle\Entity\Produit;
use BoutiqueBundle\Entity\Membre;
use BoutiqueBundle\Entity\Commande;
use BoutiqueBundle\Entity\DetailsCommande;
use BoutiqueBundle\Form\ProduitType;

class AdminController extends Controller
{
    /**
     * @Route("/admin/products/show", name="showAllProducts")
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
     * @Route("/admin/product/add", name="addProduct")
    */
    public function addProductAction(Request $request)
    {
        $product = new Produit();
        $form = $this -> get('form.factory') -> create(ProduitType::class, $product);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Le produit à bien été ajouter.");

            return $this->redirectToRoute('showProducts', array('id' => $product -> getId()));
        }

        $params = array(
            'title' => 'Ajouter produit',
            'productForm' => $form -> createView(),
        );

        return $this -> render('@Boutique/Admin/addProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/show/{id}", name="showProduct")
    */
    public function showProductAction($id)
    {
        $repository = $this -> getDoctrine() -> getRepository(Produit::class);
        $produit = $repository -> find($id);

        $params = array(
            'title' => 'Dashboard',
            'produit' => $produit
        );

        return $this -> render('@Boutique/Admin/showProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/update/{id}", name="updateProduct")
    */
    public function updateProductAction(Request $request, $id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $product = $em -> getRepository(Produit::class) -> find($id);

        if (!$product) {
            throw $this -> createNotFoundException(
                'Aucun produit trouver pour l\'id: ' . $id
            );
        }

        $form = $this -> createForm(ProduitType::class, $product, array(
            'action' => $this -> generateUrl('updateProduct', array('id' => $id)),
            'method' => 'PUT'
        ));

        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $em -> persist($product);
            $em -> flush();

            $request->getSession()->getFlashBag()->add('success', "Le produit à bien été modifier.");

            return $this -> redirectToRoute('showProduct', array('id' => $id));
         }

        $params = array(
            'title' => 'Modifier',
            'updateProductForm' => $form -> createView(),
            'poduct' => $product
        );
        return $this -> render('@Boutique/Admin/updateProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/delete/{id}", name="deleteProduct")
    */
    public function deleteProductAction($id)
    {
        return $this -> render('@Boutique/Admin/deleteProduct.html.twig');
    }
}
