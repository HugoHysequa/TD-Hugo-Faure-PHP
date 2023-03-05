<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryNames = [
            'Concert', 'Opéra', 'Ciné-concert', 'Danse', 'One-man show',
            'Pop', 'Rock', 'Jazz', 'Classique', 'Rap', 'Hip-hop', 'Insolite'
        ];

        foreach ($categoryNames as $categoryName) {
            $category = new Category;
            $category
                ->setName($categoryName);
            $manager->persist($category);
        }
        $configuration = new Configuration;
        $configuration->setAdresse("DAWIN-Arena, 1337 rue de DAWIN, 33000 Bordeaux");
        $configuration->setNomSalle("DAWIN-Arena");
        $configuration->setEmplacement("https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d866.484008439681!2d-0.6120920284114297!3d44.7905312998258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sfr!4v1674655457720!5m2!1sen!2sfr");
        $manager->persist($configuration);

        $manager->flush();
    }
}
