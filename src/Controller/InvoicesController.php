<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 27.03.19
 * Time: 20:13
 */

namespace App\Controller;


use App\Entity\Invoice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InvoiceFormType;


class InvoicesController extends AbstractController
{




    /**
     * InvoicesController HOME index
     */
    public function index()
    {



    }


    public function showId($id = null)
    {

        $id=1;

        if (is_null($id)) {

            # TODO
            // Exception!

            return new Response(
                'NO ID'
            );

        }


        $entityManager = $this->getDoctrine()->getManager();


        $item = $entityManager->getRepository(Invoice::class)->findBy(array('id'=>$id));


        return $this->render('invoices/invoices_item.html.twig', [
            'title' => 'tt6666666666',
            'item' => $item,

        ]);





    }




    /**
     * InvoicesController HOME index
     */
    public function list($slug=null)
    {

        $list = array();

        //$repository = $this->getDoctrine()->getRepository(Invoice::class);
        //$movies = $repository->findall();
        //return $this->handleView($this->view($movies));

        //$user = $this->getUser()->getId();
        //var_dump($user->getId());

        $entityManager = $this->getDoctrine()->getManager();
//        $list = $entityManager->getRepository(Invoice::class)->findAll();
        $list = $entityManager->getRepository(Invoice::class)->findByUser($this->getUser()->getId());

        // $entityManager->getRepository(Invoice::class)->
        //$list = $repository->findByUser(1);
        //$list = $entityManager->findByUser(1);
        dump($list);


        //$user = $this->get('security.context')->getToken()->getUser();



        return $this->render('invoices/invoices_list.html.twig', [
            'title' => 'List',
            'list' => $list,

        ]);



    }


    /**
     * @Route("/invoice/edit/{invoiceId}", name="invoices_edit")
     */
    public function edit(Request $request, $invoiceId=null): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        if (is_null($invoiceId)) {
            $invoice = new Invoice();
        } else {
            $invoice = $entityManager->getRepository(Invoice::class)->findOneBy(array('id'=>$invoiceId));
        }

        dump($invoice);

        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoice);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );

            //return $this->redirectToRoute('/invoice/edit/'. $invoice->getId());
            return $this->redirect('/invoice/edit/'. $invoice->getId());
        }

        return $this->render('invoices/invoices_edit.html.twig', [
            'invoicesEdit' => $form->createView(),
        ]);



    }



}