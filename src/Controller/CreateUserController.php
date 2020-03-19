<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateUserController extends AbstractController
{
    public function create_user(Request $request)
    {
        if (!$request->request->get('email') or $request->request->get('email') == NULL) {
            return $response = new JsonResponse(
                [
                    'error' =>
                        [
                            'Email not found'
                        ]
                ]);
        }

        if (!$request->request->get('password') or $request->request->get('password') == NULL) {
            return $response = new JsonResponse(
                [
                    'error' =>
                        [
                            'password not found'
                        ]
                ]);
        }

        $em = $this->getDoctrine()->getManager();
        $user = new User();

        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $checkUser = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($checkUser){
            return new JsonResponse(['error' => 'такой пользователь уже есть']);
        }

        $user->setEmail($email);
        $user->setPassword($password);
        $em->persist($user);
        $em->flush();


        return $response = new JsonResponse(
            [
                'user' =>
                    [
                        'email' => $email,
                    ]
            ]);
    }
}