<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use AdminBundle\Controller\AdminController;

class ProductController extends AdminController
{

    /**
     * Update product links
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateProductEntity($entity)
    {
        // Flush Product and its images associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT i '.
                'FROM ShopBundle:Image i '.
                'WHERE i.product = :product '
            )
            ->setParameter('product', $entity->getId());
        $images = $query->getResult();

        foreach ($images as $image) {
            $image->setProduct(null);
            $this->em->persist($image);
            $this->em->flush();
        }

        // Rebuild Product and its images associations
        $images = $entity->getImages();
        if (count($images) > 0) {
            foreach ($images as $image) {
                $image->setProduct($entity);
                $this->em->persist($image);
                $this->em->flush();
            }
        }

        // Flush Product and Pickss associations, will rebuild it just below
        $query = $this->em->createQuery(
                'SELECT p '.
                'FROM ShopBundle:Picks p '.
                'WHERE :product MEMBER OF p.products'
            )
            ->setParameter('product', $entity->getId());

        $pickss = $query->getResult();
        foreach ($pickss as $picks) {
            $picks->removeProduct($entity);
            $this->em->persist($picks);
            $this->em->flush();
        }

        // Rebuild Product and Pickss associations
        $pickss = $entity->getPickss();
        foreach ($pickss as $picks) {
            $picks->addProduct($entity);
            $this->em->persist($picks);
            $this->em->flush();
        }
    }
}
