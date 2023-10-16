<?php

namespace App\Controller;

use App\Repository\ShortenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
//use App\Entity\Shorten;
//use Symfony\Component\String\ByteString;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class ShortenController extends AbstractController
{
    #[Route(path: '/shorten', name: 'shorten_url', methods: ['POST'])]
    public function shorten(Request $request, ShortenRepository $repository): JsonResponse
    {
        $host = $request->getHttpHost();
        $sourceUrl = $request->request->get('source_url');
        $response = $repository->shorten($sourceUrl, $host);
        return new JsonResponse($response);
    }

    #[Route(path: '/revert', name: 'revert_url', methods: ['POST'])]
    public function revert(Request $request, ShortenRepository $repository): JsonResponse
    {
        $host = $request->getHttpHost();
        $hashedUrl = $request->request->get('hashed_url');
        $response = $repository->revert($hashedUrl, $host);
        return new JsonResponse($response);
    }

}
