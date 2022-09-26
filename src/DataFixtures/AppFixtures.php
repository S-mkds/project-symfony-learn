<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Article;
use Faker\Provider\tr_TR\DateTime;
use Symfony\Component\String\Slugger;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\UnicodeString;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        // create 20 articles! Bam!
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitre('Ordinateur');
            $article->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
            $article->setImageUrl($faker->imageUrl(400, 400, true));
            $article->setSlug($this->slugger->slug($article->getTitre()));

            $article->setCreatedAt(new DateTimeImmutable("now"));
            $manager->persist($article);
        }

        $manager->flush();
    }
}