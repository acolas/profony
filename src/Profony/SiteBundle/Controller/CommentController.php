<?php

namespace Profony\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Profony\SiteBundle\Entity\Comment;
use Profony\SiteBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller {

    public function newAction($blog_id) {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form = $this->createForm(new CommentType(), $comment);

        return $this->render('ProfonySiteBundle:Comment:form.html.twig', array(
                    'comment' => $comment,
                    'form' => $form->createView()
                ));
    }

    public function createAction($blog_id) {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form = $this->createForm(new CommentType(), $comment);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                    ->getEntityManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('ProfonySiteBundle_blog_show', array(
                                'id' => $comment->getBlog()->getId(),
                                'slug' => $comment->getBlog()->getSlug())) .
                            '#comment-' . $comment->getId()
            );
        }

        return $this->render('ProfonySiteBundle:Comment:create.html.twig', array(
                    'comment' => $comment,
                    'form' => $form->createView()
                ));
    }

    protected function getBlog($blog_id) {
        $em = $this->getDoctrine()
                ->getEntityManager();

        $blog = $em->getRepository('ProfonySiteBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}