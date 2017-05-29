<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SiteController extends Controller
{
    /**
     * @Route("/")
     * @Route("/{category}/")
     * @Route("/{category}/{page}")
     * @Route("/{parentCategory}/{category}")
     * @Route("/{parentCategory}/{category}/{page}")
     */
    public function indexAction($category = null, $parentCategory = null, $page = null)
    {
        $cache = $this->container->get('app.redis_connector');

        // Get the site categories tree and the current page category

        // First, get the nav categories tree entirely from Redis cache using either its page and/or category identifier
        $keyNav = 'frontpage-nav-'.$category;
        $categories = $cache->fetch($keyNav);

        if(empty($categories)) {

            list($categories, $currentCategory) = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Category')
                ->findCategories($category, $page);
            $category = $currentCategory->getQName();
            $cache->save($keyNav, $categories);
        }

        // Then, try to get all the page content entirely from Redis cache using its category identifier
        $keyPage = 'frontpage-all-'.$category;
        $page = $cache->fetch($keyPage);


        if(empty($page)) {
            // Get page elements structure entirely from Redis cache using its category identifier
            $keyPageElements = 'frontpage-pageelements-'.$category;
            $pageElements = $cache->fetch($keyPageElements);


            if(empty($pageElements)) {

                // Get page elements structure from MySQL db using its category identifier
                $pageElements = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ShopBundle:PageElement')
                    ->findAllPageElementsOrderedByPosition($category);
                $cache->save($keyPageElements, $pageElements);
            }

            // Get each page element content to rebuild the page content entirely
            $page = array();
            foreach($pageElements as $pageElement) {
                // First, try to get element content from Redis cache using its page identifier
                $keyPageElement = 'frontpage-element-'.$pageElement->getId();
                $pageElement = $cache->fetch($keyPageElement);

                if(empty($pageElement)) {
                    $element = array();
                    $element['format'] = $pageElement->getFormat();
                    switch($pageElement->getFormat()) {
                        case \ShopBundle\Entity\PageElement::FORMAT_TEXT :
                            $element['element'] = $this->getTextFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_SLIDER :
                            $element['element'] = $this->getSliderFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_FORM :
                            $element['element'] = $this->getFormFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_IMAGE :
                            $element['element'] = $this->getImageFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_MAP :
                            $element['element'] = $this->getMapFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_VIDEO :
                            $element['element'] = $this->getVideoFromPageElement($pageElement);
                            break;
                        case \ShopBundle\Entity\PageElement::FORMAT_PICKS :
                            $element['element'] = $this->getPicksFromPageElement($pageElement);
                            break;
                        default:
                    }
                    $page[] = $element;
                    $cache->save($keyPageElement, $element);
                }
            }
            // Save the entire content of the page in Redis cache
            $cache->save($keyPage, $page);
        }
        return $this->render('ShopBundle:Default:index.html.twig', array(
            'categories' => $categories,
            'tab1' => $currentCategory->getName(),
            'page' => $page
        ));
    }

    private function getTextFromPageElement($pageElement) {
        $keyText = 'frontpage-text-'.$pageElement->getElement();
        $text = $cache->fetch($keyText);


        if(empty($text)) {

            $text = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Text')
                ->findText($pageElement->getElement());
            $cache->save($keyText, $text);
        }
    }

    private function getSliderFromPageElement($pageElement) {
        $keySlider = 'frontpage-slider-'.$pageElement->getElement();
        $slider = $cache->fetch($keySlider);


        if(empty($slider)) {

            $slider = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Slider')
                ->findSliderWithImages($pageElement->getElement());
            $cache->save($keySlider, $slider);
        }
        return $slider;
    }

    private function getFormFromPageElement($pageElement) {
        // TODO
    }

    private function getImageFromPageElement($pageElement) {
        // TODO: create template
    }

    private function getPicksFromPageElement($pageElement) {
        // Get picks from Redis cache using its id
        $keyPicks = 'frontpage-picks-'.$pageElement->getElement();
        $picks = $cache->fetch($keyPicks);


        if(empty($picks)) {

            // Get picks from MySQL db using its id
            $picks = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Picks')
                ->findPicksWithImagesAndTextesAndProducts($pageElement->getElement());
            $cache->save($keyPicks, $picks);
        }
        return $picks;
    }

    private function getVideoFromPageElement($pageElement) {
        // TODO: create entity, admin, template,...
        return null;
    }

    private function getMapFromPageElement($pageElement) {
        // TODO: create entity, admin, template,...
        return null;
    }
}
