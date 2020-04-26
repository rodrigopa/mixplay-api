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
use App\Domain\Media\Video\Repositories\VideoRepository;
use Illuminate\Support\Facades\DB;

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
        $collection = new MovieResource($this->repository->getWithVideo($id), ['video']);
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
     * @param VideoRepository $videoRepository
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreMovie $storeMovieRequest, VideoRepository $videoRepository)
    {
        $this->prepare($storeMovieRequest,
            function($fields, $videoFields) use ($videoRepository)
            {
                $video = $videoRepository->create($videoFields);
                $fields['video_id'] = $video->id;
                $movie = $this->repository->create($fields);

                return new MovieResource($movie);
            }
        );

//        $fields = $storeMovieRequest->only('name', 'year', 'trailer_url',
//            'description', 'videos', 'metadata');
//
//        // transaction to handle movie and videos
//        DB::beginTransaction();
//
//        try {
//            $videos = json_decode($fields['videos']);
//            $videoFields = [];
//
//            if (isset($videos->sd))
//                $videoFields['sd'] = json_encode($videos->sd);
//
//            if (isset($videos->hd))
//                $videoFields['hd'] = json_encode($videos->hd);
//
//            if (isset($videos->fullhd))
//                $videoFields['fullhd'] = json_encode($videos->fullhd);
//
//            $video = $videoRepository->create($videoFields);
//            $fields['video_id'] = $video->id;
//            $movie = $this->repository->create($fields);
//
//            DB::commit();
//            return $this->responseSuccess(new MovieResource($movie));
//        }
//        catch(\Exception $e)
//        {
//            DB::rollback();
//            return $this->responseError('Falha ao cadastrar: ' . $e->getMessage());
//        }
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
     * @param $movieId
     * @param VideoRepository $videoRepository
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ValidateMovie $validateMovieRequest, StoreMovie $storeMovieRequest,
                           $movieId, VideoRepository $videoRepository)
    {
        $this->prepare($storeMovieRequest,
            function($fields, $videoFields) use ($movieId, $videoRepository)
            {
                $movie = $this->repository->find($movieId);
                $movie->video->update($videoFields);
                $this->repository->update($fields, $movieId);

                return [];
            }
        );
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
    public function destroy(ValidateMovie $validateMovieRequest, $movieId)
    {
        $this->repository->delete($movieId);
        return $this->responseSuccess();
    }

    private function prepare($request, callable $operationCallable)
    {
        $fields = $request->only('name', 'year', 'trailer_url',
            'description', 'videos', 'metadata');

        // transaction to handle movie and videos
        DB::beginTransaction();

        try {
            $videos = json_decode($fields['videos']);
            $videoFields = [];

            if (isset($videos->sd))
                $videoFields['sd'] = json_encode($videos->sd);

            if (isset($videos->hd))
                $videoFields['hd'] = json_encode($videos->hd);

            if (isset($videos->fullhd))
                $videoFields['fullhd'] = json_encode($videos->fullhd);

            $return = $operationCallable($fields);

            DB::commit();
            return $this->responseSuccess($return);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return $this->responseError('Falha ao fazer operação: ' . $e->getMessage());
        }
    }
}
