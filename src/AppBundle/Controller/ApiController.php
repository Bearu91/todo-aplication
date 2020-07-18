<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use FOS\RestBundle\View\View;
use AppBundle\Entity\ToDo;
use AppBundle\Entity\User;


/**
 * @Route("api")
 */

class ApiController extends FOSRestController
{

    /**
     * Get ToDo list
     * @Rest\Get("/todo")
     * @return View
     */
    public function getToDoListAction(Request $request): View
    {
        $todoList = $this->getDoctrine()->getRepository(ToDo::class)->findAll();
        if (!is_null($todoList)) {
            $view = $this->view($todoList, Response::HTTP_OK);
        } else {
            $view = $this->view(['success' => 'false', 'code' => '404' ], Response::HTTP_NOT_FOUND);
        }
        return $view;
    }

    /**
     * Add new ToDo
     * @Rest\Post("/todo")
     * @return View
     */
    public function addToDoAction(Request $request): View
    {
        $em = $this->getDoctrine()->getManager();
        
        $todo = new ToDo();
        $todo->setName($request->get('name'));
  
        $em->persist($todo);
        $em->flush();


        return $this->view($todo, Response::HTTP_CREATED);
        
    }

    /**
     * Edit existing ToDo
     * @Rest\Post("/todo/{id}")
     * @param         $id
     * @param Request $request

     * @return View
     */
    public function editToDoAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $todo = $this->getDoctrine()->getRepository(ToDo::class)->find($id);
        if (!is_null($todo)) {
            $view = $this->view($todo, Response::HTTP_OK);
        } else {
            $view = $this->view(['success' => 'false', 'code' => '404' ], Response::HTTP_NOT_FOUND);
            return $view;
        }
        $todo->setName($request->get('name'));

        $em->persist($todo);
        $em->flush();

        return $view;
    }

    /**
     * Get existing ToDo
     * @Rest\Get("/todo/{id}")
     * @return View
     */
    public function getToDoAction($id)
    {
        $todo = $this->getDoctrine()->getRepository(ToDo::class)->find($id);
        if (!is_null($todo)) {
            $view = $this->view($todo, Response::HTTP_OK);
        } else {
            $view = $this->view(['success' => 'false', 'code' => '404' ], Response::HTTP_NOT_FOUND);
        }
        return $view;
    }

    
    /**
     * Delete ToDo
     * @Rest\Delete("/todo/{id}")
     * @param $id
     * @return View
     */
    public function deleteToDoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $todo = $this->getDoctrine()->getRepository(ToDo::class)->find($id);
        if (!is_null($todo)) {
            $view = $this->view($todo, Response::HTTP_OK);
        } else {
            $view = $this->view(['success' => 'false', 'code' => '404' ], Response::HTTP_NOT_FOUND);
            return $view;
        }

        $em->remove($todo);
        $em->flush();

        return $view;

    }

}
