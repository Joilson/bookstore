<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: 1, title: 'spassu')]
#[OA\SecurityScheme(securityScheme: 'BearerAuth', type: 'http', bearerFormat: 'JWT', scheme: 'bearer')]
abstract class Controller
{
    //
}
