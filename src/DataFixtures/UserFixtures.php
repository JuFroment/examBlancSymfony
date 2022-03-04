<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $admin = new User();
        $admin->setEmail('admin@deloitte.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123@' ));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('Ipsum');
        $admin->setPrenom('Lorem');
        $admin->setPhoto('https://i.ibb.co/WHNBnJt/verynoise.png');
        $admin->setSecteur('Direction');

        $user1 = new User();
        $user1->setEmail('user@deloitte.com');
        $user1->setPassword($this->hasher->hashPassword($user1, 'user123@'));
        $user1->setNom('Dolor');
        $user1->setPrenom('Sit');
        $user1->setPhoto('https://i.ibb.co/5RqjdZY/flippedverynoise.png');
        $user1->setSecteur('Recrutement');

        $user2 = new User();
        $user2->setEmail('user2@deloitte.com');
        $user2->setPassword($this->hasher->hashPassword($user2, 'user1234@'));
        $user2->setNom('Amet');
        $user2->setPrenom('Consectetur');
        $user2->setPhoto('https://i.ibb.co/5WMCLcz/vflipverynoise.png');
        $user2->setSecteur('Comptabilité');

        $user3 = new User();
        $user3->setEmail('user3@deloitte.com');
        $user3->setPassword($this->hasher->hashPassword($user3, 'user12345@'));
        $user3->setNom('Adipiscing');
        $user3->setPrenom('Elit');
        $user3->setPhoto('https://i.ibb.co/Bt6tWdR/vhflipverynoise.png');
        $user3->setSecteur('Informatique');

        $manager->persist($admin);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();
    }

}
