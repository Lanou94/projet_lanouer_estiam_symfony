<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function newAction(Request $request)
    {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash(
                'success',
    'produit ajouter avec succés!'
            );

            return $this->redirectToRoute('product');
        }

        return $this->render('default/product.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/showAllProducts" , name="showAllProducts")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllProducts(Request $request){
        $em = $this->getDoctrine();
        $products= $em->getRepository("AppBundle:Product")->findAll();
        return $this->render("default/allProducts.html.twig",["products"=> $products]);
    }

    /**
     * @Route("/showAllStock" , name="showAllStock")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllStock(Request $request){
        $em = $this->getDoctrine();
        $products= $em->getRepository("AppBundle:Product")->findAllStock();
        return $this->render("default/allStock.html.twig",["products"=> $products]);
    }

    /**
     * @Route("/detailProduct/{id}", name="detailProduct")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailProductAction(Product $product){

        return $this->render('default/showProduct.html.twig',['product'=>$product]);

    }

    /**
     * @Route("/addInStock/{id}",name ="addInStock")
     *
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addInStock(Product $product)
    {
        $product->setStock(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("detailProduct",['id'=> $product->getId()]);
    }

    /**
     * @Route("/deleteInStock/{id}",name ="deleteInStock")
     *
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteInStock(Product $product)
    {
        $product->setStock(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("detailProduct",['id'=> $product->getId()]);
    }

}
