<?php
namespace BoutiqueBundle\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
            'title' => 'Tous les produits',
            'produits' => $produits,
            'categories' => $categories
        );

        return $this -> render('@Boutique/Admin/allProduct.html.twig', $params);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() réduit la similarité des noms de fichiers générés par
        // uniqid(), qui est basé sur les horodatages
        return md5(uniqid());
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
            // $file stocke le fichier téléchargé
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $product->getPhoto();

            $fileName = $this -> generateUniqueFileName() . '.' . $file -> guessExtension();

            // Déplace le fichier dans le répertoire où sont stockées les images(images_directory) qui est défini dans app/config/config.yml(parameters)
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // Gérer les exceptions si quelque chose se produit pendant le téléchargement du fichier
                $request->getSession()->getFlashBag()->add('success', "Une erreur est survenu lors du chargement du fichier!");
            }

            // met à jour la propriété 'photo' pour stocker le nom du fichier
            // au lieu de son contenu
            $product->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Le produit à bien été ajouter.");
            return $this->redirectToRoute('showAllProducts');
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
            'title' => 'produit' . $produit,
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
            'title' => 'Modifier ' . $product,
            'updateProductForm' => $form -> createView(),
            'poduct' => $product
        );
        return $this -> render('@Boutique/Admin/updateProduct.html.twig', $params);
    }

    /**
     * @Route("/admin/product/delete/{id}", name="deleteProduct")
    */
    public function deleteProductAction(Request $request, $id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $product = $em -> find(Produit::class, $id);

        $em -> remove($product);
        $em -> flush();

        $request->getSession()->getFlashBag()->add('success', "Le pro$request->getSession()->getFlashBag()->add('success', "Le produit à bien été modifier.");duit ' . $id . ' à bien été supprimer.");
        return $this -> redirectToRoute('showAllProducts');
        // return $this -> render('@Boutique/Admin/deleteProduct.html.twig');
    }
}
