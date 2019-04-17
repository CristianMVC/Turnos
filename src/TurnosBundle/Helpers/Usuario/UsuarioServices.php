<?php

namespace TurnosBundle\Helpers\Usuario;

use TurnosBundle\Entity\Usuario;
use Symfony\Component\DependencyInjection\Container;
use Unirest\Exception;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TurnosBundle\Helpers\RespuestaConEstado;



class UsuarioServices {


    protected $em;
    private $container;


    public function __construct(EntityManager $entityManager, Container $container){
        $this->em = $entityManager;
        $this->container = $container;

    }


    public function  crearUsuario($params,$authorization){

        $this->container->get('MailServices')->notificacion($params,$params['username'],"20323356328","hola mundo");
        die();

       $validar = $this->container->get('ValidarUsuario')->notificacion();
       if($validar->validarParams($params) != null){
           return $this->respuestaError($validar->validarParams($params));
       } else {

       try {
           $usuario = new Usuario();


           $usuario->setUsername($params['username']);
           $usuario->setPassword('blahblah');
           $usuario->setNombre($params['nombre']);
           $usuario->setApellido($params['apellido']);

           $this->em->persist($usuario);
           $this->em->flush();

           $this->container->get('MailServices')->getEnvironment();
           return $this->respuestaOk("Usuario creado correctamente");

           }catch(\Exception $e) {

           return $this->respuestaError($e->getMessage());

           }
       }

      return;

    }

    protected function respuestaOk($message, $additional = '')
    {
        return new RespuestaConEstado(
            RespuestaConEstado::STATUS_SUCCESS,
            RespuestaConEstado::CODE_SUCCESS,
            $message,
            '',
            $additional
        );
    }


    protected function respuestaError($message) {

        return new RespuestaConEstado(
            RespuestaConEstado::STATUS_FATAL,
            RespuestaConEstado::CODE_FATAL,
            $message,
            '',
            ''
        );
    }



}
