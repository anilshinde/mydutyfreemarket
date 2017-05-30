<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use ShopBundle\Entity\PageElement;

use AdminBundle\Controller\AdminController;

class PicksController extends AdminController
{

    /**
     * Delete page elements linked to current picks object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdatePicksEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_PICKS);
        $pageElements = $query->getResult();

        // Flush Pickss and Textes associations, will rebuild it just below
        $query = $this->em->createQuery(
                'SELECT t '.
                'FROM ShopBundle:Text t '.
                'WHERE :picks MEMBER OF t.pickss'
            )
            ->setParameter('picks', $entity->getId());

        $textes = $query->getResult();
        foreach($textes as $text) {
            $text->removePicks($entity);
            $this->em->persist($text);
            $this->em->flush();
        }

        // Rebuild Pickss and Textes associations
        $textes = $entity->getTextes();
        foreach($textes as $text) {
            $text->addPicks($entity);
            $this->em->persist($text);
            $this->em->flush();
        }

        // Flush Pickss and Images associations, will rebuild it just below
        $query = $this->em->createQuery(
                'SELECT i '.
                'FROM ShopBundle:Image i '.
                'WHERE :picks MEMBER OF i.pickss '
            )
            ->setParameter('picks', $entity->getId());

        $images = $query->getResult();
        foreach($images as $image) {
            $image->removePicks($entity);
            $this->em->persist($image);
            $this->em->flush();
        }

        // Rebuild Pickss and Images associations
        $images = $entity->getImages();
        foreach($images as $image) {
            $image->addPicks($entity);
            $this->em->persist($image);
            $this->em->flush();
        }

        // Flush Picks and Products associations, will rebuild it just below
        $query = $this->em->createQuery(
                'SELECT p '.
                'FROM ShopBundle:Product p '.
                'WHERE :picks MEMBER OF p.pickss '
            )
            ->setParameter('picks', $entity->getId());

        $products = $query->getResult();
        foreach($products as $product) {
            $product->removePicks($entity);
            $this->em->persist($product);
            $this->em->flush();
        }

        // Rebuild Pickss and Products associations
        $products = $entity->getProducts();
        foreach($products as $product) {
            $product->addPicks($entity);
            $this->em->persist($product);
            $this->em->flush();
        }

    }

   /**
     * Delete page elements linked to current picks object before removing it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preRemovePicksEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $page = $entity->getPage();
        if(!empty($page)) {
            $query = $this->em->createQuery(
                    'DELETE '.
                    'FROM ShopBundle:PageElement pe '.
                    'WHERE pe.page = :id '.
                    'AND pe.element = :element '.
                    'AND pe.format = :format'
                )
                ->setParameter('id', $page->getId())
                ->setParameter('element', $entity->getId())
                ->setParameter('format', PageElement::FORMAT_PICKS);
            $pageElements = $query->getResult();
        }
    }

}
