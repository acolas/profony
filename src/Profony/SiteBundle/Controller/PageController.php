<?php

namespace Profony\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use Profony\SiteBundle\Entity\Enquiry;
use Profony\SiteBundle\Form\EnquiryType;

class PageController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $blogs = $em->getRepository('ProfonySiteBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('ProfonySiteBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    public function aboutAction() {
        return $this->render('ProfonySiteBundle:Page:about.html.twig');
    }

    public function contactAction() {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page

                $message = \Swift_Message::newInstance()
                        ->setSubject('Contact enquiry from symblog')
                        ->setFrom('su@per.fr')
                        ->setTo($this->container->getParameter('profony_site.emails.contact_email'))
                        ->setBody($this->renderView('ProfonySiteBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                return $this->redirect($this->generateUrl('ProfonySiteBundle_contact'));
            }
        }

        return $this->render('ProfonySiteBundle:Page:contact.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    
    public function sidebarAction() {
        $em = $this->getDoctrine()
                ->getEntityManager();

        $tags = $em->getRepository('ProfonySiteBundle:Blog')
                ->getTags();

        $tagWeights = $em->getRepository('ProfonySiteBundle:Blog')
                ->getTagWeights($tags);

        return $this->render('ProfonySiteBundle:Page:sidebar.html.twig', array(
                    'tags' => $tagWeights
                ));
    }
}