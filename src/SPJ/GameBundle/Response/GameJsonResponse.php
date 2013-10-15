<?php

namespace SPJ\GameBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class GameJsonResponse extends JsonResponse
{
    public function __construct($data = null, $code = 200, $message = null)
    {
        parent::__construct(array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        ));
    }
}
