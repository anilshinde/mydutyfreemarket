<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SiteController extends Controller
{
    protected $cache;

    /**
     * @Route("/")
     * @Route("/{category}/")
     * @Route("/{category}/{page}")
     * @Route("/{parentCategory}/{category}")
     * @Route("/{parentCategory}/{category}/{page}")
     */
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request, $category = null, $parentCategory = null, $page = null)
    {
        // Get cache service
        if ($this->cache === null) {
            $this->cache = $this->container->get('app.redis_connector');
        }

        // Get current URL to get page
        $route = $request->get('_route');
        $url = $request->getUri();
        $urlParts = parse_url($url);
        $domain = $urlParts['host'];

        // Get site config using dns
        $site = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:SiteConfig')
            ->findSiteConfigByDomain($domain);

        // Get the site categories tree and the current page category
        // First, get the nav categories tree entirely from Redis cache using either its page and/or category identifier
        $categories = null;
        $currentCategory = null;
        $currentPage = null;

        if (!empty($category)) {
            $keyNav = 'frontpage-nav-'.$category;
            list($categories, $currentCategory) = $this->cache->fetch($keyNav);
        }
        if (empty($category) or empty($categories)) {
            list($categories, $currentCategory, $currentPage) = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Category')
                ->findCategoriesWithPage($category, $page);
            $category = $currentCategory->getQName();
            $keyNav = 'frontpage-nav-'.$category;
            $this->cache->save($keyNav, array($categories, $currentCategory));
        }

        // Then, try to get all the page content entirely from Redis cache using its category identifier
        $keyPage = 'frontpage-all-'.$category;
        $page = $this->cache->fetch($keyPage);

        if (empty($page)) {
            // Get page elements structure entirely from Redis cache using its category identifier
            $keyPageElements = 'frontpage-pageelements-'.$category;
            $pageElements = $this->cache->fetch($keyPageElements);

            if (empty($pageElements)) {
                // Get page elements structure from MySQL db using its category identifier
                $pageElements = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ShopBundle:PageElement')
                    ->findAllPageElementsOrderedByPosition($category);
                $this->cache->save($keyPageElements, $pageElements);
            }

            // Get each page element content to rebuild the page content entirely
            $page = array();
            foreach ($pageElements as $pageElement) {
                // First, try to get element content from Redis cache using its page identifier
                $keyPageElement = 'frontpage-element-'.$pageElement->getId();
                $pageElementFromCache = $this->cache->fetch($keyPageElement);
                if (empty($pageElementFromCache)) {
                    $element = $this->getElementByFormatFromPageElement($pageElement);
                    $page[] = $element;
                    $this->cache->save($keyPageElement, $element);
                }
            }
            // Save the entire content of the page in Redis cache
            $this->cache->save($keyPage, $page);
        }
        return $this->render('ShopBundle:Default:index.html.twig', array(
            'site' => $site,
            'categoriesTree' => $categories,
            'currentCategory' => $currentCategory,
            'currentPage' => $currentPage,
            'currentPageContent' => $page
        ));
    }

    private function getElementByFormatFromPageElement($pageElement)
    {
        $element = array();
        $element['format'] = $pageElement->getFormat();

        switch ($pageElement->getFormat()) {
            case \ShopBundle\Entity\PageElement::FORMAT_TEXT:
                $element['element'] = $this->getTextFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_SLIDER:
                $element['element'] = $this->getSliderFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_FORM:
                $element['element'] = $this->getFormFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_IMAGE:
                $element['element'] = $this->getImageFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_MAP:
                $element['element'] = $this->getMapFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_VIDEO:
                $element['element'] = $this->getVideoFromPageElement($pageElement);
                break;
            case \ShopBundle\Entity\PageElement::FORMAT_PICKS:
                $element['element'] = $this->getPicksFromPageElement($pageElement);
                break;
            default:
        }

        return $element;
    }

    private function getTextFromPageElement($pageElement)
    {
        $keyText = 'frontpage-text-'.$pageElement->getElement();
        $text = $this->cache->fetch($keyText);

        if (empty($text)) {
            $text = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Text')
                ->findText($pageElement->getElement());
            $this->cache->save($keyText, $text);
        }
    }

    private function getSliderFromPageElement($pageElement)
    {
        $keySlider = 'frontpage-slider-'.$pageElement->getElement();
        $slider = $this->cache->fetch($keySlider);

        if (empty($slider)) {
            $slider = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Slider')
                ->findSliderWithImages($pageElement->getElement());
            $this->cache->save($keySlider, $slider);
        }
        return $slider;
    }

    private function getFormFromPageElement($pageElement)
    {
        // TODO
    }

    private function getImageFromPageElement($pageElement)
    {
        // TODO: create template
    }

    private function getPicksFromPageElement($pageElement)
    {
        // Get picks from Redis cache using its id
        $keyPicks = 'frontpage-picks-'.$pageElement->getElement();
        $picks = $this->cache->fetch($keyPicks);

        if (empty($picks)) {
            // Get picks from MySQL db using its id
            $picks = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShopBundle:Picks')
                ->findPicksWithImagesAndTextesAndProducts($pageElement->getElement());
            $this->cache->save($keyPicks, $picks);
        }
        return $picks;
    }

    private function getVideoFromPageElement($pageElement)
    {
        // TODO: create entity, admin, template,...
        return null;
    }

    private function getMapFromPageElement($pageElement)
    {
        // TODO: create entity, admin, template,...
        return null;
    }
}
