<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TestController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig');
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(): Response
    {

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_KEY']);

        $session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pln',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => 'b.lauks@mdevelopers.com',
            'metadata' => [
                'booking_id' => 123,
//                'user_email' => $user->getEmail(),
//                'user_uuid' => $user->getUuid(),
            ],
            'success_url' => $this->generateUrl('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
//        dd($session->metadata->toArray());

        return new JsonResponse([
             'id' => $session->id,
             'url' => $session->url
            ]);

//        return $this->redirect($session->url, Response::HTTP_SEE_OTHER);
    }

    #[Route('/success-url', name: 'app_payment_success')]
    public function successUrl(): Response
    {
        return $this->render('test/success.html.twig');
    }

    #[Route('/cancel-url', name: 'app_payment_cancel')]
    public function cancelUrl(): Response
    {
        return $this->render('test/cancel.html.twig');
    }
}
