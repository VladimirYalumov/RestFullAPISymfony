<?php


namespace App\Controller;

use App\Entity\Artist;
//use App\Controller\TokenAuthenticatedController;
use App\Entity\Episode;
use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MarkController extends AbstractController
{
    public function addMark(Request $request)
    {
        $token = $request->headers->get('token');
        if (!$token){
            return $response = new JsonResponse(
                [
                    'Необходимо авторизироваться'
                ]);
        };

        $user_id = $request->headers->get('id');

        $filmId = $request->request->get('film_id');
        $mark = $request->request->get('mark');

        $film = $this->getDoctrine()->getRepository(Film::class)->findOneBy(['id' => $filmId]);

        if($film){
            $film_id = $film->getId();
            $this->getDoctrine()->getRepository(Film::class)->setMark($mark, $film_id, $user_id);

            return $response = new JsonResponse(['message' => 'оценка добавлена']);

        } else {
            return $response = new JsonResponse(['message' => 'такого сериала нет']);
        }
    }
}