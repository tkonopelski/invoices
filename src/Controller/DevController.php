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

        $issued = \DateTime::createFromFormat('Y-m-d', strtotime('now'));

        $invoice->setNumber('FW-' . date('Y-m-d H:m:s'));

        $entityManager->persist($invoice);

        $entityManager->flush();

        $logger->info('SSSS');
        return new Response(
            '<html><body><pre>'.$out.'</pre></body></html>'
        );
    }
}