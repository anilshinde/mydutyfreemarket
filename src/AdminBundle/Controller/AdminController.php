<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use ShopBundle\Entity\Slider;
use ShopBundle\Entity\Page;
use ShopBundle\Entity\PageElement;

use Xmon\ColorPickerTypeBundle\Form\Type\ColorPickerType;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{


   /**
     * Add a shortcut to current object linked elements
     *
     * @return Route
     */
    protected function linkedAction() {

        switch($this->request->query->get('entity'))
        {
            case 'Slider':
                $entity = 'Image';
                $linked = 'slider';
                break;
            default:
                $entity = null;
                $linked = null;
        }

        // redirect to the 'list' view of the given entity item
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'search',
            $linked => $this->request->query->get('id'),
            'entity' => $entity,
        ));

    }


   /**
     * Delete page elements linked to current slider object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateSliderEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_SLIDER);

        $pageElements = $query->getResult();        
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
        $page = $entity->getPage();

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

   /**
     * Delete page elements linked to current picks object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdatePicksEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_PICKS);

        $pageElements = $query->getResult();
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
        $page = $entity->getPage();

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

   /**
     * Delete page elements linked to current text object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateTextEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_TEXT);

        $pageElements = $query->getResult();
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
        $page = $entity->getPage();

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

   /**
     * Delete page elements linked to current image object before updating it
     *
     * @param $entity
     *
     * @return null
     */
    protected function preUpdateImageEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElement pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElement::FORMAT_IMAGE);

        $pageElements = $query->getResult();
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

   /**
     * Add field to edit form
     *
     * @param $entity
     * @param array $entityProperties
     *
     * @return Form
     */
    protected function createEditForm($entity, array $entityProperties)
    {
        $editForm = parent::createEditForm($entity, $entityProperties);

        if($entity instanceof Slider)
        {
        }
        return $editForm;
    }

    /**
     * Add field to add form
     *
     * @param $entity
     * @param array $entityProperties
     *
     * @return Form
     */
    protected function createNewForm($entity, array $entityProperties)
    {
        $newForm = parent::createNewForm($entity, $entityProperties);

        if($entity instanceof Slider)
        {
            $newForm->add('color', ColorPickerType::class);
        }

        return $newForm;
    }

}
