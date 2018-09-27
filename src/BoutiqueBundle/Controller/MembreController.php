<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use BoutiqueBundle\Entity\Membre;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MembreController extends Controller
{
    /**
     * @Route("/register", name="register")
    */
    public function registerAction(Request $request)
    {
        $membre = new Membre;

        // $formBuilder = $this -> get('form.factory') -> createBuilder(FormType::class, $membre);
        /**
         * $formBuilder
         * -> add('pseudo', TextType::class)
         * -> add('mdp', PasswordType)
         * ...
        */
        // $form = $this -> createForm(MembreType::class, $membre);

        $form = $this -> createFormBuilder($membre)
            -> add('pseudo', TextType::class)
            -> add('mdp', PasswordType::class)
            -> add('nom', TextType::class)
            -> add('prenom', TextType::class)
            -> add('email', TextType::class)
            -> add('civilite', ChoiceType::class, array(
                'choices'  => array(
                    'Monsieur' => 'm',
                    'Madame' => 'f'
                )
            ))
            -> add('ville', TextType::class)
            -> add('codePostal', NumberType::class)
            -> add('adresse', TextType::class)
            -> add('save', SubmitType::class, array('label' => 'Inscription'))
            -> getForm();

            $form -> handleRequest($request);

            if($form -> isSubmitted() && $form -> isValid()){

                $membre = $form -> getData();

                $em = $this -> getDoctrine() -> getManager();
                // Préparation de l'insertion d'un membre en bdd elle sera executer au prochain "flush"
                $em -> persist($membre);
                // On insère tous ce qui était persisté(persist)
                $em -> flush();
                $request -> getSession() -> getFlashBag() -> add('success', 'Félicitation vous êtes maintenant inscrit. Vous pouvez dès à présent vous');
                return $this -> redirectToRoute("login");
            }

        /**
         *  $membre -> setPseudo('sam');
         *  $membre -> setMdp('1234567890');
         *  $membre -> setNom('dia');
         *  $membre -> setPrenom('sam');
         *  $membre -> setEmail('sam@gmail.com');
         *  $membre -> setCivilite('m');
         *  $membre -> setVille('pantin')
         *  $membre -> setCodePostal(93500);
         *  $membre -> setAdresse('142 av. Jean Jauès');
         *  $membre -> setStatut(1);
        */

        $params = array(
            'form' => $form -> createView(),
            'title' => 'Inscription'
        );

        return $this -> render('@Boutique/Membre/register.html.twig', $params);
    }

    /**
     * @Route("login", name="login")
    */
    public function loginAction()
    {
        $params = array(
            'title' => 'Connexion'
        );
        return $this -> render('@Boutique/Membre/login.html.twig', $params);
    }

    /**
     * @Route("/member/update/{id}")
    */
    public function memberUpdateAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $membre = $em -> find(Membre::class, $id);

        $membre -> setPrenom('Sam');
        $em -> persist($membre);
        $em -> flush();

        return new Response("OK le  " . $id ." à bien été modifié");
        // Tester: localhost:8000/member/update/id
    }

    /**
     * @Route("/member/delete/{id}")
    */
    public function memberDeleteAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $membre = $em -> find(Membre::class, $id);

        $em -> remove($membre);
        $em -> flush();

        return new Response("Le membre " . $id . "à bien été supprimer");
    }
}
