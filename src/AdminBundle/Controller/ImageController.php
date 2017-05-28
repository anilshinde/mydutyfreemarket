<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use ShopBundle\Entity\PageElement;

use AdminBundle\Controller\AdminController;


class ImageController extends AdminController
{

    /**
     * Delete page elements linked to current image object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateImageEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_IMAGE);
        $pageElements = $query->getResult();

        // Flush Sliders and Image associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT s '.
                'FROM ShopBundle:Slider s '.
                'WHERE :image MEMBER OF s.images '
            )
            ->setParameter('image', $entity->getId());
        $sliders = $query->getResult();
        foreach($sliders as $slider) {
            $slider->removeImage($entity);
            $this->em->persist($slider);
            $this->em->flush();
        }

        // Rebuild Slider and Image associations
        foreach($entity->getSliders() as $slider) {
            if(!$slider->getImages()->contains($entity)) {
                $slider->addImage($entity);
                $this->em->persist($slider);
                $this->em->flush();
            }
        }

        // Flush Pickss and Image associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT p '.
                'FROM ShopBundle:Picks p '.
                'WHERE :image MEMBER OF p.images '
            )
            ->setParameter('image', $entity->getId());
        $pickss = $query->getResult();
        foreach($pickss as $picks) {
            $picks->removeImage($entity);
            $this->em->persist($picks);
            $this->em->flush();
        }

        // Rebuild Pickss and Image associations
        foreach($entity->getPickss() as $picks) {
            if(!$picks->getImages()->contains($entity)) {
                $picks->addImage($entity);
                $this->em->persist($picks);
                $this->em->flush();
            }
        }
    }

    /**
     * Delete page elements linked to current image before removing it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preRemoveImageEntity($entity)
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
                ->setParameter('format', PageElement::FORMAT_IMAGE);

            $pageElements = $query->getResult();
        }
    }
}
