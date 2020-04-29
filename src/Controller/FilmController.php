<?php


namespace App\Controller;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class GetFilmController extends AbstractController
{
    public function get_film($id)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $artist = $this->getDoctrine()->getRepository(Artist::class)->find($id);

        $artist_name = $artist->getName();
        $playlist = [
            1 => ['id' => 1, 'artist' => $artist_name, 'name' => 'Пачка сигарет'],
            2 => ['id' => 2, 'artist' => $artist_name, 'name' => 'Звезда по имени солнце'],
            3 => ['id' => 3, 'artist' => $artist_name, 'name' => 'Хочу перемен'],
            4 => ['id' => 4, 'artist' => $artist_name, 'name' => 'Группа крови'],
            5 => ['id' => 5, 'artist' => $artist_name, 'name' => 'Кукушка'],

        ];

        $result = array('artist' => $artist, 'playlist' => $playlist);
        $jsonContent = $serializer->serialize($result, 'json');
        return  JsonResponse::fromJsonString($jsonContent);
    }
}