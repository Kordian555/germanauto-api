<?php

namespace App\Controller;

use App\Entity\CarBrand;
use App\Entity\CarGeneration;
use App\Entity\CarModel;
use App\Entity\User;
use App\Exception\AlreadyExistsException;
use App\Exception\BadRequestException;
use App\Exception\ItemNotFoundException;
use App\Service\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/car')]
#[IsGranted(User::ROLE_ADMIN)]
class CarAdminController extends AbstractController
{

    #[Route('/brand', methods: ['POST'])]
    public function add(
        Request $request,
        EntityManagerInterface $em,
    )
    {
        $c = json_decode($request->getContent(), true);
        if (!$c || !isset($c['name'])) {
            throw new BadRequestException('Data missing');
        }

        $existing = $em->getRepository(CarBrand::class)->findOneBy(['name' => $c['name']]);
        if ($existing) {
            throw new ItemNotFoundException('Brand already exists');
        }

        $cb = new CarBrand();
        $cb
            ->setName($c['name'])
            ->setScore($c['score'] ?? [])
            ->setIndexStatus(0)
        ;
        $em->persist($cb);
        $em->flush();

        return $this->json(['data' => $cb]);
    }

    #[Route('/{id}/model', methods: ['POST'])]
    public function addModel(
        int $id,
        Request $request,
        EntityManagerInterface $em,
    )
    {
        $brand = $em->getRepository(CarBrand::class)->find($id);
        if (!$brand) {
            throw new ItemNotFoundException('Invalid brand');
        }
        $c = json_decode($request->getContent(), true);
        if (!$c || !isset($c['name'])) {
            throw new BadRequestException('Data missing');
        }

        $existing = $em->getRepository(CarModel::class)->findOneBy(['name' => $c['name']]);
        if ($existing) {
            throw new AlreadyExistsException('Model already exists');
        }

        $cm = new CarModel();
        $cm
            ->setCarbrand($brand)
            ->setName($c['name'])
        ;
        $em->persist($cm);
        $em->flush();


        return $this->json(['data' => $cm], 200, [], ['groups' => ['read']]);
    }

    #[Route('/{modelId}/generation', methods: ['POST'])]
    public function addGeneration(
        int $modelId,
        Request $request,
        EntityManagerInterface $em
    )
    {
        $model = $em->getRepository(CarModel::class)->find($modelId);
        if (!$model) {
            throw new ItemNotFoundException('Invalid model');
        }
        $c = json_decode($request->getContent(), true);
        if (!$c || !isset($c['name'])) {
            throw new BadRequestException('Data missing');
        }

        $existing = $em->getRepository(CarGeneration::class)->findOneBy(['name' => $c['name']]);
        if ($existing) {
            throw new AlreadyExistsException('Generation already exists');
        }

        $cg = new CarGeneration();
        $cg
            ->setName($c['name'])
            ->setCarmodel($model)
            ->setProductionStart($c['productionStart'] ?? 0)
            ->setProductionEnd($c['productionEnd'] ?? 0)
        ;
        $em->persist($cg);
        $em->flush();

        return $this->json(['data' => $cg], 200, [], ['groups' => ['read']]);
    }
}
