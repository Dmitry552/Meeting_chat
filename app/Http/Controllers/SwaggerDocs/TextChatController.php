<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *   path="/textChat/{roomName}",
 *   summary="Displays interlocutors",
 *   description="Displays interlocutors - with oneOf examples",
 *   tags={"TextChat"},
 *   @OA\Parameter(
 *     name="limit",
 *     in="query",
 *     description="A list of things.",
 *     required=false,
 *     @OA\Schema(type="integer")
 *   ),
 *    @OA\Parameter(
 *     name="roomName",
 *     in="path",
 *     description="Room name",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="Ok",
 *      @OA\MediaType(
 *        mediaType="application/json",
 *        @OA\Schema(ref="#/components/schemas/Response_index_messages"),
 *      ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/textChat/message/{roomName}/{interlocutorCode}",
 *   summary="Create message",
 *   description="Create message",
 *   tags={"TextChat"},
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
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="content",
 *           type="string"
 *         ),
 *         example={
 *           "content": "Test text",
 *         },
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetMessage"),
 *     ),
 *   ),
 * ),
 * @OA\Delete(
 *   path="/textChat/{id}",
 *   summary="Destroy interlocutor",
 *   description="Destroy interlocutor",
 *   tags={"TextChat"},
 *   @OA\Parameter(
 *     description="Message id",
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="string"),
 *     @OA\Examples(example="int", value="1", summary="An int value.")
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetMessage"),
 *     ),
 *   ),
 * ),
 *
 *
 *
 * @OA\Schema(
 *   schema="GetMessage",
 *   @OA\Property(
 *     property="id",
 *     type="integer"
 *   ),
 *   @OA\Property(
 *     property="content",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="interlocutor",
 *     allOf={@OA\Schema(ref="#/components/schemas/GetInterlocutor")}
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
 *     "content": "Test text",
 *     "interlocutor": {
 *        "id": 1,
 *        "firstName": "Test",
 *        "lastName": "User",
 *        "gender": "Female",
 *        "phone": "+380501234567",
 *        "currentAddress": "Beech Creek, PA, Pennsylvania",
 *        "permanantAddress": "Arlington Heights, IL, Illinois",
 *        "email": "12345@gmail.com",
 *        "birthday": "1975-05-21",
 *        "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *        "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *        "email_verified": false,
 *        "created_at": "2023-11-06T15:34:03.000000Z",
 *        "updated_at": "2023-11-06T15:34:03.000000Z"
 *     },
 *     "created_at": "2023-11-06T15:34:03.000000Z",
 *     "updated_at": "2023-11-06T15:34:03.000000Z"
 *   },
 * ),
 * @OA\Schema(
 *   schema="Response_index_messages",
 *   @OA\Property(
 *     property="data",
 *     type="array",
 *     @OA\Items(
 *       @OA\Property(
 *         property="id",
 *         type="integer"
 *       ),
 *       @OA\Property(
 *         property="content",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="interlocutor",
 *         allOf={@OA\Schema(ref="#/components/schemas/GetInterlocutor")}
 *       ),
 *       @OA\Property(
 *         property="created_at",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="updated_at",
 *         type="string"
 *       )
 *     ),
 *   ),
 *   example={"data": {
 *     {
 *       "id": 1,
 *       "content": "Test text",
 *       "interlocutor": {
 *          "id": 1,
 *          "firstName": "Test",
 *          "lastName": "User",
 *          "gender": "Female",
 *          "phone": "+380501234567",
 *          "currentAddress": "Beech Creek, PA, Pennsylvania",
 *          "permanantAddress": "Arlington Heights, IL, Illinois",
 *          "email": "12345@gmail.com",
 *          "birthday": "1975-05-21",
 *          "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *          "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *          "email_verified": false,
 *          "created_at": "2023-11-06T15:34:03.000000Z",
 *          "updated_at": "2023-11-06T15:34:03.000000Z"
 *       },
 *       "created_at": "2023-11-06T15:34:03.000000Z",
 *       "updated_at": "2023-11-06T15:34:03.000000Z"
 *     },
 *     {
 *       "id": 2,
 *       "content": "Test text",
 *       "interlocutor": {
 *          "id": 1,
 *          "firstName": "Test",
 *          "lastName": "User",
 *          "gender": "Female",
 *          "phone": "+380501234567",
 *          "currentAddress": "Beech Creek, PA, Pennsylvania",
 *          "permanantAddress": "Arlington Heights, IL, Illinois",
 *          "email": "12345@gmail.com",
 *          "birthday": "1975-05-21",
 *          "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *          "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *          "email_verified": false,
 *          "created_at": "2023-11-06T15:34:03.000000Z",
 *          "updated_at": "2023-11-06T15:34:03.000000Z"
 *       },
 *       "created_at": "2023-11-06T15:34:03.000000Z",
 *       "updated_at": "2023-11-06T15:34:03.000000Z"
 *     }
 *   }},
 * ),
 */
class TextChatController extends Controller
{
}