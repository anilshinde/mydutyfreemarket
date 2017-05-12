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

use ShopBundle\Entity\Page;
use ShopBundle\Entity\PageElements;

class AdminListener implements EventSubscriberInterface
{

    protected $em;

    public static function getSubscribedEvents()
    {

        return array(
            EasyAdminEvents::POST_PERSIST => 'onPostPersist',
            EasyAdminEvents::POST_UPDATE => 'onPostEdit'
        );
    }

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onPostPersist(GenericEvent $event)
    {

        $entity = $event['entity'];

        if(empty($entity)) {
            return;
        }

        if(!(($entity instanceof Slider) or ($entity instanceof Text) or ($entity instanceof Image)))
        {
            return;
        }

        $page = $entity->getPage();

        if(empty($page)) {
            return;
        }

        $query = $this->em->createQuery(
                'SELECT pe '.
                'FROM ShopBundle:PageElements pe '.
                'WHERE pe.id = :id '.
                'ORDER BY pe.position'
            )
            ->setParameter('id', $page->getId());

        $pageElements = $query->getResult();

        $newPosition = 1;
        foreach($pageElements as $pageElement) {
            $newPosition++;
        }

        $pageElement = new PageElements();
        $pageElement->setPage($entity->getPage());
        $pageElement->setElement($entity->getId());

        if($entity instanceof Slider) {
            $pageElement->setFormat(PageElements::FORMAT_SLIDER);
        } else if($entity instanceof Text) {
            $pageElement->setFormat(PageElements::FORMAT_TEXT);
        } else if($entity instanceof Image) {
            $pageElement->setFormat(PageElements::IMAGE);
        }

        $pageElement->setPosition($newPosition);
        $pageElement->setStatus(true);

        $this->em->persist($pageElement);

        $this->em->flush();

        if($entity instanceof Image) {

            $pathinfo = pathinfo($entity->getImageSource());
            if(!in_array($pathinfo['extension'], array('jpg', 'png'))) {
                return NULL;
            }

            $sizes = array(
                array(345, 250),
                array(560, 420),
                array(1520, 686),
            );

            $allNewImageFiles = array();
            foreach($sizes as $size) {

                list($width, $height) = $size;
                $imageSource = new \Imagick('/var/www/shopname/web/images/fers-a-cheveux/'.$entity->getImageSourceFile()->getClientOriginalName());
                $isImageResized = FALSE;

                try {
                    $imageSource->cropThumbnailImage($width, $height);
                    $imageSource->stripImage();
                    $imageSource->setInterlaceScheme(\Imagick::INTERLACE_PLANE);
                    $imageSource->setImageCompressionQuality(90);

                    $newImageFile = substr($entity->getImageSource(), 0 , strrpos($entity->getImageSource(), '.', -1)).'-'.($width).'x'.($height).'.'.$pathinfo['extension'];
                    $allNewImageFiles[] = $newImageFile;
                    $imageSource->writeImage('/var/www/shopname/web/images/fers-a-cheveux/'.$newImageFile);
                    $imageSource->destroy();
                    $isImageResized = TRUE;
                } catch(Exception $e) {
                    die('Unable to resize image "'.$entity->getImageSource().'" using sizes '.$width.'-'.$height.' : '.$e->getMessage());
                }
            }

            $entity->setSmallImage($allNewImageFiles[0]);
            $entity->setMediumImage($allNewImageFiles[1]);
            $entity->setBigImage($allNewImageFiles[2]);

            $this->em->flush();

        }

    }

    public function onPostEdit(GenericEvent $event)
    {


        $entity = $event['entity'];

        if ($entity instanceof Slider or $entity instanceof Text or $entity instanceof Image)
        {
            $page = $entity->getPage();

            if(empty($page)) {
                return;
            }

            $query = $this->em->createQuery(
                    'SELECT pe '.
                    'FROM ShopBundle:PageElements pe '.
                    'WHERE pe.page = :id '.
                    'AND pe.element = :element '.
                    'AND pe.format = :format'
                )
                ->setParameter('id', $page->getId())
                ->setParameter('element', $entity->getId())
                ->setParameter('format', PageElements::FORMAT_SLIDER);

            $pageElements = $query->getResult();

            if(empty($pageElements)) {
                $query = $this->em->createQuery(
                        'SELECT pe '.
                        'FROM ShopBundle:PageElements pe '.
                        'WHERE pe.page = :id '.
                        'ORDER BY pe.position'
                    )
                    ->setParameter('id', $page->getId());

                $pageElements = $query->getResult();

                $newPosition = 1;
                foreach($pageElements as $pageElement) {
                    $newPosition++;
                }

                $pageElement = new PageElements();
                $pageElement->setPage($entity->getPage());
                $pageElement->setElement($entity->getId());
                $pageElement->setFormat(PageElements::FORMAT_SLIDER);
                $pageElement->setPosition($newPosition);
                $pageElement->setStatus(true);

                $this->em->persist($pageElement);

                $this->em->flush();
            }

        }

        if($entity instanceof Image) {

            $pathinfo = pathinfo($entity->getImageSource());
            if(!in_array($pathinfo['extension'], array('jpg', 'png'))) {
                return NULL;
            }

            $sizes = array(
                array(345, 250),
                array(560, 420),
                array(1520, 686),
            );

            $allNewImageFiles = array();
            foreach($sizes as $size) {

                list($width, $height) = $size;
                $imageSource = new \Imagick('/var/www/shopname/web/images/fers-a-cheveux/'.$entity->getImageSourceFile()->getClientOriginalName());
                $isImageResized = FALSE;

                try {
                    $imageSource->cropThumbnailImage($width, $height);
                    $imageSource->stripImage();
                    $imageSource->setInterlaceScheme(\Imagick::INTERLACE_PLANE);
                    $imageSource->setImageCompressionQuality(90);

                    $newImageFile = substr($entity->getImageSource(), 0 , strrpos($entity->getImageSource(), '.', -1)).'-'.($width).'x'.($height).'.'.$pathinfo['extension'];
                    $allNewImageFiles[] = $newImageFile;
                    $imageSource->writeImage('/var/www/shopname/web/images/fers-a-cheveux/'.$newImageFile);
                    $imageSource->destroy();
                    $isImageResized = TRUE;
                } catch(Exception $e) {
                    die('Unable to resize image "'.$entity->getImageSource().'" using sizes '.$width.'-'.$height.' : '.$e->getMessage());
                }
            }

            $entity->setSmallImage($allNewImageFiles[0]);
            $entity->setMediumImage($allNewImageFiles[1]);
            $entity->setBigImage($allNewImageFiles[2]);

            $this->em->flush();

        }

    }

}
