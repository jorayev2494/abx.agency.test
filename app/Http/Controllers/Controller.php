<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "Azb agency test", title: "Documentation of Azb agency test"),
    OA\Server(url: 'http://localhost:8011', description: "Local server"),
    OA\Server(url: 'http://31.131.17.136:8011', description: "Staging server"),
    OA\SecurityScheme(securityScheme: 'bearerAuth', type: "http", name: "Authorization", in: "header", scheme: "bearer"),
]
abstract class Controller
{
    //
}
