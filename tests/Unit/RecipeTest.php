<?php

namespace App\Tests\Unit;

use App\Entity\Mark;
use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecipeTest extends KernelTestCase
{
    public function getEntity() : Recipe
    {
        return (new Recipe())
            ->setName('Recipe #1')
            ->setDescription('Description #1')
            ->setIsFavorite(true)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable());

    }
    public function testEntityisValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $recipe = new Recipe();
        $recipe->setName('Recipe #1')
            ->setDescription('Description #1')
            ->setIsFavorite(true)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdateAt(new \DateTimeImmutable());

        $errors = $container->get('validator')->validate($recipe);

        $this->assertCount(0, $errors);
    }

    public function testInvalidName()
    {
        self::bootKernel();
        $container = static::getContainer();

        $recipe = $this->getEntity();
        $recipe->setName('');

        $errors = $container->get('validator')->validate($recipe);

        $this->assertCount(2, $errors);
    }


}
