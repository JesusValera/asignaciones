<?php

namespace JVRUserBundle\Controller;

use JVRUserBundle\Entity\User;
use JVRUserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        // Obtener el manager que hace de puente con la base de datos.
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("JVRUserBundle:User")->findAll();

//        // Video 5 - ORM Doctrine.
//        //Mostrar datos.
//        $res = 'Lista de usuarios: <br/>';
//        /** @var User $user */
//
//        foreach ($users as $user)
//        {
//            $res .= 'Usuario: ' . $user->getUsername() . ' - Email: ' . $user->getEmail() . '<br/>';
//        }
//
//        return new Response($res);

        // Video 6 - Twig.

        return $this->render('JVRUserBundle:User:index.html.twig', ['users' => $users]);

    }

    // Video 8 (formularios).
    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);

        return $this->render('JVRUserBundle:User:add.html.twig', ['form' => $form->createView()]);
    }

    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity,
            [
                'action' => $this->generateUrl('jvr_user_create'),
                'method' => 'POST',
            ]);

        return $form;
    }

    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $password = $form->get('password')->getData();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);

            $user->setPassword($encoded);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('jvr_user_index');
        }

        return $this->render('JVRUserBundle:User:add.html.twig', ['form' => $form->createView()]);
    }

    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository("JVRUserBundle:User");

        /** @var User $user */
        $user = $repository->find($id);

        // You can also write whatever attribute to find for it. EX:
        //$user = $repository->findOneById($id);
        //$user = $repository->findOneByUsername($name);
        //$user = $repository->findOneByPassword($password);

        return new Response('Usuario: ' . $user->getUsername() . ' - Email: ' . $user->getEmail() . '<br/>');
    }

}
