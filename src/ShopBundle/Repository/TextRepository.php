<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TextRepository extends \Doctrine\ORM\EntityRepository
{

    /*
     * Find text by its id
     *
     * return Text
     */
    public function findText($id = null)
    {
        if($id === null) {
            return null;
        }
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT t '.
                'FROM ShopBundle:Text t '.
                'WHERE t.id = :id '
            )
            ->setParameter('id', $id);
        $text = $query->getOneOrNullResult();
        return $text;
    }

}
