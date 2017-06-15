<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use ShopBundle\Entity\PageElement;


use AdminBundle\Controller\AdminController;

class TextController extends AdminController
{

    /**
     * Delete page elements linked to current text object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateTextEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_TEXT);
        $pageElements = $query->getResult();
 
        // Flush Picks and Textes associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT p '.
                'FROM ShopBundle:Picks p '.
                'WHERE :text MEMBER OF p.textes '
            )
            ->setParameter('text', $entity->getId());
        $pickss = $query->getResult();
        foreach ($pickss as $picks) {
            $picks->removeText($entity);
            $this->em->persist($picks);
            $this->em->flush();
        }

        // Rebuild Picks and Textes associations
        foreach ($entity->getPickss() as $picks) {
            if (!$picks->getTextes()->contains($entity)) {
                $picks->addText($entity);
                $this->em->persist($picks);
                $this->em->flush();
            }
        }
    }

   /**
     * Delete page elements linked to current text object before removing it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preRemoveTextEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $page = $entity->getPage();
        if (!empty($page)) {
            $query = $this->em->createQuery(
                    'DELETE '.
                    'FROM ShopBundle:PageElement pe '.
                    'WHERE pe.page = :id '.
                    'AND pe.element = :element '.
                    'AND pe.format = :format'
                )
                ->setParameter('id', $page->getId())
                ->setParameter('element', $entity->getId())
                ->setParameter('format', PageElement::FORMAT_TEXT);
            $pageElements = $query->getResult();
        }
    }
}
