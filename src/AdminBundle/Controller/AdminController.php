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

        // Fast custom action for looking at entity's images
        // TODO: finalize
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

        // Redirect to the 'list' view of the given entity item
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

        foreach($images as $image) {
            $image->setProduct(null);
            $this->em->persist($image);
            $this->em->flush();
        }

        // Rebuild Product and its images associations
        $images = $entity->getImages();
        if(count($images) > 0) {
            foreach($images as $image) {
                $image->setProduct($entity);
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
        foreach($pickss as $picks) {
            $picks->removeText($entity);
            $this->em->persist($picks);
            $this->em->flush();
        }

        // Rebuild Picks and Textes associations
        foreach($entity->getPickss() as $picks) {
            if(!$picks->getTextes()->contains($entity)) {
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
                ->setParameter('format', PageElement::FORMAT_TEXT);
            $pageElements = $query->getResult();
        }
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

    /**
     * Add subcategories
     *
     * @param $entity
     * @param array $entityProperties
     *
     */
    protected function preUpdateCategoryEntity($entity)
    {
        // Flush Category and its subcategories associations, will rebuild it below
        $query = $this->em->createQuery(
                'SELECT c '.
                'FROM ShopBundle:Category c '.
                'WHERE c.parent = :parent '
            )
            ->setParameter('parent', $entity->getId());
        $subcategories = $query->getResult();
        foreach($subcategories as $subcategory) {
            $subcategory->setParent(null);
            $this->em->persist($subcategory);
            $this->em->flush();
        }

        // Rebuild Category and its subcategories associations
        $subcategories = $entity->getSubcategories();
        if(count($subcategories) > 0) {
            foreach($subcategories as $subcategory) {
                $subcategory->setParent($entity);
                $this->em->persist($subcategory);
                $this->em->flush();
            }
        }
    }

    /**
     * Add page elements
     *
     * @param $entity
     * @param array $entityProperties
     *
     */
    protected function preUpdatePageEntity($entity)
    {
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
