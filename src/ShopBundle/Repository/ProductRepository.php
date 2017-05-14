<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{

    /*
     * Find all products
     *
     * return array of products
     */
    public function findAllWithImagesAndOrderedByName($category = null, $productQName = null)
    {


        $queryCategory = ($category !== null ? 'AND p.category = :category ' : '');
        $queryQName = ($productQName !== null ? 'AND p.qName = :qName ' : '');

        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p, pi '.
                'FROM ShopBundle:Product p, ShopBundle:Image pi '.
                'WHERE p.id=pi.product AND p.status=1 '.
                $queryCategory.' '.
                $queryQName.' '.
                'ORDER BY p.name ASC'
            );

        if($category !== null)
        {
            $query->setParameter('category', $category);
        }

        if($productQName !== null)
        {
            $query->setParameter('qName', $productQName);
        }

        $data = $query->getResult();

        $products = array();

        foreach($data as $row) {
            
              if($row instanceof \ShopBundle\Entity\Product) {
                  $product = $row;
              }

              if($row instanceof \ShopBundle\Entity\Image) {
                  $productImages = $row;
                  $product->setImage($productImages);
              } else {
                  $products[] = $product;
              }

        }

        return $products;

    }

}
