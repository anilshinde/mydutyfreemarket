<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use AdminBundle\Controller\AdminController;

class PageElementController extends AdminController
{

    /**
     * Move block up in in the page structure
     *
     */
    protected function moveUpPageElementAction()
    {
        if (!empty($this->request->query->get('id'))) {
            // Get all page elements, to have the max rank range and the current one
            $query = $this->em->createQuery('SELECT pe FROM ShopBundle:PageElement pe');
            $pageElements = $query->getResult();

            $pageElementCurrent = null;
            foreach ($pageElements as $pageElement) {
                if ((string) $pageElement->getId() === (string) $this->request->query->get('id')) {
                    $pageElementCurrent = $pageElement;
                }
            }

            if (!empty($pageElementCurrent)) {
                // Get all page elements of the current page
                $pageElementsCurrent = null;
                foreach ($pageElements as $pageElement) {
                    if ((string) $pageElement->getPage()->getId() === (string) $pageElementCurrent->getPage()->getId()) {
                        $pageElementsCurrent[] = $pageElement;
                    }
                }

                // Increase position of the current page element
                if ($pageElementCurrent->getPosition() > 1) {
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:PageElement pe '.
                            'SET pe.position = pe.position - 1 '.
                            'WHERE pe.id = :id '
                        )
                        ->setParameter('id', $pageElementCurrent->getId());
                    $updated = $query->execute();
                } else {
                    $updated = 0;
                }

                if ($updated > 0) {
                    // Decrease position of the page element which was at that position
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:PageElement pe '.
                            'SET pe.position = pe.position + 1 '.
                            'WHERE pe.id != :id '.
                            'AND pe.position = :position - 1 '.
                            'AND pe.page = :page '
                        )
                        ->setParameter('page', $pageElementCurrent->getPage())
                        ->setParameter('position', $pageElementCurrent->getPosition())
                        ->setParameter('id', $pageElementCurrent->getId());
                    $updated = $query->execute();
                }
            }
        }

        // Redirect to the 'list' view of the given entity item
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }

    /**
     * Move block down in the page structure
     *
     */
    protected function moveDownPageElementAction()
    {
        if (!empty($this->request->query->get('id'))) {
            // Get all page elements, to have the max rank range and the current page ones
            $query = $this->em->createQuery(
                    'SELECT pe FROM ShopBundle:PageElement pe'
                );
            $pageElements = $query->getResult();

            $pageElementCurrent = null;
            foreach ($pageElements as $pageElement) {
                if ((string) $pageElement->getId() === (string) $this->request->query->get('id')) {
                    $pageElementCurrent = $pageElement;
                }
            }

            if (!empty($pageElementCurrent)) {
                // Get all page elements of the current page
                $pageElementsCurrent = null;
                foreach ($pageElements as $pageElement) {
                    if ((string) $pageElement->getPage()->getId() === (string) $pageElementCurrent->getPage()->getId()) {
                        $pageElementsCurrent[] = $pageElement;
                    }
                }

                // Increase position of the current page element
                if ($pageElementCurrent->getPosition() < count($pageElementsCurrent)) {
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:PageElement pe '.
                            'SET pe.position =  pe.position + 1'.
                            'WHERE pe.id = :id'
                        )
                        ->setParameter('id', $pageElementCurrent->getId());
                    $updated = $query->execute();
                } else {
                    $updated = 0;
                }

                if ($updated > 0) {
                    // Decrease position of the page element which was at that position
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:PageElement pe '.
                            'SET pe.position = pe.position - 1 '.
                            'WHERE pe.id != :id '.
                            'AND pe.position = :position + 1 '.
                            'AND pe.page = :page '
                        )
                        ->setParameter('page', $pageElementCurrent->getPage())
                        ->setParameter('position', $pageElementCurrent->getPosition())
                        ->setParameter('id', $pageElementCurrent->getId());
                    $updated = $query->execute();
                }
            }
        }

        // Redirect to the 'list' view of the given entity item
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }
}
