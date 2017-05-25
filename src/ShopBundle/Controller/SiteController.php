<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SiteController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction($productsBySerie = 4)
    {

        $pageElements = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:PageElement')
            ->findAllPageElementsOrderedByPosition('accueil');

        $products = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Product')
            ->findAllWithImagesAndOrderedByName();

        $sliders = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Slider')
            ->findAllWithImagesAndOrderedByName('accueil');

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('accueil');

        $picks = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Picks')
            ->findAllWithImagesAndTextesOrderedByName('accueil');

        return $this->render('ShopBundle:Default:index.html.twig', array(
            'products' => $products,
            'countProducts' => count($products),
            'seriesProducts' => 2, 
            'productsBySerie' => $productsBySerie,
            'slider' => $sliders[0],
            'texte' => $textes[0],
            'picks' => $picks[0],
            'tab1' => 'Accueil'
        ));
    }

    /**
     * @Route("/achat-fers-a-cheveux-professionnel/{category}")
     */
    public function galleryAction($category = null, $productsBySerie = 4)
    {

        $products = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Product')
            ->findAllWithImagesAndOrderedByName($category);

        $sliders = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Slider')
            ->findAllWithImagesAndOrderedByName('boutique');

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('boutique');

        return $this->render('ShopBundle:Default:gallery.html.twig', array(
            'category' => $category,
            'products' => $products,
            'countProducts' => count($products),
            'seriesProducts' => (int) (count($products) / $productsBySerie),
            'productsBySerie' => $productsBySerie,
            'slider' => $sliders[0],
            'texte' => $textes[0],
            'tab1' => 'Boutique en ligne'
        ));
    } 

    /**
     * @Route("/acheter-fer-a-cheveux-professionnel/{productQName}")
     */
    public function productAction($productQName = null)
    {

        $products = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Product')
            ->findAllWithImagesAndOrderedByName(null, $productQName);

        if (!$products) {
            throw $this->createNotFoundException(
                'No product found for id '.$productQName
            );
        }

        return $this->render('ShopBundle:Default:product.html.twig', array(
            'category' => $category,
            'product' => $products[0],
            'tab1' => 'Achat ' . $products[0]->getName()
        ));
    }

    /**
     * @Route("/contact")
     */
    public function contactAction()
    {
        $sliders = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Slider')
            ->findAllWithImagesAndOrderedByName('contact');

        return $this->render('ShopBundle:Default:contact.html.twig', array('slider' => $sliders[0], 'tab1' => 'Contact'));
    }

    /**
     * @Route("/a-propos-jose-eber-coiffure")
     */
    public function aboutAction()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('a-propos');

        return $this->render('ShopBundle:Default:about.html.twig', array('texte' => $textes[0], 'tab1' => 'A propos'));
    }

    /**
     * @Route("/conseils-professionnels/videos-coiffure-fer-a-lisser-conseils-professionnel")
     */
    public function other1Action()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('conseils-video');
	
        return $this->render('ShopBundle:Default:other1.html.twig', array('texte' => $textes[0], 'tab1' => 'Conseils'));
    }

    /**
     * @Route("/conseils-professionnels/fers-a-lisser-et-boucler-conseils-professionnel-materiaux-ceramique")
     */
    public function other2Action()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('conseils-materiaux');

        $sliders = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Slider')
            ->findAllWithImagesAndOrderedByName('conseils-materiaux');

        return $this->render('ShopBundle:Default:other2.html.twig', array('texte' => $textes[0], 'slider' => $sliders[0], 'tab1' => 'Conseils'));
    }

    /**
     * @Route("/conseils-professionnels/fer-a-lisser-et-boucler-conseils-professionnel-utilisation")
     */
    public function other3Action()
    {
        $sliders = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Slider')
            ->findAllWithImagesAndOrderedByName('conseils-utilisation');

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('conseils-utilisation');

        return $this->render('ShopBundle:Default:other3.html.twig', array('texte' => $textes[0], 'slider' => $sliders[0], 'tab1' => 'Conseils'));
    }

    /**
     * @Route("/les-revendeurs-agrees-de-fers-a-lisser-professionnel")
     */
    public function sellersAction()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('revendeurs-agrees');

        return $this->render('ShopBundle:Default:sellers.html.twig', array('texte' => $textes[0], 'tab1' => 'Nos services'));
    }

    /**
     * @Route("/fer-a-lisser-avis-des-consommateurs")
     */
    public function other4Action()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('faq');

        return $this->render('ShopBundle:Default:other4.html.twig', array('texte' => $textes[0], 'tab1' => 'A propos'));
    }

    /**
     * @Route("/fer-a-lisser-professionnel-garantie-a-vie")
     */
    public function warantAction()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('garantie');

        return $this->render('ShopBundle:Default:warant.html.twig', array('texte' => $textes[0], 'tab1' => 'Nos services'));
    }

    /**
     * @Route("/fer-a-lisser-enregister-un-produit")
     */
    public function registerAction()
    {
        return $this->render('ShopBundle:Default:register.html.twig', array('texte' => $textes[0], 'tab1' => 'Nos services'));
    }

    /**
     * @Route("/fer-a-lisser-livraison-gratuite")
     */
    public function shippingAction()
    {

        $textes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShopBundle:Text')
            ->findAllTextesOrderedByName('livraison');

        return $this->render('ShopBundle:Default:shipping.html.twig', array('texte' => $textes[0], 'tab1' => 'Nos services'));

    }

}
