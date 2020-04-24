<?php


namespace App\Applications\Api\Controllers\Media;

use App\Applications\Api\Controllers\Controller;
use App\Applications\Api\Requests\Media\Genre\StoreGenre;
use App\Applications\Api\Requests\Media\Genre\ValidateGenre;
use App\Domain\Media\Genre\Repositories\GenreRepository;
use App\Domain\Media\Genre\Resources\GenreCollection;
use App\Domain\Media\Genre\Resources\GenreResource;

/**
 * @OA\Tag(
 *     name="Genres",
 *     description="Operações CRUD para gêneros."
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
        $collection = new GenreCollection($this->repository->getOrderedByName()->paginate());
        return $this->responseSuccess($collection);
    }

    /**
     * @OA\Post(
     *     path="/genre",
     *     tags={"Genres"},
     *     summary="Criar gênero",
     *     operationId="genreStore",
     *     @OA\RequestBody(ref="#components/requestBodies/StoreGenre"),
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
     * @param StoreGenre $storeGenreRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreGenre $storeGenreRequest)
    {
        $fields = $storeGenreRequest->only('name');
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
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#components/requestBodies/StoreGenre"),
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
     * @param ValidateGenre $validateGenreRequest
     * @param StoreGenre $storeGenreRequest
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ValidateGenre $validateGenreRequest, StoreGenre $storeGenreRequest, $genreId)
    {
        $fields = $storeGenreRequest->only('name');
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
     *          @OA\Schema(type="integer")
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
     * @param ValidateGenre $validateGenreRequest
     * @param $genreId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(ValidateGenre $validateGenreRequest, $genreId)
    {
        $this->repository->delete($genreId);
        return $this->responseSuccess();
    }
}
