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
use App\Form\InvoiceItemFormType;
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
 *  - https://symfony.com/doc/4.0/security.html
 *  - https://www.tomasvotruba.cz/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 *  - https://symfony.com/doc/current/deployment.html
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (is_null($id)) {
            # TODO
            // Exception!
            return new Response(
                'NO ID'
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $item = $entityManager->getRepository(Invoice::class)->findOneByUserById($id, $this->getUser()->getId());



        if (empty($item)) {
            throw $this->createNotFoundException('Invoice does not exist');
        }

        $invoiceItems = $entityManager->getRepository(InvoiceItem::class)->findByInvoice($id);

        dump($item);
        dump($invoiceItems);

        //invoices/invoices_item.html.twig
        return $this->render('invoices/invoices_show.html.twig', [
            'title' => 'Item #' . $item->getId(),
            'item' => $item,
            'invoiceItems' => $invoiceItems,
        ]);
    }


    /**
     * InvoicesController HOME index
     */
    public function list($slug=null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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


    /**
     * @Route("/invoiceitem/edit/{invoiceItemId}", name="invoiceitem_edit")
     */
    public function editInvoiceItem(Request $request, $invoiceItemId=null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $invoiceItems = array();

        if (is_null($invoiceItemId)) {
            $invoiceItem = new InvoiceItem();
        } else {
            $invoiceItem = $entityManager->getRepository(InvoiceItem::class)->findOneBy(array('id'=>$invoiceItemId));

        }

        dump($invoiceItem);


        //$form = $this->createForm(InvoiceFormType::class, $invoiceItem);
        $form = $this->createForm(InvoiceItemFormType::class,
            $invoiceItem, ['attr' => ['id' => 'invoice_item_form_id']]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoiceItem);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );

            //return $this->redirect('/invoice/show/id/'. $invoiceItem->getInvoiceId());

            

        }

        return $this->render('invoices/invoice_item_edit.html.twig', [
            'invoiceItemEdit' => $form->createView(),
            'invoiceItemId' => $invoiceItem->getId(),
        ]);
    }

}