<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rating controller.
 *
 */
class RatingController extends Controller
{
    /**
     * Lists all rating entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('TalentBundle:Rating')->findAll();

        $data = $this->get('jms_serializer')->serialize($ratings, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Creates a new rating entity.
     *
     */
    public function newAction(Request $request)
    {
        $rating = new Rating();
        $form = $this->createForm('TalentBundle\Form\RatingType', $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('rating_show', array('id' => $rating->getId()));
        }

        return $this->render('rating/new.html.twig', array(
            'rating' => $rating,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rating entity.
     *
     */
    public function showAction(Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);

        return $this->render('rating/show.html.twig', array(
            'rating' => $rating,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rating entity.
     *
     */
    public function editAction(Request $request, Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);
        $editForm = $this->createForm('TalentBundle\Form\RatingType', $rating);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rating_edit', array('id' => $rating->getId()));
        }

        return $this->render('rating/edit.html.twig', array(
            'rating' => $rating,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rating entity.
     *
     */
    public function deleteAction(Request $request, Rating $rating)
    {
        $form = $this->createDeleteForm($rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rating);
            $em->flush();
        }

        return $this->redirectToRoute('rating_index');
    }

    /**
     * Creates a form to delete a rating entity.
     *
     * @param Rating $rating The rating entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rating $rating)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rating_delete', array('id' => $rating->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
