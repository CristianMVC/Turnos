<?php

namespace TurnosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{



    /**
     * Crea un usuario
     *
     * @param Request $request Se envian los datos para crear el usuario
     * @return mixed
     * @Post("/usuarios")
     */
    public function postAction(Request $request)
    {

        $params = $request->request->all();
        $authorization = $request->headers->get('authorization', null);
        $userService = $this->get('UserServices');
        $mailer = $this->get('MailServices');
        
        $result = $userService->crearUsuario($params, $authorization);

        return $result;

    }
}
