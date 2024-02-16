<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *   path="/room/{roomName}",
 *   summary="Show room",
 *   description="Show room",
 *   tags={"Rooms"},
 *   @OA\Parameter(
 *     name="roomName",
 *     description="Room name",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetRoom"),
 *     )
 *   ),
 * ),
 * @OA\Get(
 *   path="/room/check/{name}",
 *   summary="Show room",
 *   description="Show room",
 *   tags={"Rooms"},
 *   @OA\Parameter(
 *     name="name",
 *     description="Room name",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="text/html",
 *       @OA\Schema(
 *         oneOf={
 *           @OA\Schema(
 *             type="string",
 *             example="1"
 *           ),
 *           @OA\Schema(
 *             type="string",
 *             example="0"
 *           ),
 *         },
 *       ),
 *     )
 *   ),
 * ),
 * @OA\Get(
 *   path="/interlocutors/{roomName}",
 *   summary="Displays room interlocutors",
 *   description="Displays room interlocutors",
 *   tags={"Rooms"},
 *   @OA\Parameter(
 *     name="name",
 *     description="Room name",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="Ok",
 *      @OA\MediaType(
 *        mediaType="application/json",
 *        @OA\Schema(ref="#/components/schemas/Response_room_interlocutors"),
 *      ),
 *   ),
 * ),
 * @OA\Get(
 *   path="/join/{roomName}/{interlocutorCode}",
 *   summary="Join the room",
 *   description="Join the room",
 *   tags={"Rooms"},
 *   @OA\Parameter(
 *     name="roomName",
 *     description="Room name",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *    @OA\Parameter(
 *     name="interlocutorCode",
 *     description="Interlocutor code",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *   @OA\Response(
 *      response=204,
 *      description="No content"
 *   ),
 * ),
 * @OA\Post(
 *   path="/room/{interlocutorCode}",
 *   summary="Adds a new room",
 *   description="Adds a new room",
 *   tags={"Rooms"},
 *   @OA\Parameter(
 *     name="interlocutorCode",
 *     description="Interlocutor code",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="string"
 *     ),
 *   ),
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="name",
 *           description="Room name",
 *           type="string"
 *         ),
 *         example={
 *           "name": "dd39ff46-62c7-362b-959c-0cef01be272d",
 *         },
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=204,
 *     description="No content",
 *   ),
 * ),
 *
 *
 *
 * @OA\Schema(
 *   schema="GetRoom",
 *   @OA\Property(
 *     property="id",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="creator",
 *     type="integer"
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="updated_at",
 *     type="string"
 *   ),
 *   example={
 *     "id": 1,
 *     "name": "23984y-uioe897-829347g-34879gb23",
 *     "creator": 2,
 *     "created_at": "2023-11-06T15:34:03.000000Z",
 *     "updated_at": "2023-11-06T15:34:03.000000Z"
 *   },
 * ),
 * @OA\Schema(
 *     schema="Response_room_interlocutors",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/GetInterlocutor"),
 * )
 */
class RoomController extends Controller
{
}