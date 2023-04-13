<?php

namespace App\Controller;

use App\Entity\Fruit;

use App\Service\FruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/fruits', name: 'fruit_')]
class FruitController extends AbstractController
{
    private ?Request $request;

    public function __construct(
        public FruitService $fruitService,
        RequestStack        $requestStack
    )
    {
        $this->request = $requestStack->getMainRequest();
    }

    #[Route('/get_by_ids', name: 'get_by_ids')]
    public function getByIdsAction(): JsonResponse
    {
        $ids = $this->request->get('ids');
        $data = $this->fruitService->findByIds($ids);

        return $this->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    #[Route('/list', name: 'list')]
    public function listAction(): JsonResponse
    {
        $limit = (int)$this->request->get('count', 10);
        $page = (int)$this->request->get('page', -1);
        $offset = ($page - 1) * $limit;

        if ($page === -1) {
            $offset = null;
            $limit = null;
            $totalNumberOfPage = 1;
        } else {
            $countResult = $this->fruitService->countFruits();
            $totalNumberOfPage = (int)($countResult / $limit) < ($countResult / $limit) ? (int)($countResult / $limit) + 1 : (int)($countResult / $limit);
        }

        $fruits = $this->fruitService->findFruits($limit, $offset);

        return $this->json([
            'status' => 'success',
            'totalNumberOfPage' => $totalNumberOfPage,
            'data' => $fruits,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function searchAction(): JsonResponse
    {
        $name = $this->request->get('name');
        $family = $this->request->get('family');
        $limit = (int)$this->request->get('count', 10);
        $page = (int)$this->request->get('page', -1);
        $offset = ($page - 1) * $limit;

        if ($page === -1) {
            $offset = null;
            $limit = null;
            $totalNumberOfPage = 1;
        } else {
            $countResult = $this->fruitService->countFruits($name, $family);
            $totalNumberOfPage = (int)($countResult / $limit) < ($countResult / $limit) ? (int)($countResult / $limit) + 1 : (int)($countResult / $limit);
        }

        $fruits = $this->fruitService->filterFruit($name, $family, $limit, $offset);

        return $this->json([
            'status' => 'success',
            'totalNumberOfPage' => $totalNumberOfPage,
            'data' => $fruits,
        ]);
    }
}
