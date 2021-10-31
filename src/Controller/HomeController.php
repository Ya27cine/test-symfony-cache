<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Stopwatch $stopwatch,CacheInterface $cahce): Response
    {
        $stopwatch->start('calcul-long');

        // On imagine un calcul ou un traitement long
        $resultatCalcul = $cahce->get('result-cache', function(ItemInterface $item){ 
                    $item->expiresAfter(15);
                    return $this->fonctionQuiPrendDuTemps(); 
                }
        );

        $stopwatch->stop('calcul-long');

        return $this->render('base.html.twig',[
            'data' => $resultatCalcul
        ]);
    }


    private function fonctionQuiPrendDuTemps(): int
    {
       sleep(4);

        return 10;
    }
}
