<?php
namespace App\Controller;

use App\Entity\Invoice;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// use Symfony\Component\Validator\Constraints\DateTime;

class DevController extends AbstractController
{
    public function test()
    {
        $number = random_int(0, 100);
        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }


    /**
     * TWIG test
     */
    public function twig()
    {
        $number = random_int(0, 100);
        $url = $this->generateUrl(
            'devtwig',
            ['slug' => 'my-blog-post']
        );

        return $this->render('dev/twig.html.twig', [
            'number' => $number,
            'url' => $url,

        ]);
    }


    public function show($slug=null, LoggerInterface $logger)
    {
        $out = var_export($slug, 1);

        dump($slug, $this);

        $logger->info('TRESSS');

        return new Response(
            '<html><body><pre>'.$out.'</pre></body></html>'
        );
    }


    public function save($slug=null, LoggerInterface $logger)
    {
        $out = 'ooo';

        $ts = date('dHis');
        $out = $ts;

        $entityManager = $this->getDoctrine()->getManager();

        $invoice = new Invoice();
        $invoice->setTitle($ts);

        //$issued = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now')); # also tried using \DateTimeImmutable
        $issued = \DateTime::createFromFormat('Y-m-d', strtotime('now')); # also tried using \DateTimeImmutable


        //$d = date('Y-m-d');
        //$issued = new DateTime($d);
        //$issued->format('H-m-d');
        //$invoice->setIssued($issued);

        $invoice->setNumber('FW-' . date('Y-m-d H:m:s'));

        $entityManager->persist($invoice);

        $entityManager->flush();

        //$entityManager->getRepository(Invoice::class)->findAll();
        //$entityManager->getRepository(Invoice::class)->findOneBy('id' => 1);

        $logger->info('SSSS');
        return new Response(
            '<html><body><pre>'.$out.'</pre></body></html>'
        );
    }





}