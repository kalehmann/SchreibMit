<?php

namespace DrkDD\Pflegefinder\Repository;

use DrkDD\Pflegefinder\Entity\Pflegeheim;
use DrkDD\Pflegefinder\Entity\PostalCode;
use Doctrine\ORM\AbstractQuery;

/**
 * Class PflegeHeimRepository
 */
class PflegeHeimRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param PostalCode $postalCode
     * @return Pflegeheim|null
     */
    public function findNearestForPostalCode(PostalCode $postalCode): ?Pflegeheim
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        // Der Abstand zwischen zwei Längengrade beträgt in Sachsen ca 70 Kilometer

        $res = $qb->select(
            'p AS ph',
            'SQRT( ((p.latitude - :postal_lat) * (p.latitude - :postal_lat) * 111.3 * 111.3) + ((p.longitude - :postal_lon) * (p.longitude - :postal_lon) * 70 * 70) ) AS dist'
        )
            ->addSelect()
            ->from(Pflegeheim::class, 'p')
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