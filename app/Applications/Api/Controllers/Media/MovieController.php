<?php


namespace App\Applications\Api\Controllers\Media;

use App\Applications\Api\Controllers\Controller;
use App\Applications\Api\Requests\Media\Genre\StoreGenre;
use App\Applications\Api\Requests\Media\Genre\ValidateGenre;
use App\Applications\Api\Requests\Media\Movie\StoreMovie;
use App\Applications\Api\Requests\Media\Movie\ValidateMovie;
use App\Domain\Media\Movie\Repositories\MovieRepository;
use App\Domain\Media\Movie\Resources\MovieCollection;
use App\Domain\Media\Movie\Resources\MovieResource;

/**
 * @OA\Tag(
 *     name="Movies",
 *     description="Operações CRUD para filmes."
 * )
 */
class MovieController extends Controller
{
    /**
     * @var MovieRepository
     */
    private $repository;

    /**
     * GenreController constructor.
     * @param MovieRepository $repository
     */
    public function __construct(MovieRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *     path="/movie",
     *     tags={"Movies"},
     *     summary="Listar filmes",
     *     operationId="movieIndex",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     */
    public function index()
    {
        $collection = new MovieCollection($this->repository->paginate(1));
        return $this->responseSuccess($collection);
    }

    /**
     * @OA\Get(
     *     path="/movie/{movie}",
     *     tags={"Movies"},
     *     summary="Exibir detalhes de um filme",
     *     operationId="movieShow",
     *     @OA\Parameter(
     *          name="movie",
     *          in="path",
     *          required=true,
     *          description="ID do filme",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateMovie $validateMovie
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(ValidateMovie $validateMovie, $id)
    {
        $collection = new MovieResource($this->repository->find($id));
        return $this->responseSuccess($collection);
    }

    /**
     * @OA\Post(
     *     path="/movie",
     *     tags={"Movies"},
     *     summary="Cadastrar um filme",
     *     operationId="movieStore",
     *     @OA\RequestBody(ref="#components/requestBodies/StoreMovie"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param StoreMovie $storeMovieRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreMovie $storeMovieRequest)
    {
        $fields = $storeMovieRequest->only('name');
        $genre = $this->repository->create($fields);
        return $this->responseSuccess(new MovieResource($genre));
    }

    /**
     * @OA\Put(
     *     path="/movie/{movie}",
     *     tags={"Movies"},
     *     summary="Atualizar filme",
     *     operationId="movieUpdate",
     *     @OA\Parameter(
     *          name="movie",
     *          in="path",
     *          required=true,
     *          description="ID do filme",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#components/requestBodies/StoreMovie"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateMovie $validateMovieRequest
     * @param StoreMovie $storeMovieRequest
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ValidateMovie $validateMovieRequest, StoreMovie $storeMovieRequest, $genreId)
    {
        $fields = $storeMovieRequest->only('name');
        $this->repository->update($fields, $genreId);
        return $this->responseSuccess();
    }

    /**
     * @OA\Delete(
     *     path="/movie/{movie}",
     *     tags={"Movies"},
     *     summary="Remover filme",
     *     operationId="movieDestroy",
     *     @OA\Parameter(
     *          name="movie",
     *          in="path",
     *          required=true,
     *          description="ID do filme",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateMovie $validateMovieRequest
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(ValidateMovie $validateMovieRequest, $genreId)
    {
        $this->repository->delete($genreId);
        return $this->responseSuccess();
    }
}
