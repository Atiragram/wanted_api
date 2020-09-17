<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $person = new Person();
            $person->setFullName('FirstName Lastname' . $i);
            $person->setIsWanted((bool) \rand(0, 1));

            $manager->persist($person);
        }

        $systemUser = User::createUser($this->encoder, 'username', 'password');

        $manager->persist($systemUser);

        $manager->flush();
    }
}
