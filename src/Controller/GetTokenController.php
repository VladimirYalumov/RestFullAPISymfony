<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetTokenController extends AbstractController
{
    public function get_token(Request $request)
    {

        if (!$request->request->get('email')) {
            return $response = new JsonResponse(
                [
                    'error' =>
                        [
                            'Email not found'
                        ]
                ]);
        }

        if (!$request->request->get('password')) {
            return $response = new JsonResponse(
                [
                    'error' =>
                        [
                            'password not found'
                        ]
                ]);
        }


        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user) {
            if ($user->getEmail() != $email and $user->getPassword() != $password) {
                return new JsonResponse(['error' => 'Неверный пароль']);
            }
        } else {
            return new JsonResponse(['error' => 'Пользователь не найден']);
        }

        $token = 'sdfnvkjsndfiv87sdfib34lfqwsdjkbfvjsdfbvlsnd';
        return $response = new JsonResponse(
            [
                'user' =>
                    [
                        'email' => $email,
                        'id' => $user->getId(),
                        'token' => $token,
                    ]
            ]
        );
    }
}