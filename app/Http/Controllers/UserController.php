<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Validator;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/user",
     *      operationId="getUserList",
     *      tags={"User"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of users
     */
    public function index()
    {
        $result = User::all();

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "application/json; charset=utf-8");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/user",
     *      operationId="storeUser",
     *      tags={"User"},
     *      summary="Create new user",
     *      description="Creates a new user",
     *      @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="user name",
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="user email",
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="user password",
     *                     property="password",
     *                     type="integer",
     *                 ),
     *                 required={"name", "email", "password"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new user
     */
    public function store(UserUpdateRequest $request)
    {
        $data = $request->only(['name', 'email', 'password']);

        $data['password'] = bcrypt($data['password']);

        $result = User::create($data);

        $message = [
            'status' => '201',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 201)
            ->header('Content-Type', "application/json; charset=utf-8");

    }

    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      operationId="showUser",
     *      tags={"User"},
     *      summary="Shows specific user",
     *      description="Shows a specific user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Shows a specific user
     */
    public function show(User $user)
    {
        $result = $user;

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "application/json; charset=utf-8");


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }


    /**
     * @OA\Put(
     *      path="/user/{id}",
     *      operationId="updateUser",
     *      tags={"User"},
     *      summary="Updates a user",
     *      description="Updates a user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="user name",
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="user email",
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="user password",
     *                     property="password",
     *                     type="integer",
     *                 ),
     *                 required={"name", "email", "password"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Updates a user
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        $data = $request->only('name', 'email', 'password');

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        $result = $user;

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "application/json; charset=utf-8");


    }

    /**
     * @OA\Delete(
     *      path="/user/{id}",
     *      operationId="deleteUser",
     *      tags={"User"},
     *      summary="Deletes a specific user",
     *      description="Deletes a specific user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Deletes a specific user
     */
    public function destroy(User $user)
    {
        $user->delete();

        $result = "User deleted";

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "text/plain; charset=utf-8");
    }

    /**
     * @OA\Get(
     *      path="/user/{id}/articles",
     *      operationId="showUserArticles",
     *      tags={"Article", "User"},
     *      summary="Shows articles from a user",
     *      description="Shows articles from a user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Shows articles from a user
     */
    public function getArticles(User $user)
    {
        $result = Article::with('author')->get()->where('author', $user);

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "application/json; charset=utf-8");
    }

    public function getAuth()
    {
        $result = Auth::User();

        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "application/json; charset=utf-8");
    }

}
