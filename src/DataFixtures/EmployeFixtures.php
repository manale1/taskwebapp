<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for($i=1 ; $i<=5 ;$i++)
        {
            $employee = new Employe();
            $employee->setNom($faker->lastName);
            $employee->setPrenom($faker->firstName);
            $employee->setTelephone($faker->phoneNumber);
            $employee->setEmail($faker->email);
            $employee->setPoste($faker->jobTitle);
            $employee->setDateNaiss($faker->dateTimeBetween('-30 years','09-11-1999'));
            $employee->setAdresse($faker->city);
            $employee->setMotPasse($faker->password);
            $employee->setAdministrateur("0");
            $manager->persist($employee);
        }
        $manager->flush();
    }
}
