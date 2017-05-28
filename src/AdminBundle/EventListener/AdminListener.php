<?php

namespace AdminBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use ShopBundle\Entity\Slider;
use ShopBundle\Entity\Text;
use ShopBundle\Entity\Image;
use ShopBundle\Entity\Picks;

use ShopBundle\Entity\Page;
use ShopBundle\Entity\PageElement;

use CMSBundle\Image\Optimizer;

class AdminListener implements EventSubscriberInterface
{

    protected $entityManager;
    protected $imagesOptimizer;

    public static function getSubscribedEvents()
    {

        return array(
            EasyAdminEvents::POST_PERSIST => 'onPostPersist',
            EasyAdminEvents::POST_UPDATE => 'onPostEdit'
        );
    }

    function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function setImagesOptimizer($imagesOptimizer)
    {
        $this->imagesOptimizer = $imagesOptimizer;
    }

    public function onPostPersist(GenericEvent $event)
    {

        $entity = $event['entity'];

        if(empty($entity)) {
            return;
        }

        if(!(($entity instanceof Slider) or ($entity instanceof Text) or ($entity instanceof Image) or ($entity instanceof Picks)))
        {
            return;
        }

        $page = $entity->getPage();

        if(empty($page) and (($entity instanceof Slider) or ($entity instanceof Text) or ($entity instanceof Picks))) {
            return;
        }

        if(!empty($page)) {
            $query = $this->entityManager->createQuery(
                    'SELECT pe '.
                    'FROM ShopBundle:PageElement pe '.
                    'WHERE pe.page = :page '.
                    'ORDER BY pe.position'
                )
                ->setParameter('page', $page->getId());
            $pageElements = $query->getResult();

            $newPosition = 1;
            foreach($pageElements as $pageElement) {
                $newPosition++;
            }

            $pageElement = new PageElement();
            $pageElement->setPage($entity->getPage());
            $pageElement->setElement($entity->getId());
            if ($entity instanceof Slider)
            {
                $pageElement->setFormat(PageElement::FORMAT_SLIDER);
            } else if ($entity instanceof Text)
            {
                $pageElement->setFormat(PageElement::FORMAT_TEXT);
            } else if ($entity instanceof Image)
            {
                $pageElement->setFormat(PageElement::FORMAT_IMAGE);
            } else if ($entity instanceof Picks)
            {
                $pageElement->setFormat(PageElement::FORMAT_PICKS);
            }
            $pageElement->setPosition($newPosition);
            $pageElement->setStatus(true);

            $this->entityManager->persist($pageElement);
            $this->entityManager->flush();
        }

        if ($entity instanceof Image)
        {
            $source = $entity->getImageSource();
            $sizes = array(
                array(345, 250),
                array(560, 420),
                array(1520, 686),
            );
            $allNewImageFiles = $this->imagesOptimizer->generateResizedImages($source, $sizes);
            $entity->setSmallImage($allNewImageFiles[0]);
            $entity->setMediumImage($allNewImageFiles[1]);
            $entity->setBigImage($allNewImageFiles[2]);

            $this->entityManager->flush();
        }
    }

    public function onPostEdit(GenericEvent $event)
    {
        $entity = $event['entity'];

        if ($entity instanceof Slider or $entity instanceof Text or $entity instanceof Image or $entity instanceof Picks)
        {
            $page = $entity->getPage();
            if (empty($page) and ($entity instanceof Slider or $entity instanceOf Text or $entity instanceof Picks))
            {
                return;
            }

            if (!empty($page))
            {
                $query = $this->entityManager->createQuery(
                        'SELECT pe '.
                        'FROM ShopBundle:PageElement pe '.
                        'WHERE pe.page = :id '.
                        'ORDER BY pe.position'
                    )
                    ->setParameter('id', $page->getId());
                $pageElements = $query->getResult();
                $newPosition = 1;
                foreach($pageElements as $pageElement) {
                    $newPosition++;
                }

                $pageElement = new PageElement();
                $pageElement->setPage($entity->getPage());
                $pageElement->setElement($entity->getId());
                if ($entity instanceof Slider)
                {
                    $pageElement->setFormat(PageElement::FORMAT_SLIDER);
                } else if ($entity instanceof Text)
                {
                    $pageElement->setFormat(PageElement::FORMAT_TEXT);
                } else if ($entity instanceof Picks)
                {
                    $pageElement->setFormat(PageElement::FORMAT_PICKS);
                }
                $pageElement->setPosition($newPosition);
                $pageElement->setStatus(true);

                $this->entityManager->persist($pageElement);
                $this->entityManager->flush();
            }
        }

        if($entity instanceof Image) {
            $source = $entity->getImageSource();

            $sizes = array(
                array(345, 250),
                array(560, 420),
                array(1520, 686),
            );
            $allNewImageFiles = $this->imagesOptimizer->generateResizedImages($source, $sizes);
            $entity->setSmallImage($allNewImageFiles[0]);
            $entity->setMediumImage($allNewImageFiles[1]);
            $entity->setBigImage($allNewImageFiles[2]);
            $this->entityManager->flush();
        }
    }

}
