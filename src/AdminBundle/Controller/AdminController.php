<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

//use Xmon\ColorPickerTypeBundle\Form\Type\ColorPickerType;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{

    /**
     * Add a shortcut to current object linked elements
     *
     * @return Route
     */
    protected function linkedAction()
    {
        // Fast custom action for looking at entity's images
        // TODO: finalize
        switch ($this->request->query->get('entity')) {
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
//        if($entity instanceof Slider)
//        {
//            $newForm->add('color', ColorPickerType::class);
//        }
        return $newForm;
    }
}
