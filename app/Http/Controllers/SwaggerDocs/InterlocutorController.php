<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\GET(
 *     path="interlocutor/{_interlocutor}",
 *     summary="Show interlocutor",
 *     description="Show interlocutor",
 *     operationId="interlocutro",
 *     tags={"Interlocutors"},
 *     @OA\Parameter(
 *         name="_interlocutor",
 *         description="Interlocutor code",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="id",
 *                     type="string"
 *                  ),
 *                  @OA\Property(
 *                     property="interlocutorName",
 *                     type="string"
 *                  ),
 *                  @OA\Property(
 *                     property="code",
 *                     type="string"
 *                  ),
 *                  @OA\Property(
 *                     property="user",
 *                     oneOf={
 *                         @OA\Schema(type="null"),
 *                         @OA\Schema(type="object"),
 *                     }
 *                  ),
 *                  @OA\Property(
 *                     property="created_at",
 *                     type="string"
 *                  ),
 *                  @OA\Property(
 *                     property="updated_at",
 *                     type="string"
 *                  ),
 *                  example={{
 *                     {
 *                         "id": 1,
 *                         "interlocutorName": "Test",
 *                         "code": "23984y-uioe897-829347g-34879gb23",
 *                         "user": "null",
 *                         "created_at": "2023-11-06T15:34:03.000000Z",
 *                         "updated_at": "2023-11-06T15:34:03.000000Z"
 *                     },
 *                  }},
 *              ),
 *         )
 *     ),
 * )
 */
class InterlocutorController extends Controller
{
}