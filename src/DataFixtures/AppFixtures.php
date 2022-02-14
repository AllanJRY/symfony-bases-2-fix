<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    private ObjectManager $manager;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $admin = new User();
        $cart = new Cart();
        $cart->setUser($admin);
        $hashedPassword = $this->hasher->hashPassword($admin, 'admin');
        $admin
            ->setEmail('admin@admin.fr')
            ->setFirstname('Admin')
            ->setLastname('ADMIN')
            ->setCart($cart)
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword($hashedPassword)
        ;
        $manager->persist($admin);

        $users = $this->generateUsers();
        $categories = $this->generateCategories();
        $products = $this->generateProducts($categories, $users);

        $manager->flush();
    }

    private function generateUsers(): array {
        $users = [];

        for($i = 0; $i < 10; $i++) {
            $newUsers = new User();
            $cart = new Cart();
            $hashedPassword = $this->hasher->hashPassword($newUsers, 'user');
            $newUsers
                ->setEmail('user'.$i.'@user.fr')
                ->setFirstname('User'.$i)
                ->setLastname('USER'.$i)
                ->setCart($cart)
                ->setRoles(['ROLE_USER'])
                ->setPassword($hashedPassword)
            ;

            $this->manager->persist($newUsers);
            $users[] = $newUsers;
        }

        return $users;
    }

    private function generateCategories(): array
    {
        $categs = [];

        for($i = 0; $i < 5; $i++) {
            $newCateg = new Category();
            $newCateg->setName('Catégorie '.$i);
            $this->manager->persist($newCateg);
            $categs[] = $newCateg;
        }

        return $categs;
    }

    private function generateProducts(array $categories, array $users): array
    {
        $products = [];

        for($i = 0; $i < 5; $i++) {
            $newProduct = new Product();

            $review = new Review();
            $review
                ->setContent('Lorem ipsum dolors sit um.')
                ->setNote(3)
                ->setAuthor($users[array_rand($users)])
            ;

            $review2 = new Review();
            $review2
                ->setContent('Lorem ipsum dolors sit um.')
                ->setNote(2)
                ->setAuthor($users[array_rand($users)])
            ;

            $newProduct
                ->setName('Product '.$i)
                ->setDescription('Lorem ipsum dolors sit um.')
                ->setPrice(15.99)
                ->addCategory($categories[array_rand($categories)])
                ->addReview($review)
                ->addReview($review2)
            ;

            $this->manager->persist($newProduct);
            $products[] = $newProduct;
        }

        return $products;
    }
}
