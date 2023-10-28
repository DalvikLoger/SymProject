<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientTest extends WebTestCase
{
    public function testifCreateIngredientisSuccessfull(): void
    {
        $client = static::createClient();
        
        //Recup urlgenerator
        $urlGenerator = $client->getContainer()->get('router');
        //recup entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        //Se rendre sur la page de création d'un ingrédient
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('ingredient.new'));

        //Gérer les formulaires
        $form = $crawler->filter('form[name=ingredient]')->form([
            'ingredient[name]' => "Un ingrédient",
            'ingredient[price]' => floatval(33)
        ]);

        //gérer la redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        //Gérer l'alert box et la route
        $this->assertSelectorTextContains('div.alert.success', 'Votre élément a été créé avec succés !');

        $this->assertRouteSame('ingredient.index');
    }
}
