<?php

namespace App\Controller;

use App\Entity\CarBrand;
use App\Entity\CarModel;
use App\Exception\BadRequestException;
use App\Exception\ItemNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/car')]
class CarBrandController extends AbstractController
{
    #[Route('/brand', methods: ['GET'])]
    public function getBrand(
        EntityManagerInterface $em
    )
    {
        $brands = $em->getRepository(CarBrand::class)->findBy(['active' => 1]);

        return $this->json(['data' => $brands], 200, [], ['groups' => ['read']]);
    }

    #[Route('/{brandId}/model', methods: ['GET'])]
    public function getModel(
        int $brandId,
        EntityManagerInterface $em
    )
    {
        $brand = $em->getRepository(CarBrand::class)->findOneBy(['id' => $brandId, 'active' => 1]);
        if (!$brand) {
            throw new ItemNotFoundException('Not found or inactive brand');
        }

        return $this->json(['data' => $brand->getCarModels()], 200 , [], ['groups' => ['read']]);
    }

    #[Route('/{modelId}/generation')]
    public function getGeneration(
        int $modelId,
        EntityManagerInterface $em
    )
    {
        $model = $em->getRepository(CarModel::class)->find($modelId);
        if (!$model) {
            throw new ItemNotFoundException('Model not found');
        }
        if (!$model->getCarbrand()->isActive()) {
            throw new BadRequestException('Car brand of this model generation is inactive');
        }

        return $this->json(['data' => $model->getCarGenerations()], 200, [], ['groups' => ['read']]);
    }
}
