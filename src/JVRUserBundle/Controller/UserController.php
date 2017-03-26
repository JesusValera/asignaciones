<?php

namespace JVRUserBundle\Controller;

use JVRUserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        // Obtener el manager que hace de puente con la base de datos.
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("JVRUserBundle:User")->findAll();

        // Mostrar datos.
        $res = 'Lista de usuarios: <br/>';
        /** @var User $user */
        foreach ($users as $user)
        {
            $res .= 'Usuario: ' . $user->getUsername() . ' - Email: ' . $user->getEmail() . '<br/>';
        }

        return new Response($res);
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
