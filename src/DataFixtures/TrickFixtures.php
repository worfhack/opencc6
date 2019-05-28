<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 21/02/19
 * Time: 19:18
 */

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;

class TrickFixtures  extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tricks = [
           array('name'=>'backflip', 'slug'=>'backflip', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip1', 'slug'=>'backflip1', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip2', 'slug'=>'backflip2', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip2', 'slug'=>'backflip3', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip3', 'slug'=>'backflip4', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip4', 'slug'=>'backflip5', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip5', 'slug'=>'backflip6', 'description'=>"Le back flip est ..."),
            array('name'=>'backflip6', 'slug'=>'backflip7', 'description'=>"Le back flip est ..."),


        ];
        // on créé 10 users
        foreach ($tricks as $trickData) {

            $description = $trickData['description'];
            $name = $trickData['name'];
            $slug = $trickData['slug'];

            $trick = new Trick();
            $trick->setDateAdd(new \DateTime("now"))->setName(
                $name
            )->setDescription($description)->setSlug($slug);

            $manager->persist($trick);
        }

        $manager->flush();
    }
}