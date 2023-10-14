<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Shorten;
use Symfony\Component\String\ByteString;

#[Route('/api', name: 'api_')]
class ShortenController extends AbstractController
{
    #[Route(path: '/shorten', name: 'shorten_url', methods: ['POST'])]
    public function shorten(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $sourceUrl = $request->request->get('source_url');
        $hashedUrl = ByteString::fromRandom(8)->toString();;

        $shorter = new Shorten();
        $shorter->setSourceUrl($sourceUrl);
        $shorter->setHashedUrl($hashedUrl);

        $entityManager->persist($shorter);
        $entityManager->flush();

        return new JsonResponse([
            'Original Url is: ' => $sourceUrl,
            'The short URL is: ' => $hashedUrl,
            ]);
    }

    #[Route(path: '/revert', name: 'revert_url', methods: ['POST'])]
    public function revert(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        return new JsonResponse(['Your restored URL: ']);
    }

    #[Route(path: '/list', name: 'list_urls', methods: ['GET'])]
    public function listUrls(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        return new JsonResponse(['All URLs: ']);
    }
}
