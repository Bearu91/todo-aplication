<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ToDo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Todo controller.
 *
 * @Route("todo")
 */
class ToDoController extends Controller
{
    /**
     * Lists all toDo entities.
     *
     * @Route("/", name="todo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $toDos = $em->getRepository('AppBundle:ToDo')->findAll();

        return $this->render('todo/index.html.twig', array(
            'toDos' => $toDos,
        ));
    }

    /**
     * Creates a new toDo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $toDo = new Todo();
        $form = $this->createForm('AppBundle\Form\ToDoType', $toDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($toDo);
            $em->flush();

            return $this->redirectToRoute('todo_index');
        }

        return $this->render('todo/new.html.twig', array(
            'toDo' => $toDo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a toDo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     */
    public function showAction(ToDo $toDo)
    {
        return $this->render('todo/show.html.twig', array(
            'toDo' => $toDo,
        ));
    }

    /**
     * Displays a form to edit an existing toDo entity.
     *
     * @Route("/{id}/edit", name="todo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ToDo $toDo)
    {
        $editForm = $this->createForm('AppBundle\Form\ToDoType', $toDo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todo_index');
        }

        return $this->render('todo/edit.html.twig', array(
            'toDo' => $toDo,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a toDo entity.
     *
     * @Route("/todo/{id}/delete", name="todo_delete")
     */
    public function deleteAction(Request $request, ToDo $toDo)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($toDo);
            $em->flush();
        

        return $this->redirectToRoute('todo_index');
    }
}
