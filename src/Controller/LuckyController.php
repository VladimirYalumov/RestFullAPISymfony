<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController
{
    public function number($max)
    {
        $number = [];
        $number[] = random_int(0, $max);
        $number[] = random_int(0, $max);
        $number[] = random_int(0, $max);

        return $response = new JsonResponse(['number' => $number]);
    }
}