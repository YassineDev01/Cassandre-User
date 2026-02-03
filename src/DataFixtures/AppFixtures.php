<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // --- Création des rôles ---
        $userRole     = (new Role())->setCode(RoleCode::USER)->setLibelle(RoleCode::USER->label())->setSystem(true);
        $adminRole    = (new Role())->setCode(RoleCode::ADMIN)->setLibelle(RoleCode::ADMIN->label())->setSystem(true);
        $auditorRole  = (new Role())->setCode(RoleCode::AUDITOR)->setLibelle(RoleCode::AUDITOR->label())->setSystem(true);
        $examinerRole = (new Role())->setCode(RoleCode::EXAMINER)->setLibelle(RoleCode::EXAMINER->label())->setSystem(true);
        $staffRole    = (new Role())->setCode(RoleCode::STAFF)->setLibelle(RoleCode::STAFF->label())->setSystem(true);

        $roles = [$userRole, $adminRole, $auditorRole, $examinerRole, $staffRole];

        foreach ($roles as $role) {
            $manager->persist($role);
        }

        $manager->flush(); // flush pour avoir les IDs des rôles

        // --- Création des utilisateurs ---
        $admin = (new User())
            ->setNom('Admin')
            ->setPrenom('Cassandre')
            ->setEmail('admin@cassandre.com')
            ->setActif(true)
            ->setRole($adminRole);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, '123'));
        $manager->persist($admin);

        $user1 = (new User())
            ->setNom('Doe')
            ->setPrenom('John')
            ->setEmail('john.doe@example.com')
            ->setActif(true)
            ->setRole($auditorRole);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, '123'));
        $manager->persist($user1);

        $user2 = (new User())
            ->setNom('Smith')
            ->setPrenom('Alice')
            ->setEmail('alice.smith@example.com')
            ->setActif(true)
            ->setRole($examinerRole);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, '123'));
        $manager->persist($user2);

        $user3 = (new User())
            ->setNom('Brown')
            ->setPrenom('Bob')
            ->setEmail('bob.brown@example.com')
            ->setActif(true)
            ->setRole($staffRole);
        $user3->setPassword($this->passwordHasher->hashPassword($user3, '123'));
        $manager->persist($user3);

        // --- Exemple d’un utilisateur “normal” (USER) ---
        $userDefault = (new User())
            ->setNom('Normal')
            ->setPrenom('User')
            ->setEmail('user@example.com')
            ->setActif(true)
            ->setRole($userRole);
        $userDefault->setPassword($this->passwordHasher->hashPassword($userDefault, '123'));
        $manager->persist($userDefault);

        // --- Enregistrer en base ---
        $manager->flush();
    }
}
