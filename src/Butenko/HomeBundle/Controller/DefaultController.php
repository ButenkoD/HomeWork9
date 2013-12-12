<?php

namespace Butenko\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Butenko\HomeBundle\Entity\Post;
use Butenko\HomeBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Butenko\HomeBundle\EventListener\PostAddedEvent;
use Butenko\HomeBundle\EventListener\EventNames;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(),$post);

        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if($form->isValid()) {
                $em->persist($post);
                $em->flush();

                $dispatcher = $this->get('event_dispatcher');

                $event = new PostAddedEvent($post);
                $dispatcher->dispatch(EventNames::POST_ADDED, $event);

                return $this->redirect($this->generateUrl('all_posts'));
            }
        }

        $posts = $em->getRepository('ButenkoHomeBundle:Post')
            ->findAll();

        $query = $em->createQuery('SELECT p FROM ButenkoHomeBundle:Post p ORDER BY p.id DESC ');

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $this->container->getParameter('posts_per_page')
        );

        return $this->render('ButenkoHomeBundle:Default:index.html.twig', array(
            'posts' => $posts,
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ButenkoHomeBundle:Post')
            ->findOneBy(array('id' => $id));
        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('all_posts'));
    }

    public function showAction($id)
    {
        $post = $this->getDoctrine()
            ->getRepository('ButenkoHomeBundle:Post')
            ->findOneBy(array('id' => $id));

        return $this->render('ButenkoHomeBundle:Default:show.html.twig', array('post' => $post));
    }
}
