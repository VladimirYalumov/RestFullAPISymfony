<?php


namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Episode;
use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class FilmController extends AbstractController
{
    public function getFilm($id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);

        if($film){
            $episodes = $this->getDoctrine()->getRepository(Episode::class)->findBy(['film_id' => $id]);

            $jsonContent = $serializer->serialize($episodes, 'json');
            return $response = new JsonResponse([
                'film' => $film->getName(),
                '$episode' => $jsonContent
            ]);

        } else {
            return $response = new JsonResponse(['message' => 'такого сериала нет']);
        }
    }

    public function getEpisode($id){
        $episode = $this->getDoctrine()->getRepository(Episode::class)->findOneBy(['id' => $id]);


        if($episode){
            return $response = new JsonResponse([
                'name' => $episode->getName(),
                'number' => $episode->getNumber()
            ]);

        } else {
            return $response = new JsonResponse(['message' => 'такой серии нет нет']);
        }
    }

    public function addEpisode(Request $request, $id){
        $token = $request->headers->get('token');
        if (!$token){
            return $response = new JsonResponse(
                [
                    'Необходимо авторизироваться'
                ]);
        };

        $film = $this->getDoctrine()->getRepository(Film::class)->findOneBy(['id' => $id]);

        if($film){
            $episode = new Episode();

            $number = $request->request->get('number');
            $name = $request->request->get('name');

            $episodeCheck = $this->getDoctrine()->getRepository(Episode::class)->findOneBy(['number' => $number]);

            if($episodeCheck){
                return $response = new JsonResponse(['message' => 'такая серия уже есть']);
            }

            $em = $this->getDoctrine()->getManager();

            $episode->setName($name);
            $episode->setNumber($number);
            $episode->setFilmId($id);

            $em->persist($episode);
            $em->flush();

            return $response = new JsonResponse(['message' => 'OK']);
        } else {
            return $response = new JsonResponse(['message' => 'такого сериала нет']);
        }

    }

    public function getTop(){
        $top = $this->getDoctrine()->getRepository(Film::class)->getTop();

        return $response = new JsonResponse(['message' => json_encode($top)]);
    }
}