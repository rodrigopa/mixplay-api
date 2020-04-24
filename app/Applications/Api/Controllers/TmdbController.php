<?php


namespace App\Applications\Api\Controllers;

use App\Applications\Api\Requests\Tmdb\ValidateSearch;
use App\Domain\Tmdb\Resources\MovieResource;
use App\Domain\Tmdb\Resources\SearchCollection;
use App\Domain\Tmdb\Resources\TvShowResource;
use Tmdb\Exception\TmdbApiException;
use Tmdb\Laravel\Facades\Tmdb;
use Tmdb\Model\Tv\QueryParameter\AppendToResponse;

/**
 * @OA\Tag(
 *     name="TMDB",
 *     description="Operações na API de filmes e série TMDB."
 * )
 */
class TmdbController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tmdb/search/{query}",
     *     tags={"TMDB"},
     *     summary="Buscar por filmes ou séries",
     *     operationId="tmdbSearch",
     *     @OA\Parameter(
     *          name="query",
     *          in="path",
     *          required=true,
     *          description="Texto a ser pesquisado",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Página",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/TMDB\Search Collection")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param ValidateSearch $request
     * @param $query
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function search(ValidateSearch $request, $query)
    {
        $page = isset($request->page) && ((int) $request->page) > 0 ? $request->page : 1;
        $result = Tmdb::getSearchApi()->searchMulti($query, ['page' => $page]);
        $collection = new SearchCollection(collect($result));
        return $this->responseSuccess($collection);
    }

    /**
     * @OA\Get(
     *     path="/tmdb/movie/{id}",
     *     tags={"TMDB"},
     *     summary="Detalhar filme por id",
     *     operationId="tmdbMovieDetail",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="TMDB ID do filme",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/TMDB\Movie")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function movieDetail($id)
    {
        try
        {
            $movie = Tmdb::getMoviesApi()->getMovie($id);
            $result = new MovieResource(collect($movie));
            return $this->responseSuccess($result);
        }
        catch (TmdbApiException $e)
        {
            return $this->responseError('Falha ao buscar por filme.');
        }
    }

    /**
     * @OA\Get(
     *     path="/tmdb/tvshow/{id}",
     *     tags={"TMDB"},
     *     summary="Detalhar série por id",
     *     operationId="tmdbSerieDetail",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="TMDB ID da série",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/TMDB\TvShow")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function tvShowDetail($id)
    {
        try
        {
            $appendToResponse = new AppendToResponse([
                AppendToResponse::EXTERNAL_IDS
            ]);
            $tvShow = Tmdb::getTvApi()->getTvShow($id, [$appendToResponse->getKey() => $appendToResponse->getValue()]);
            $result = new TvShowResource(collect($tvShow));
            return $this->responseSuccess($result);
        }
        catch (TmdbApiException $e)
        {
            return $this->responseError('Falha ao buscar por série.');
        }
    }
}
