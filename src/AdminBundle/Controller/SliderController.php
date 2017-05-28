<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use AdminBundle\Controller\AdminController;


class SliderController extends AdminController
{

    /**
     * Delete page elements linked to current slider object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateSliderEntity($entity)
    {
        // Flush Pages and Elements associations, will rebuild it after update
        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_SLIDER);
        $pageElements = $query->getResult();

        // Flush Slider and Images associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT i '.
                'FROM ShopBundle:Image i '.
                'WHERE :slider MEMBER OF i.sliders '
            )
            ->setParameter('slider', $entity->getId());
        $images = $query->getResult();
        foreach($images as $image) {
            $image->removeSlider($entity);
            $this->em->persist($image);
            $this->em->flush();
        }

        // Rebuild Slider and Images associations
        foreach($entity->getImages() as $image) {
            if(!$image->getSliders()->contains($entity)) {
                $image->addSlider($entity);
                $this->em->persist($image);
                $this->em->flush();
            }
        }
    }

    /**
     * Delete page elements linked to current slider object before removing it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preRemoveSliderEntity($entity)
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
                ->setParameter('format', PageElement::FORMAT_SLIDER);
            $pageElements = $query->getResult();
        }
    }

}
