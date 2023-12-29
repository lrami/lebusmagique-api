<?php

namespace App\Repository\Gw2Api;

use App\Entity\Gw2Api\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function save(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function adminItems($filters) {
        $q = $this->createQueryBuilder('i')
            ->select('i.id', 'i.uid', 'i.name', 'i.rarity', 'i.type', 'i.subtype', 'i.blackmarket')
            ->orderBy('i.uid', 'DESC')
        ;

        if($filters['is']) {
            if($filters['is'] === 'fish') {
                $q->addSelect('f.power AS fishPower', 'f.specialization', 'f.strangeDiet', 'f.baitAny');
                $q->addSelect('bi.name AS baitName', 'a.name AS achievementName');
                $q->innerJoin('i.fish', 'f');
                $q->leftJoin('f.bait', 'b');
                $q->leftJoin('b.item', 'bi');
                $q->leftJoin('f.achievement', 'a');
            } else if($filters['is'] === 'fish-bait') {
                $q->addSelect('b.power AS fishBaitPower');
                $q->innerJoin('i.bait', 'b');
            } else if($filters['is'] === 'blackmarket') {
                $q->where('i.blackmarket = :true')
                    ->setParameter('true', true);
            }
        }

        if($filters['type']) {
            $q->andWhere('i.type = :type')
                ->setParameter('type', $filters['type']);
        }

        if($filters['subtype']) {
            $q->andWhere('i.subtype = :subtype')
                ->setParameter('subtype', $filters['subtype']);
        }

        return $q->getQuery();
    }

    public function adminItemsTypes(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.type')
            ->groupBy('i.type')
            ->orderBy('i.type')
            ->getQuery()
            ->getResult()
        ;
    }

    public function adminItemsSubtypes(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.subtype')
            ->groupBy('i.subtype')
            ->orderBy('i.subtype')
            ->where('i.subtype IS NOT NULL')
            ->getQuery()
            ->getScalarResult()
        ;
    }
}
