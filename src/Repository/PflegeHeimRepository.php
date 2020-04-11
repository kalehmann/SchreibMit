<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Repository;

use Doctrine\ORM\Query\Expr\Join;
use DrkDD\SchreibMit\Entity\Pflegeheim;
use DrkDD\SchreibMit\Entity\PostalCode;
use Doctrine\ORM\AbstractQuery;
use DrkDD\SchreibMit\Entity\User;

/**
 * Class PflegeHeimRepository
 * @package DrkDD\SchreibMit\Repository
 */
class PflegeHeimRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Findet das geografisch am nähsten liegende Pflegeheim für eine Postleitzahl, welches noch frei Kapazitäten hat.
     *
     * @param PostalCode $postalCode
     * @return Pflegeheim|null
     */
    public function findNearestForPostalCode(PostalCode $postalCode): ?Pflegeheim
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $res = $qb->select(
            'p AS ph',
            $qb->expr()->sqrt(
                $qb->expr()->sum(
                    $qb->expr()->prod(
                        $qb->expr()->prod(
                            $qb->expr()->diff('p.latitude', ':postal_lat'),
                            $qb->expr()->diff('p.latitude', ':postal_lat')
                        ),
                        $qb->expr()->prod(
                            ':latitude_offset',
                            ':latitude_offset'
                        )
                    ),
                    $qb->expr()->prod(
                        $qb->expr()->prod(
                            $qb->expr()->diff('p.longitude', ':postal_lon'),
                            $qb->expr()->diff('p.longitude', ':postal_lon')
                        ),
                        $qb->expr()->prod(
                            ':longitude_offset',
                            ':longitude_offset'
                        )
                    )
                )
            ) . ' AS dist'
        )
            ->addSelect()
            ->from(Pflegeheim::class, 'p')
            ->leftJoin(User::class, 'u', Join::WITH, $qb->expr()->eq('p.id', 'u.pflegeheim'))
            ->groupBy('p.id')
            ->having($qb->expr()->lt($qb->expr()->count('u.id'), 'p.maxContacts'))
            ->setParameter('latitude_offset', 111.3)
            // Der Abstand zwischen zwei Längengraden beträgt in Sachsen ca 70 Kilometer
            ->setParameter('longitude_offset', 70)
            ->setParameter('postal_lat', $postalCode->getLatitude())
            ->setParameter('postal_lon', $postalCode->getLongitude())
            ->orderBy('dist')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_OBJECT);

        if (count($res) !== 1) {
            return null;
        }

        $distance = $res[0]['dist'];
        $pflegeheim = $res[0]['ph'];

        return $pflegeheim;
    }
}