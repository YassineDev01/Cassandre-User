<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),

            // Mot de passe (création uniquement)
            TextField::new('password', 'Mot de passe')
                ->setFormTypeOption('mapped', false)
                ->onlyWhenCreating(),

            AssociationField::new('role', 'Rôle')
                ->setRequired(true),

            BooleanField::new('actif'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }

        // Récupération du mot de passe saisi
        $plainPassword = $this->getContext()
            ->getRequest()
            ->request
            ->all('User')['password'] ?? null;

        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher
                ->hashPassword($entityInstance, $plainPassword);

            $entityInstance->setPassword($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
