<?php

namespace App\Controller;

use App\Service\FilterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/filter')]
class FilterController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function getFilters(
        FilterService $filterService,
    )
    {
        $filters = $filterService->getAll();
        return $this->json(['data' => $filters]);
    }
}
