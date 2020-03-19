<?php


namespace App\Controller;

use App\Entity\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class GetChart extends AbstractController
{
    public function index()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $chart = $this->getDoctrine()->getRepository(Chart::class)->findAll();

        $chart = array('chart' => $chart);
        $jsonContent = $serializer->serialize($chart, 'json');
        return  JsonResponse::fromJsonString($jsonContent);

    }
}