<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    #[Route('/cv', name: 'app_cv')]
    // #[IsGranted('ROLE_CONTRIBUTOR')]
    public function index(): Response
    {
        return $this->render('cv/cv.html.twig', [
            'cv' => '',
        ]);
    }
}
