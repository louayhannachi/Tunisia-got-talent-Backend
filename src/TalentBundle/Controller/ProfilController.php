<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
/**
 * Profil controller.
 *
 */
class ProfilController extends Controller
{
    /**
     * Lists all profil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('TalentBundle:Profil')->findAll();
        $rating = $em->getRepository('TalentBundle:Rating')->findAll();
        $likes = $em->getRepository('TalentBundle:Likes')->findAll();
        $items = array("profils" => $profils,"rating" => $rating,"likes" => $likes);
        $data = $this->get('jms_serializer')->serialize($items, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    public function relatedToProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('TalentBundle:Profil')->find($id);
        $ratings = $em->getRepository('TalentBundle:Rating')->findBy(["profil"=>$profils]);
        $comments = $em->getRepository('TalentBundle:Comment')->findBy(["profil"=>$profils]);

        $likes = $em->getRepository('TalentBundle:Likes')->findBy(["comment"=>$comments]);

        $items = array("profils" => $profils,"ratings" => $ratings,"comment"=>$comments,"likes" => $likes);
        $data = $this->get('jms_serializer')->serialize($items, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * Creates a new profil entity.
     *
     */
    public function newAction(Request $request)
    {
        $profil = new Profil();
        $form = $this->createForm('TalentBundle\Form\ProfilType', $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            return $this->redirectToRoute('profil_show', array('id' => $profil->getId()));
        }

        return $this->render('profil/new.html.twig', array(
            'profil' => $profil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     */
    public function showAction(Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);

        return $this->render('profil/show.html.twig', array(
            'profil' => $profil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing profil entity.
     *
     */
    public function editAction(Request $request, Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);
        $editForm = $this->createForm('TalentBundle\Form\ProfilType', $profil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_edit', array('id' => $profil->getId()));
        }

        return $this->render('profil/edit.html.twig', array(
            'profil' => $profil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a profil entity.
     *
     */
    public function deleteAction(Request $request, Profil $profil)
    {
        $form = $this->createDeleteForm($profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profil);
            $em->flush();
        }

        return $this->redirectToRoute('profil_index');
    }

    /**
     * Creates a form to delete a profil entity.
     *
     * @param Profil $profil The profil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profil $profil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profil_delete', array('id' => $profil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
