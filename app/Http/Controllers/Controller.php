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
 * @OA\Tag(
 *     name="Interlocutors",
 *     description="Endpoints for interlocutors"
 * ),
 * @OA\Tag(
 *     name="Rooms",
 *     description="Endpoints for interacting with rooms"
 * ),
 * @OA\Tag(
 *     name="SystemRooms",
 *     description="Endpoints for admin interaction with rooms"
 * ),
 * @OA\Tag(
 *     name="VideoChat",
 *     description="Endpoints for video chat interaction"
 * ),
 * @OA\Tag(
 *     name="TextChat",
 *     description="Endpoints for text chat interaction"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         type="http",
 *         scheme="bearer",
 *         securityScheme="bearerAuth"
 *     )
 * ),
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
