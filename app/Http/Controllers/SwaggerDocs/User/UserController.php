<?php

namespace App\Http\Controllers\SwaggerDocs\User;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *   path="/login",
 *   summary="Adds a new user - with oneOf examples",
 *   description="Adds a new user",
 *   operationId="loginUser",
 *   tags={"Users"},
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string"
 *         ),
 *         @OA\Property(
 *           property="remember_me",
 *           type="boolean"
 *         ),
 *         example={
 *           "email": "12345@gmail.com",
 *           "password": "12jhb345THjj678",
 *           "remember_me": false
 *         }
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Response_access_token"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=422,
 *     description="Unprocessable Content",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="errors",
 *           type="object",
 *           oneOf={
 *             @OA\Schema(
 *               @OA\Property(
 *                 property="password",
 *                 type="string",
 *               ),
 *               @OA\Property(
 *                 property="email",
 *                 type="string",
 *               ),
 *             ),
 *             @OA\Schema(
 *               @OA\Property(
 *                 property="password",
 *                 type="string",
 *               ),
 *             ),
 *             @OA\Schema(
 *               @OA\Property(
 *                 property="email",
 *                 type="string",
 *               ),
 *             ),
 *           },
 *         ),
 *         example={
 *           "message": "The password field is required.",
 *           "errors": {
 *             "password": {"The password field is required."}
 *           },
 *         },
 *       ),
 *     ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/registration",
 *   summary="Adds a new user",
 *   description="Adds a new user",
 *   operationId="registerUser",
 *   tags={"Users"},
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="name",
 *           type="string"
 *         ),
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string"
 *         ),
 *         @OA\Property(
 *           property="password_confirmation",
 *           type="string"
 *         ),
 *         example={
 *           "name": "BlaBlaBlaName",
 *           "email": "12345@gmail.com",
 *           "password": "12jhb345THjj678",
 *           "password_confirmation": "12jhb345THjj678"
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
 *         @OA\Property(
 *           property="data",
 *           type="object",
 *           allOf={
 *             @OA\Schema(
 *               @OA\Property(
 *                 property="access_token",
 *                 type="string"
 *               ),
 *               @OA\Property(
 *                 property="token_type",
 *                 type="string"
 *               ),
 *               @OA\Property(
 *                 property="expires_in",
 *                 type="integer"
 *               ),
 *               example={
 *                 "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk5NDM0NjI3LCJleHAiOjE2OTk0MzgyMjcsIm5iZiI6MTY5OTQzNDYyNywianRpIjoiaHNzeHVDZmJTUUd3QU85eCIsInN1YiI6IjExIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.V7B_I7bCT57x1kOV_1u9eQxscWAwAqW3Ae9oRvY62LM",
 *                 "token_type": "bearer",
 *                 "expires_in": 3600,
 *               }
 *             ),
 *           },
 *         ),
 *         @OA\Property(
 *           property="message",
 *           type="string"
 *         ),
 *         example={
 *           "data": {
 *             "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk5NDM0NjI3LCJleHAiOjE2OTk0MzgyMjcsIm5iZiI6MTY5OTQzNDYyNywianRpIjoiaHNzeHVDZmJTUUd3QU85eCIsInN1YiI6IjExIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.V7B_I7bCT57x1kOV_1u9eQxscWAwAqW3Ae9oRvY62LM",
 *             "token_type": "bearer",
 *             "expires_in": 3600,
 *           },
 *           "message": "You have been sent a confirmation email!"
 *         },
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=422,
 *     description="Unprocessable Content",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string",
 *         ),
 *         @OA\Property(
 *           property="errors",
 *           type="object",
 *           allOf={
 *           @OA\Schema(
 *               @OA\Property(
 *                 property="name",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *               ),
 *               @OA\Property(
 *                 property="email",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *               ),
 *               @OA\Property(
 *                 property="password",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *               ),
 *               @OA\Property(
 *                 property="password_confirmation",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *               ),
 *           ),
 *           },
 *         ),
 *         example={
 *           "message": "The name field is required. (and 2 more errors)",
 *           "errors": {
 *             "name": {"The name field is required."},
 *             "email": {"The email field is required."},
 *             "password": {"The password field is required."}
 *           },
 *         },
 *       ),
 *     ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/socialUserData",
 *   summary="Adds a new social user",
 *   description="Adds a new user via social networks",
 *   tags={"Users"},
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(oneOf={
 *         @OA\Schema(
 *           @OA\Property(
 *             property="provider",
 *             type="string"
 *           ),
 *           @OA\Property(
 *             property="token",
 *             type="string",
 *           ),
 *           example={
 *             "provider": "Google",
 *             "token": "b9348gf93784fb938b4f8932bf8b2348fb23804fb0382b4f3f"
 *           },
 *         ),
 *         @OA\Schema(
 *           @OA\Property(
 *             property="provider",
 *             type="string"
 *           ),
 *           @OA\Property(
 *             property="code",
 *             type="string"
 *           ),
 *           example={
 *             "provider": "Facebook",
 *             "code": "12jhb345THjj678"
 *           },
 *         ),
 *       }),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Response_access_token"),
 *     ),
 *   ),
 * ),
 * @OA\Get(
 *   path="/user",
 *   summary="Displays users - with oneOf examples",
 *   description="Displays users",
 *   operationId="indexUser",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
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
 *        @OA\Schema(ref="#/components/schemas/Response_index_users"),
 *      ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 * ),
 * @OA\Get(
 *  path="/user/me",
 *  summary="Show current user",
 *  description="Show current user",
 *  operationId="MeUser",
 *  security={{ "bearerAuth": {} }},
 *  tags={"Users"},
 *  @OA\Response(
 *   response=200,
 *   description="Ok",
 *   @OA\MediaType(
 *    mediaType="application/json",
 *    @OA\Schema(ref="#/components/schemas/GetUser"),
 *   ),
 *  ),
 *  @OA\Response(
 *    response=401,
 *    description="Unauthenticated",
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 * ),
 * @OA\Get(
 *   path="/user/{id}",
 *   summary="Display user",
 *   description="Display user",
 *   operationId="User",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     description="",
 *     in = "path",
 *     required=true,
 *     @OA\Schema(
 *       type="integer"
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/user/logout",
 *   summary="User logout",
 *   description="User logout",
 *   operationId="logoutUser",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string",
 *         ),
 *         example={
 *           "message": "Successfully logged out"
 *         }
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/user/refresh",
 *   summary="Token reset",
 *   description="Token reset",
 *   operationId="refreshToken",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Response_access_token"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 * ),
 * @OA\Post(
 *   path="/user/password/{id}",
 *   summary="Password change",
 *   description="Password change",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     description="user id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *       type="integer"
 *     ),
 *   ),
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="oldPassword",
 *           type="string"
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *         ),
 *         example={
 *           "oldPassword": "12345678",
 *           "password": "12345678qwerty"
 *         }
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=204,
 *     description="No content",
 *   ),
 * ),
 * @OA\Post(
 *   path="/user/avatar",
 *   summary="Upload avatar",
 *   description="Upload an avatar for the user",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="multipart/form-data",
 *       @OA\Schema(
 *         type="object",
 *         @OA\Property(
 *           property="avatar",
 *           type="string",
 *           format="binary",
 *         ),
 *         example={
 *           "avatar": "111.png"
 *         }
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=400,
 *     description="Bad request",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string"
 *         ),
 *         example={"message": "Error update user"}
 *       ),
 *     ),
 *   ),
 * ),
 * @OA\Put(
 *   path="/user/{id}",
 *   summary="Update user",
 *   description="Update user",
 *   operationId="UpdateUser",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Parameter(
 *     description="Parameter with mutliple examples",
 *     in="path",
 *     name="id",
 *     required=true,
 *     @OA\Schema(type="string"),
 *     @OA\Examples(example="int", value="1", summary="An int value.")
 *   ),
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="name",
 *           type="string"
 *         ),
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *         ),
 *         example={
 *           "name": "BlaBlaBlaName",
 *           "email": "12345@gmail.com"
 *         }
 *       ),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
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
 *         example={"message": "No query results for model [App\Models\User] 20."}
 *       ),
 *     ),
 *   ),
 * ),
 * @OA\Delete(
 *   path="/user/{id}",
 *   summary="Destroy user",
 *   description="Destroy user",
 *   operationId="DestroyUser",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
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
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
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
 *         example={"message": "No query results for model [App\Models\User] 20."}
 *       ),
 *     ),
 *   ),
 * ),
 * @OA\Delete(
 *   path="/user/avatar",
 *   summary="Destroy user avatar",
 *   description="Destroy user avatar",
 *   security={{ "bearerAuth": {} }},
 *   tags={"Users"},
 *   @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/GetUser"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(ref="#/components/schemas/Unauthenticated"),
 *     ),
 *   ),
 *   @OA\Response(
 *     response=400,
 *     description="Bad request",
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="message",
 *           type="string"
 *         ),
 *         example={"message": "Error update user"}
 *       ),
 *     ),
 *   ),
 * ),
 *
 *
 *
 *
 *
 * @OA\Schema(
 *   schema="Response_access_token",
 *   @OA\Property(
 *     property="access_token",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="token_type",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="expires_in",
 *     type="integer"
 *   ),
 *   example={
 *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk5NDM0NjI3LCJleHAiOjE2OTk0MzgyMjcsIm5iZiI6MTY5OTQzNDYyNywianRpIjoiaHNzeHVDZmJTUUd3QU85eCIsInN1YiI6IjExIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.V7B_I7bCT57x1kOV_1u9eQxscWAwAqW3Ae9oRvY62LM",
 *     "token_type": "bearer",
 *     "expires_in": 3600,
 *   }
 * ),
 * @OA\Schema(
 *   schema="Response_index_users",
 *   @OA\Property(
 *     property="data",
 *     type="array",
 *     @OA\Items(
 *       @OA\Property(
 *         property="id",
 *         type="integer"
 *       ),
 *       @OA\Property(
 *         property="firstName",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="lastName",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="gender",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="phone",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="currentAddress",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="permanantAddress",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="email",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="birthdey",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="email_verified",
 *         type="string"
 *       ),
 *       @OA\Property(
 *         property="avatarPath",
 *         type="string"
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
 *       {
 *         "id": 1,
 *         "firstName": "Test",
 *         "lastName": "User",
 *         "gender": "Female",
 *         "phone": "+380501234567",
 *         "currentAddress": "Beech Creek, PA, Pennsylvania",
 *         "permanantAddress": "Arlington Heights, IL, Illinois",
 *         "email": "12345@gmail.com",
 *         "birthday": "1975-05-21",
 *         "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *         "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *         "email_verified": false,
 *         "created_at": "2023-11-06T15:34:03.000000Z",
 *         "updated_at": "2023-11-06T15:34:03.000000Z"
 *       },
 *       {
 *         "id": 2,
 *         "firstName": "Test2",
 *         "lastName": "User2",
 *         "gender": "Female2",
 *         "phone": "+380501234567",
 *         "currentAddress": "Beech Creek, PA, Pennsylvania",
 *         "permanantAddress": "Arlington Heights, IL, Illinois",
 *         "email": "12345222@gmail.com",
 *         "birthday": "1975-05-21",
 *         "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *         "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *         "email_verified": false,
 *         "created_at": "2023-11-06T15:34:03.000000Z",
 *         "updated_at": "2023-11-06T15:34:03.000000Z"
 *       }
 *     },
 *     "links": {
 *        "path": "http://localhost:8000/api/user",
 *        "firstPageUrl": "http://localhost:8000/api/user?page=1",
 *        "lastPageUrl": "http://localhost:8000/api/user?page=2",
 *        "nextPageUrl": "http://localhost:8000/api/user?page=2",
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
 * @OA\Schema(
 *   schema="Unauthenticated",
 *   @OA\Property(
 *     property="message",
 *     type="string"
 *   ),
 *   example={"message": "Unauthenticated."}
 * ),
 * @OA\Schema(
 *   schema="GetUser",
 *   @OA\Property(
 *    property="id",
 *    type="integer"
 *   ),
 *   @OA\Property(
 *     property="firstName",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="lastName",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="gender",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="phone",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="currentAddress",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="permanantAddress",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="birthdey",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="email_verified",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="avatarPath",
 *     type="string"
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
 *     "firstName": "Test",
 *     "lastName": "User",
 *     "gender": "Female",
 *     "phone": "+380501234567",
 *     "currentAddress": "Beech Creek, PA, Pennsylvania",
 *     "permanantAddress": "Arlington Heights, IL, Illinois",
 *     "email": "12345@gmail.com",
 *     "birthday": "1975-05-21",
 *     "email_verified_at": "2023-11-06T15:34:03.000000Z",
 *     "avatarPath": "avatar/127486g-2397y4-28397-2387h4.png",
 *     "email_verified": false,
 *     "created_at": "2023-11-06T15:34:03.000000Z",
 *     "updated_at": "2023-11-06T15:34:03.000000Z"
 *   }
 * ),
 */
class UserController extends Controller
{
}
