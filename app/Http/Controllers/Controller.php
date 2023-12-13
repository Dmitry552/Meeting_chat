<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Meeting_Chat API",
 *     description="Application for free communication",
 *     version="0.0.1"
 * ),
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Application for free communication",
 * ),
 * @OA\Tag(
 *     name="Users",
 *     description="Endpoints for users"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         type="http",
 *         scheme="bearer",
 *         securityScheme="bearerAuth"
 *     )
 * )
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
