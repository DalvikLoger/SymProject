<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur SymProject');

        //Récupérer le Formulaire
        

        //Summettre le formulaire
        
        //Vérifier le statut Http
        // Vérifier l'envoie du mail
        
        // Vérifier la présence du message de succés
    }
}
