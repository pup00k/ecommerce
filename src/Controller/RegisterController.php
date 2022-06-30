<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;

class RegisterController extends AbstractController
{
    private $EntityManager; // Initaliser une V doctrine Manager de cotrine pour nos ma,ipulation

    public function __construct(EntityManagerInterface $EntityManager){ // fonction construct dedans ->  inject entity manager interface
        $this->EntityManager = $EntityManager;}


    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {

            $user =  new User();
            $form = $this->createForm(RegisterType::class, $user);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $user = $form->getData();

                $password = $encoder->hashPassword($user,$user->getPassword()); // Le user va prendre le password, pour Hashed appel la methode encodepassword, avec 1er user et deuxièeme mdp
                // dd($password);

                $user->setPassword($password);

                // $doctrine = $this->getDoctrine()->getManager(); // On apelle doctrine avec le get et le manager
                $this->EntityManager->persist($user); // use la premier methode persist prend en para, persist notre enité user, fige la data parce que besoin de l'enregistrer
                $this->EntityManager->flush(); // flush est comme un execute, tu execute le persiste de la data  qui est figé.
            }

        return $this->render('register/index.html.twig', [
            'form' => $form ->createView()
        ]);
    }
}
