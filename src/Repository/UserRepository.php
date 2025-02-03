<?php

namespace App\Repository;

use App\Entity\Offer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Task;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $registry->getManager();
    }

    public function findCompleteUser(int $userId): ?User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.favoriteOffers', 'fo')
            ->addSelect('fo')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function toggleFavoriteTask(User $user, Offer $offer): bool
    {
        if ($user->getFavoriteOffers()->contains($offer)) {
            $user->removeFavoriteOffer($offer);
            $isFavorite = false;
        } else {
            $isFavorite = true;
            $user->addFavoriteOffer($offer);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $isFavorite;
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
