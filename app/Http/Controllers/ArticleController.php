<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleUpdateRequest;
use Validator;

class ArticleController extends Controller
{

    /**
     * @OA\Get(
     *      path="/article",
     *      operationId="getArticleList",
     *      tags={"Article"},
     *      summary="Get list of articles",
     *      description="Returns list of articles",
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
     * Returns list of articles
     */
    public function index()
    {
        $result = Article::with('author')->get();

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
     *      path="/article",
     *      operationId="storeArticle",
     *      tags={"Article"},
     *      summary="Create new article",
     *      description="Creates a new article",
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
     *                     description="article title",
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="article description",
     *                     property="description",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="artile image",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 @OA\Property(
     *                     description="article author",
     *                     property="user_id",
     *                     type="integer",
     *                 ),
     *                 required={"image", "title", "description", "user_id"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new article
     */

    public function store(ArticleUpdateRequest $request)
    {

        $data = $request->only(['title', 'description', 'image', 'user_id']);
        $path = $request->file('image')->store('articleImages');
        $data['image'] = $path;


        $result = Article::create($data);

        $message = [
            'status' => '201',
            'message' => 'New article created',
            'data' => $result
        ];

        return response($message, 201)
            ->header('Content-Type', "application/json; charset=utf-8");
    }


    /**
     * @OA\Get(
     *      path="/article/{id}",
     *      operationId="showArticle",
     *      tags={"Article"},
     *      summary="Shows specific article",
     *      description="Shows a specific article",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
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
     * Shows a specific article
     */

    public function show(Article $article)
    {
        $result = Article::with('author')->find($article->id);


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
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/article/{id}",
     *      operationId="updateArticle",
     *      tags={"Article"},
     *      summary="Updates an article",
     *      description="Updates an article",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
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
     *                     description="article title",
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="article description",
     *                     property="description",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="artile image",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 @OA\Property(
     *                     description="article author",
     *                     property="user_id",
     *                     type="integer",
     *                 ),
     *                 required={"image", "title", "description", "user_id"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Updates an article
     */

    public function update(ArticleUpdateRequest $request, Article $article)
    {

        $data = $request->only('title', 'description', 'image', 'user_id');
        $path = $request->file('image')->store('articleImages');
        $data['image'] = $path;

        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->user_id = $data['user_id'];
        $article->image = $data['image'];
        $article->save();

        $result = $article;


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
     *      path="/article/{id}",
     *      operationId="deleteArticle",
     *      tags={"Article"},
     *      summary="Deletes a specific article",
     *      description="Deletes a specific article",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
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
     * Deletes a specific article
     */

    public function destroy(Article $article)
    {
        $article->delete();

        $result = "Article deleted";


        $message = [
            'status' => '200',
            'message' => 'Operation Successful',
            'data' => $result
        ];

        return response($message, 200)
            ->header('Content-Type', "text/plain; charset=utf-8");
    }
}
