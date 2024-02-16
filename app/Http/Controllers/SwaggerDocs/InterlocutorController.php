<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *   path="/interlocutor/{interlocutorCode}",
 *   summary="Show interlocutor",
 *   description="Show interlocutor",
 *   operationId="interlocutor",
 *   tags={"Interlocutors"},
 *   security={{ "bearerAuth": {} }},
 *   @OA\Parameter(
 *     name="interlocutorCode",
 *     description="Interlocutor code",
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
 *       @OA\Schema(ref="#/components/schemas/GetInterlocutor"),
 *     )
 *   ),
 * ),
 * @OA\Get(
 *   path="/interlocutor",
 *   summary="Displays interlocutors",
 *   description="Displays interlocutors - with oneOf examples",
 *   operationId="displays_interlocutors",
 *   tags={"Interlocutors"},
 *   security={{ "bearerAuth": {} }},
 *   @OA\Parameter(
 *     name="limit",
 *     in="query",
 *     description="A list of things.",
 *     required=false,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="Ok",
 *      @OA\MediaType(
 *        mediaType="application/json",
 *        @OA\Schema(ref="#/components/schemas/Response_index_interlocutors"),
 *      ),
 *   ),
 * ),
 * @OA\Delete(
 *   path="/interlocutor/{id}",
 *   summary="Destroy interlocutor",
 *   description="Destroy interlocutor",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Interlocutors"},
 *   @OA\Parameter(
 *     description="Parameter with mutliple examples",
 *     in="path",
 *     name="id",
 *     required=true,
 *     @OA\Schema(type="string"),
 *     @OA\Examples(example="int", value="1", summary="An int value.")
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetInterlocutor"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Not Found",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string"
 *         ),
 *         example={"message": "No query results for model [App\Models\Interlocutor] 20."}
 *       ),
 *     ),
 *   ),
 * ),
 *
 *
 *
 * @OA\Schema(
 *   schema="GetInterlocutor",
 *   @OA\Property(
 *     property="id",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="interlocutorName",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="code",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="user",
 *     oneOf={
 *       @OA\Schema(type="null"),
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     }
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
 *     "interlocutorName": "Test",
 *     "code": "23984y-uioe897-829347g-34879gb23",
 *     "user": "null",
 *     "created_at": "2023-11-06T15:34:03.000000Z",
 *     "updated_at": "2023-11-06T15:34:03.000000Z"
 *   },
 * ),
 * @OA\Schema(
 *   schema="Response_index_interlocutors",
 *   @OA\Property(
 *     property="data",
 *     type="array",
 *     @OA\Items(
 *       @OA\Property(
 *         property="id",
 *         type="integer"
 *       ),
 *       @OA\Property(
 *         property="interlocutorName",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="code",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="user",
 *         oneOf={
 *           @OA\Schema(type="null"),
 *           @OA\Schema(ref="#/components/schemas/GetUser"),
 *         }
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
 *   @OA\Property(
 *     property="links",
 *     type="object",
 *     allOf={
 *       @OA\Schema(
 *         @OA\Property(
 *           property="path",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="firstPageUrl",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="lastPageUrl",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="nextPageUrl",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="prevPageUrl",
 *           type="string",
 *         ),
 *       )
 *     }
 *   ),
 *   @OA\Property(
 *     property="meta",
 *     type="object",
 *     allOf={
 *       @OA\Schema(
 *         @OA\Property(
 *           property="currentPage",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="from",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="lastPage",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="perPage",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="to",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="total",
 *           type="integer",
 *         ),
 *         @OA\Property(
 *           property="count",
 *           type="integer",
 *         ),
 *       ),
 *     },
 *   ),
 *   example={"data": {
 *     {
 *       "id": 1,
 *       "interlocutorName": "Test",
 *       "code": "23984y-uioe897-829347g-34879gb23",
 *       "user": "null",
 *       "created_at": "2023-11-06T15:34:03.000000Z",
 *       "updated_at": "2023-11-06T15:34:03.000000Z"
 *     },
 *     {
 *       "id": 2,
 *       "interlocutorName": "Test",
 *       "code": "23984y-uioe897-829347g-34879gb23",
 *       "user": "null",
 *       "created_at": "2023-11-06T15:34:03.000000Z",
 *       "updated_at": "2023-11-06T15:34:03.000000Z"
 *     }
 *   },
 *     "links": {
 *        "path": "http://localhost:8000/api/interlocutor",
 *        "firstPageUrl": "http://localhost:8000/api/interlocutor?page=1",
 *        "lastPageUrl": "http://localhost:8000/api/interlocutor?page=2",
 *        "nextPageUrl": "http://localhost:8000/api/interlocutor?page=2",
 *        "prevPageUrl": null
 *     },
 *     "meta": {
 *       "currentPage": 1,
 *       "from": 1,
 *       "lastPage": 2,
 *       "perPage": 10,
 *       "to": 10,
 *       "total": 13,
 *       "count": 10
 *   }},
 * ),
 */
class InterlocutorController extends Controller
{
}