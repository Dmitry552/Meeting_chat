<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *   path="/room/roomsBetweenDates",
 *   summary="Get rooms by dates",
 *   description="Get rooms between dates",
 *   tags={"SystemRooms"},
 *   security={{ "bearerAuth": {} }},
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         oneOf={
 *           @OA\Schema(
 *             @OA\Property(
 *               property="startDate",
 *               type="string"
 *             ),
 *             @OA\Property(
 *               property="endDate",
 *               type="string"
 *             ),
 *             example={
 *               "startDate": "2023-04-02",
 *               "endDate": "2023-05-02"
 *             }
 *           ),
 *           @OA\Schema(
 *             @OA\Property(
 *               property="startDate",
 *               type="string"
 *             ),
 *             example={
 *               "startDate": "2023-04-02",
 *             }
 *           ),
 *           @OA\Schema(
 *             @OA\Property(
 *               property="endDate",
 *               type="string"
 *             ),
 *             example={
 *               "endDate": "2023-05-02"
 *             }
 *           )
 *         },
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         type="array",
 *         @OA\Items(
 *           allOf={
 *             @OA\Schema(
 *               @OA\Property(
 *                 property="date",
 *                 type="string"
 *               ),
 *               @OA\Property(
 *                 property="countRoom",
 *                 type="integer"
 *               ),
 *             ),
 *           },
 *         ),
 *         example={
 *           {
 *             "date": "2023-02-03",
 *             "countRoom": 1
 *           },
 *           {
 *             "date": "2023-02-04",
 *             "countRoom": 4
 *           },
 *           {
 *             "date": "2023-02-05",
 *             "countRoom": 6
 *           },
 *           {
 *             "date": "2023-02-06",
 *             "countRoom": 2
 *           },
 *         },
 *       ),
 *     ),
 *   ),
 * ),
 */
class SystemRoomController extends Controller
{
}