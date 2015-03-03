<?php

namespace MDB\WishListBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MDB\WishListBundle\Entity\WishList;
use MDB\WishListBundle\Form\WishListType;

/**
 * WishList controller.
 *
 */
class WishListController extends Controller
{

    /**
     * Lists all WishList entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MDBWishListBundle:WishList')->findAll();

        return $this->render('MDBWishListBundle:WishList:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new WishList entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new WishList();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('wishlist_show', array('id' => $entity->getId())));
        }

        return $this->render('MDBWishListBundle:WishList:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new WishList entity via ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createJSONAction(Request $request)
    {
        $entity = new WishList();
        $form = $this->createCreateForm($entity, false);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = [
                'status' => 'good',
                'message' => 'Item added to the list'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => (string)$form->getErrors()
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * Creates a form to create a WishList entity.
     *
     * @param WishList $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(WishList $entity, $csrfCheck = true)
    {
        $form = $this->createForm(new WishListType(), $entity, array(
            'action' => $this->generateUrl('wishlist_create'),
            'method' => 'POST',
            'csrf_protection' => $csrfCheck
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new WishList entity.
     *
     */
    public function newAction()
    {
        $entity = new WishList();
        $form   = $this->createCreateForm($entity);

        return $this->render('MDBWishListBundle:WishList:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a WishList entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MDBWishListBundle:WishList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WishList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MDBWishListBundle:WishList:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing WishList entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MDBWishListBundle:WishList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WishList entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MDBWishListBundle:WishList:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a WishList entity.
    *
    * @param WishList $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(WishList $entity)
    {
        $form = $this->createForm(new WishListType(), $entity, array(
            'action' => $this->generateUrl('wishlist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing WishList entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MDBWishListBundle:WishList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WishList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('wishlist_edit', array('id' => $id)));
        }

        return $this->render('MDBWishListBundle:WishList:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a WishList entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MDBWishListBundle:WishList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WishList entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('wishlist'));
    }

    /**
     * Creates a form to delete a WishList entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wishlist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
