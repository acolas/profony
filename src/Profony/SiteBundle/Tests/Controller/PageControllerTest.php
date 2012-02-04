<?php

namespace Profony\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase {

    public function testAbout() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');

        $this->assertEquals(1, $crawler->filter('h1:contains("About symblog")')->count());
    }

    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // Vérifie qu'il y a des articles dans la page
        $this->assertTrue($crawler->filter('article.blog')->count() > 0);

        // Récupère le premier lien, puis vérifie qu'il amene bien à l'article correspondant
        $blogLink = $crawler->filter('article.blog h2 a')->first();
        $blogTitle = $blogLink->text();
        $crawler = $client->click($blogLink->link());

        // Vérifie que h2 contient bien le titre de l'article
        $this->assertEquals(1, $crawler->filter('h2:contains("' . $blogTitle . '")')->count());
    }

    public function testContact() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(1, $crawler->filter('h1:contains("Contact Profony")')->count());

        // Sélection basée sur la valeur, l'id ou le nom des boutons
//        $form = $crawler->selectButton('Submit')->form();
//
//        $form['profony_sitebundle_enquirytype[name]'] = 'name';
//        $form['blogger_blogbundle_enquirytype[email]'] = 'email@email.com';
//        $form['blogger_blogbundle_enquirytype[subject]'] = 'Subject';
//        $form['blogger_blogbundle_enquirytype[body]'] = 'The comment body must be at least 50 characters long as there is a validation constrain on the Enquiry entity';
//
//        $crawler = $client->submit($form);
//
//        $this->assertEquals(1, $crawler->filter('.blogger-notice:contains("Your contact enquiry was successfully sent. Thank you!")')->count());
    }

}