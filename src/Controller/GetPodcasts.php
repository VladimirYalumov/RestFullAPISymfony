<?php


namespace App\Controller;

use App\Entity\Podcast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class GetPodcasts extends AbstractController
{
    public function index()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $podcasts = $this->getDoctrine()->getRepository(Podcast::class)->findAll();
        $result = array();
        foreach ($podcasts as $obj){
            $catname = $obj->getCategory()->getName();
            $result[$catname][] = [
                'id' => $obj->getId(),
                'name' => $obj->getName(),
                ];
        }

        $jsonContent = $serializer->serialize($result, 'json');


        return  JsonResponse::fromJsonString($jsonContent);

    }
}