<?php

namespace TalentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("TalentBundle:User")->findOneBy(array("username" => $input["username"]));
        //var_dump($user->getSalt());

        if ($user == NULL) {
            $data = $this->get('jms_serializer')->serialize("Invalid Login or password", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            if ($user->getPassword() != $input["password"]) {
                $data = $this->get('jms_serializer')->serialize("Invalid password", 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            } else {
                $data = $this->get('jms_serializer')->serialize($user, 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            }
        }
    }

    public function loginAdminAction(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("TalentBundle:User")->findOneBy(array("username" => $input["username"]));
        //var_dump($user->getSalt());

        if ($user == NULL) {
            $data = $this->get('jms_serializer')->serialize("Invalid Login or password", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
          // $response->setStatusCode(Response::$statusTexts[500]);
            return $response;
        } else {
            if ($user->getPassword() != $input["password"]) {
                $data = $this->get('jms_serializer')->serialize("Invalid password", 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            } else {
                if ($user->getRole() === 'ADMIN') {
                    $data = $this->get('jms_serializer')->serialize($user, 'json');
                    $response = new Response($data);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->headers->set('Access-Control-Allow-Origin', '*');
                    return $response;
                } else {
                    $data = $this->get('jms_serializer')->serialize("You must have ADMIN role !", 'json');
                    $response = new Response($data);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->headers->set('Access-Control-Allow-Origin', '*');
                    return $response;
                }
            }

        }
    }


}
