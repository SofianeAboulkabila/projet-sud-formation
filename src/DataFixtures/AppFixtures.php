<?php

namespace App\DataFixtures;

use App\Entity\SupportTicket;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 49; $i++) {
            // Création d'un utilisateur
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($this->faker->word());
            $utilisateur->setPrenom($this->faker->word());
            $utilisateur->setEmail($this->faker->email());
            $utilisateur->setDateCreation(new \DateTimeImmutable('now'));
            $utilisateur->setRole('ROLE_MODERATEUR');
            $utilisateur->setPassword('password'); // Remplacez par le mot de passe réel

            $manager->persist($utilisateur);

            // Création d'un ticket de support
            $supportTicket = new SupportTicket();
            $supportTicket->setNomSupport($this->faker->word());
            $supportTicket->setNomDemandeur($this->faker->word());
            $supportTicket->setTicketMessage($this->faker->word());
            $supportTicket->setDateCreation(new \DateTimeImmutable('now'));
            $supportTicket->setDateResolution(new \DateTimeImmutable('now'));

            $manager->persist($supportTicket);
        }
        $manager->flush();
    }
}
