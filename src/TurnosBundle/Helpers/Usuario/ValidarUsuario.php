<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 16/04/19
 * Time: 14:17
 */

namespace TurnosBundle\Helpers\Usuario;


class ValidarUsuario
{



    public function validarParams($params){

     $errors = null;

     if(!array_key_exists('nombre', $params)) {

         $errors['nombre'] = "KEY: nombre faltante o incorrecto";
     }

     if(!array_key_exists('apellido', $params)) {

         $errors['apellido'] = "KEY: apellido faltante o incorrecto";
     }

     if(!array_key_exists('username', $params)) {

         $errors['username'] = "KEY: username faltante o incorrecto";
     }

     if(!array_key_exists('rol', $params)) {

         $errors['rol'] = "KEY: rol faltante o incorrecto";
     }


      if($errors != null) {

          return $errors;

      } else {

          return null;
      }


    }









}