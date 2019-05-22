<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email, $roles, $password, $firstname, $last_name])
        {
            $user = new User();

            $user -> setEmail($email);
            $user -> setRoles($roles);
            $user -> setPassword($this -> password_encoder ->encodePassword(
                $user,
                $password
            ));
            $user -> setFirstName($firstname);
            $user -> setLastName($last_name);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['test@test.com', ['ROLE_ADMIN'], 'password', 'Tersea', 'Test'],
            ['test2@test.com', ['ROLE_ADMIN'], 'password', 'John', 'Test'],
            ['test3@test.com', ['ROLE_USER'], 'password', 'Jane', 'Test']
        ];
    }
}
