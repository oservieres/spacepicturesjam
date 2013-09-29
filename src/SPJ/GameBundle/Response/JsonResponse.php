<?php

namespace SPJ\GameBundle\Response;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends Response
{
    public function __construct($data = null, $code = 200, $message = null) {
        parent::__construct(json_encode(array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        )));
        $this->headers->set('Content-Type', 'application/json');
    }
}
