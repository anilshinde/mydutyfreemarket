<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use ShopBundle\Entity\Slider;
use ShopBundle\Entity\Page;
use ShopBundle\Entity\PageElements;

use Xmon\ColorPickerTypeBundle\Form\Type\ColorPickerType;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{

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


    protected function preUpdateSliderEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElements::FORMAT_SLIDER);

        $pageElements = $query->getResult();        
    }

    protected function preRemoveSliderEntity($entity)
    {
        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.page = :id '.
                'AND pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('id', $page->getId())
            ->setParameter('element', $entity->getId())
            ->setParameter('format', PageElements::FORMAT_SLIDER);

        $pageElements = $query->getResult();
    }

    protected function preUpdateTextEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElements::FORMAT_TEXT);

        $pageElements = $query->getResult();
    }

    protected function preRemoveTextEntity($entity)
    {
        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.page = :id '.
                'AND pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('id', $page->getId())
            ->setParameter('element', $entity->getId())
            ->setParameter('format', PageElements::FORMAT_TEXT);

        $pageElements = $query->getResult();
    }

    protected function preUpdateImageEntity($entity)
    {

        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('element', $this->request->get('id'))
            ->setParameter('format', PageElements::FORMAT_IMAGE);

        $pageElements = $query->getResult();
    }

    protected function preRemoveImageEntity($entity)
    {
        $page = $entity->getPage();

        $query = $this->em->createQuery(
                'DELETE '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.page = :id '.
                'AND pe.element = :element '.
                'AND pe.format = :format'
            )
            ->setParameter('id', $page->getId())
            ->setParameter('element', $entity->getId())
            ->setParameter('format', PageElements::FORMAT_IMAGE);

        $pageElements = $query->getResult();
    }

    protected function createEditForm($entity, array $entityProperties)
    {
        $editForm = parent::createEditForm($entity, $entityProperties);

        if($entity instanceof Slider)
        {
        }
        return $editForm;
    }

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
