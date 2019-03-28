<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 27.03.19
 * Time: 20:13
 */

namespace App\Controller;


use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InvoiceFormType;


/**
 * Class InvoicesController
 *
 * TODO:
 *  - https://symfony.com/doc/current/form/form_collections.html
 *
 * @package App\Controller
 */
class InvoicesController extends AbstractController
{

    /**
     * InvoicesController HOME index
     */
    public function index()
    {
        // TODO: dashboard

    }


    public function showId($id = null)
    {
        if (is_null($id)) {
            # TODO
            // Exception!
            return new Response(
                'NO ID'
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $item = $entityManager->getRepository(Invoice::class)->findBy(array('id'=>$id));
        dump($item);

        return $this->render('invoices/invoices_item.html.twig', [
            'title' => 'Item',
            'item' => $item,
        ]);
    }


    /**
     * InvoicesController HOME index
     */
    public function list($slug=null)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $list = $entityManager->getRepository(Invoice::class)->findByUser($this->getUser()->getId());
        dump($list);

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

        $invoiceItems = array();

        if (is_null($invoiceId)) {
            $invoice = new Invoice();
        } else {
            $invoice = $entityManager->getRepository(Invoice::class)->findOneBy(array('id'=>$invoiceId));
            $invoiceItems = $entityManager->getRepository(InvoiceItem::class)->findByInvoice($invoiceId);
        }

        dump($invoice);
        dump($invoiceItems);

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

            return $this->redirect('/invoice/edit/'. $invoice->getId());
        }

        return $this->render('invoices/invoices_edit.html.twig', [
            'invoicesEdit' => $form->createView(),
        ]);
    }

}