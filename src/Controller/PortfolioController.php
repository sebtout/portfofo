<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{

    #[Route('/portfolio', name: 'app_portfolio')]
    // #[IsGranted('ROLE_CONTRIBUTOR')]
    public function index(): Response
    {
        return $this->render('portfolio/portfolio.html.twig', [
            '' => '',
        ]);
    }

    // #[Route('/game', name: 'app_game')]
    // #[Route('/', name: 'app_home_game')]
    #[Route('/portfolio', name: 'app_portfolio')]
    public function show(projectRepository $projectRepository): Response
    {
        $project = $projectRepository->findAll();

        return $this->render('portfolio/newfolio.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectRepository $projectRepository): Response
    {
        $project = new Project();

        // Create the form, linked with $project
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectRepository->save($project, true);
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            return $this->redirectToRoute('app_portfolio', [], Response::HTTP_SEE_OTHER);
        }

        // Render the form (best practice)
        return $this->renderForm('portfolio/newfolio.html.twig', [
            'form' => $form,
        ]);
    }
}
