<?php

namespace App\Http\Controllers\SwaggerDocs;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *   path="/videoChat/join/{roomName}/{interlocutorCode}",
 *   summary="Join the room",
 *   description="Notice of the entrance to the room",
 *   tags={"VideoChat"},
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
 *      response=200,
 *      description="",
 *   ),
 * ),
 * @OA\Get(
 *   path="/videoChat/leave/{roomName}/{interlocutorCode}",
 *   summary="Leave the room",
 *   description="Notification to leave the room",
 *   tags={"VideoChat"},
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
 *      response=200,
 *      description="",
 *   ),
 * ),
 * @OA\Post(
 *   path="/videoChat/relayIce/{roomName}/{interlocutorCode}",
 *   summary="Transfer ice candidate",
 *   description="Transfer ice candidate",
 *   tags={"VideoChat"},
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
 *           property="iceCandidate",
 *           type="string"
 *         ),
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="",
 *   ),
 * ),
 * @OA\Post(
 *   path="/videoChat/relaySdp/{roomName}/{interlocutorCode}",
 *   summary="SDP data transfer",
 *   description="SDP data transfer (streams, media data)",
 *   tags={"VideoChat"},
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
 *           property="sessionDescription",
 *           type="string"
 *         ),
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="",
 *   ),
 * ),
 * @OA\Post(
 *   path="/videoChat/mute/{roomName}/{interlocutorCode}",
 *   summary="Notify muting",
 *   description="Notify when audio or video is muted",
 *   tags={"VideoChat"},
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
 *         oneOf={
 *           @OA\Schema(
 *             @OA\Property(
 *               property="value",
 *               type="boolean"
 *             ),
 *             @OA\Property(
 *               property="key",
 *               type="string"
 *             ),
 *             example={
 *               "value": true,
 *               "key": "audio"
 *             }
 *           ),
 *           @OA\Schema(
 *             @OA\Property(
 *               property="value",
 *               type="boolean"
 *             ),
 *             @OA\Property(
 *               property="key",
 *               type="string"
 *             ),
 *             example={
 *               "value": false,
 *               "key": "video"
 *             }
 *           ),
 *         },
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *      response=200,
 *      description="",
 *   ),
 * ),
 */
class VideoChatController extends Controller
{
}