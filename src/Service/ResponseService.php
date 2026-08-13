<?php

namespace App\Service;

use App\Resource\Pagination\Page;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseService
{
    public function __construct(
        protected SerializerInterface $serializer,
    ) {
    }
    public function returnList($items, int $count, Page $page, int $code = 200, array $groups = []): JsonResponse
    {
        $response = [
            '_embedded' => [
                'items' => $items,
            ],
            'total' => $count,
            'page' => $page->getPage(),
            'limit' => $page->getLimit(),
            'pages' => $page->getPages($count),
        ];
        $json = $this->serializer->serialize($response, 'json', $groups);

        return new JsonResponse($json, $code, [], true);
    }
}
