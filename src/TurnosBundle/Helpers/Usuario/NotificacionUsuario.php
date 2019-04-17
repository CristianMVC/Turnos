<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 16/04/19
 * Time: 11:46
 */

namespace TurnosBundle\Helpers\Usuario;

use Symfony\Component\DependencyInjection\Container;
use Unirest\Request;

class NotificacionUsuario
{

    private $host;
    private $user;
    private $pass;
    private $token;
    private $from;
    private $subject;
    private $templates;
    private $urls;
    private $batchLimit = 15;

    public function __construct(Container $container)
    {
        $config = $container->getParameter('notificaciones');
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->token = $config['token'];
        $this->from = $config['from'];
        $this->subject = $config['subject'];
        $this->templates = $config['templates'];
        $this->urls = $config['urls'];
        $this->batchLimit = $config['batch_limit'];
        $this->environment = $container->get('kernel')->getEnvironment();

    }




     public function notificacion($params,$email,$cuil,$template){

       $url = $this->host . $this->urls['notifications'];
       $body = Request\Body::json([
         'recipients' => [
             [
                 'content' => [
                     'email' => [
                         'params' => $params,
                         'from' => $this->from,
                         'from_text' => 'Mi Argentina', // TODO: hacer que lo tome desde config
                         'to' => $email,
                         'subject' => $this->subject,
                         'template' => $template
                     ],
                 ],
                 'cuil' => $cuil,
                 'force' => true
             ]
         ]
     ]);


     $response = Request::post($url, $this->getHeaders(true), $body);
     die();
     $errors = $this->checkErrors($response->body);
     if ($errors) {
         return $errors;
     }
     return $response->body;


    }


    private function checkErrors($body)
    {
        if (property_exists($body, 'non_field_errors')) {
            return $body->non_field_errors;
        }
        return null;
    }


    private function getHeaders($token = null)
    {
        $headers = [];
        $headers['Accept'] = 'application/json';
        $headers['Content-Type'] = 'application/json';
        if ($token) {
            $headers['Authorization'] = 'Token ' . $this->token;
        }
        return $headers;
    }




}