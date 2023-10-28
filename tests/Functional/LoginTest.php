<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testIfLoginIsSuccessful(): void
    {
        $client = static::createClient();
        
        //Get route by urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        $crawler = $client->request('GET', $urlGenerator->generate('security.login'));
        //form
        $form = $crawler->filter("form[name=login]")->form([
        "_username" => "george.ul@gmail.com",
        "_password" =>"password"]);

        $client->submit($form);

        //Redirect / Home
        
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        
    }
}
