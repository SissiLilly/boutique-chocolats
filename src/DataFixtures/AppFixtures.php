<?php

namespace App\DataFixtures;

use App\Entity\Chocolat;
use App\Entity\Collection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 10 chocolat objects
        for ($i = 1; $i <= 10; $i++) {
            $chocolat = new Chocolat();
            $chocolat->setNom("Chocolat $i");
            $chocolat->setDescription("Description of Chocolat $i");
            $chocolat->setPrix(rand(10, 100));
            $chocolat->setImage("chocolat_$i.jpg");
            $chocolat->setImageName("chocolat_$i.jpg");
            $chocolat->setSlug("chocolat-$i");
            $chocolat->setIsBest(rand(0, 1) == 1);
            $chocolat->setTitre("Titre of Chocolat $i");

            // create a new collection object and set it as the categorie of the chocolat
            $collection = new Collection();
            $collection->setNomCollection("Collection $i");
            $chocolat->setCategorie($collection);

            $manager->persist($chocolat);
            $manager->persist($collection);
        }

        $manager->flush();
    }
}
