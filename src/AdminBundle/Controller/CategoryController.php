<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use AdminBundle\Controller\AdminController;


class CategoryController extends AdminController
{

    /**
     * Move category up in the nav tree
     *
     */
    protected function moveUpCategoryAction() {
        if(!empty($this->request->query->get('id'))) {
            // Get all categories, to have the max rank range and the current one
            $query = $this->em->createQuery('SELECT c FROM ShopBundle:Category c');
            $categories = $query->getResult();

            $categoryCurrent = NULL;
            foreach($categories as $category) {
                if((string) $category->getId() === (string) $this->request->query->get('id')) {
                    $categoryCurrent = $category;
                }
            }

            if(!empty($categoryCurrent)) {
                // Increase rank of the current category
                if($categoryCurrent->getRank() > 1) {
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:Category c '.
                            'SET c.rank = c.rank - 1 '.
                            'WHERE c.id = :id '
                        )
                        ->setParameter('id', $categoryCurrent->getId());
                    $updated = $query->execute();
                } else {
                    $updated = 0;
                }

                if($updated > 0) {
                    // Decrease rank of the category which was at that position
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:Category c '.
                            'SET c.rank = c.rank + 1 '.
                            'WHERE c.id != :id '.
                            'AND c.rank = :rank - 1'
                        )
                        ->setParameter('rank', $categoryCurrent->getRank())
                        ->setParameter('id', $categoryCurrent->getId());
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
     * Move category down in the nav tree
     *
     */
    protected function moveDownCategoryAction() {
        if(!empty($this->request->query->get('id'))) {
            // Get all categories, to have the max rank range and the current one
            $query = $this->em->createQuery(
                    'SELECT c FROM ShopBundle:Category c'
                ); 
            $categories = $query->getResult();

            $categoryCurrent = NULL;
            foreach($categories as $category) {
                if((string) $category->getId() === (string) $this->request->query->get('id')) {
                    $categoryCurrent = $category;
                }
            }

            if(!empty($categoryCurrent)) {
                // Increase rank of the current category
                if($categoryCurrent->getRank() < count($categories)) {
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:Category c '.
                            'SET c.rank =  c.rank + 1'.
                            'WHERE c.id = :id'
                        )
                        ->setParameter('id', $categoryCurrent->getId());
                    $updated = $query->execute();
                } else {
                    $updated = 0;
                }

                if($updated > 0) {
                    // Decrease rank of the category which was at that position
                    $query = $this->em->createQuery(
                            'UPDATE ShopBundle:Category c '.
                            'SET c.rank = c.rank - 1 '.
                            'WHERE c.id != :id '.
                            'AND c.rank = :rank + 1'
                        )
                        ->setParameter('rank', $categoryCurrent->getRank())
                        ->setParameter('id', $categoryCurrent->getId());
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

}
