<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\MarsConverter;

class MarsConverterController extends AbstractController
{
    /**
     * @Route(
     *      "/mars-converter/{timeUTC}", 
     *      name="mars_converter", 
     *      methods={"GET","HEAD"},
     * )
     */
    public function marsTimeConverter(Request $request): JsonResponse
    {
        try {
            $timeUTC = $request->attributes->all()['timeUTC'];
            $timeUTC = new \DateTime($timeUTC, new \DateTimeZone('Z'));
            $marsConverter = new MarsConverter();
            $marsTime = $marsConverter->getMarsTime($timeUTC);
        } catch (Exception $e) {
            return $this->json($e->getMessage(), 406);
        }
        return $this->json($marsTime, 200);
    }
}
