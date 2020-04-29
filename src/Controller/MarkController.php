<?php


namespace App\Controller;

use App\Entity\Artist;
//use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddMarkController extends AbstractController
{
    public function add(Request $request)
    {
        $token = $request->headers->get('token');
        if (!$token){
            return $response = new JsonResponse(
                [
                    'Необходимо авторизироваться'
                ]);
        };

        $name = $request->request->get('name');

        $checkArtist = $this->getDoctrine()->getRepository(Artist::class)->findOneBy(['name' => $request->request->get('name')]);
        if ($checkArtist){
            return new JsonResponse(['error' => 'Такой исполнитель уже есть']);
        }

        $em = $this->getDoctrine()->getManager();
        $artist = new Artist();
        $artist->setName($request->request->get('name'));
        $em->persist($artist);
        $em->flush();

        return $response = new JsonResponse(
            [
                'artist' =>
                    [
                        'name' => $request->request->get('name'),
                    ]
            ]);
    }
}