<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\PublicationsBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BlogPublicationsBundle:Category');


        return $this->render('AdminPanelBundle:Categories:index.html.twig', array(
            'categories' => $categories->findAll()
        ));
    }

    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createFormBuilder($category)
            ->add('title', 'text', array(
                'label' => 'Заголовок'
            ))
            ->add('description', 'textarea', array(
                'label' => 'Описание'
            ))
            ->add('save', 'submit', array(
                'label' => 'Сохранить категорию',
                'attr'   =>  array(
                    'class'   => 'btn-success'
                )
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category->setIsPublic(true);
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_panel_categories'));
        }

        return $this->render('AdminPanelBundle:Categories:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('BlogPublicationsBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        $em->remove($category);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_panel_categories'));
    }
}
