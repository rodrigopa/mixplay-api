<?php


namespace App\Applications\Api\Controllers;

use App\Applications\Api\Requests\Genre\StoreGenre;
use App\Applications\Api\Requests\Genre\ValidateGenre;
use App\Applications\Api\Requests\Genre\ValidGenre;
use App\Domain\Genre\Repositories\GenreRepository;
use App\Domain\Genre\Resources\GenreCollection;
use App\Domain\Genre\Resources\GenreResource;

/**
 * @OA\Tag(
 *     name="Genres",
 *     description="Gêneros CRUD"
 * )
 */
class GenreController extends Controller
{
    /**
     * @var GenreRepository
     */
    private $repository;

    /**
     * GenreController constructor.
     * @param GenreRepository $repository
     */
    public function __construct(GenreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *     path="/genre",
     *     tags={"Genres"},
     *     summary="Listar gêneros",
     *     operationId="genreIndex",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Genre")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     */
    public function index()
    {
        $collection = new GenreCollection($this->repository->paginate(1));
        return $this->responseSuccess($collection);
    }

    /**
     * @OA\Post(
     *     path="/genre",
     *     tags={"Genres"},
     *     summary="Criar gênero",
     *     operationId="genreStore",
     *     @OA\RequestBody(
     *          request="Signup",
     *          description="Parâmetros para registro",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string")
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Genre")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param StoreGenre $storeGenre
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreGenre $storeGenre)
    {
        $fields = $storeGenre->only('name');
        $genre = $this->repository->create($fields);
        return $this->responseSuccess(new GenreResource($genre));
    }

    /**
     * @OA\Put(
     *     path="/genre/{genre}",
     *     tags={"Genres"},
     *     summary="Atualizar gênero",
     *     operationId="genreUpdate",
     *     @OA\Parameter(
     *          name="genre",
     *          in="path",
     *          required=true,
     *          description="ID do gênero",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          request="Genre",
     *          description="Parâmetros",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string")
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Genre")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateGenre $validateGenre
     * @param StoreGenre $storeGenre
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ValidateGenre $validateGenre, StoreGenre $storeGenre, $genreId)
    {
        $fields = $storeGenre->only('name');
        $this->repository->update($fields, $genreId);
        return $this->responseSuccess();
    }

    /**
     * @OA\Delete(
     *     path="/genre/{genre}",
     *     tags={"Genres"},
     *     summary="Remover gênero",
     *     operationId="genreDestroy",
     *     @OA\Parameter(
     *          name="genre",
     *          in="path",
     *          required=true,
     *          description="ID do gênero",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Genre")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateGenre $validateGenre
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(ValidateGenre $validateGenre, $genreId)
    {
        $this->repository->delete($genreId);
        return $this->responseSuccess();
    }
}
