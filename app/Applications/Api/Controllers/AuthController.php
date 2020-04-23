<?php

namespace App\Applications\Api\Controllers;

use App\Applications\Api\Requests\Auth\Signin;
use App\Applications\Api\Requests\Auth\Signup;
use App\Domain\Account\Events\SignUpEvent;
use App\Domain\Account\Repositories\UserRepository;
use App\Domain\Account\Resources\UserResource;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Operações para autenticação"
 * )
 */
class AuthController extends Controller
{
    use SendsPasswordResetEmails;

    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Post(
     *     path="/auth/signUp",
     *     tags={"Auth"},
     *     summary="Registrar um usuário",
     *     operationId="signUp",
     *     @OA\Response(response=422, ref="#components/responses/failed_validation"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="access_token",type="string",description="Token de acesso")
     *              )
     *         )
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/Signup")
     * )
     * @param Signup $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function signUp(Signup $request)
    {
        $user = $this->user->create($request->all());
        event(new SignUpEvent($user));
        $token = auth('api')->login($user);
        return $this->responseSuccess(['access_token' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/auth/signIn",
     *     tags={"Auth"},
     *     summary="Logar um usuário",
     *     operationId="signIn",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="access_token",type="string",description="Token de acesso"),
     *                  @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Usuário ou senha invalidos"
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/Signin")
     * )
     * @param Signin $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function signIn(Signin $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = auth('api')->attempt($credentials);

        if ($token === false) {
            return $this->responseFail(['message' => 'Usuário ou senha inválidos.']);
        }

        $data = [
            'access_token' => $token,
            'user' => new UserResource(auth('api')->user())
        ];

        return $this->responseSuccess($data);
    }

    /**
     * @OA\Get(
     *     path="/auth/me",
     *     tags={"Auth"},
     *     summary="Recuperar informações do usuário autenticado",
     *     operationId="userMe",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="string",example="success"),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#components/responses/unauthorized")
     * )
     */
    public function me()
    {
        $data = auth('api')->user();
        return $this->responseSuccess($data);
    }

    /**
     * @OA\Post(
     *     path="/auth/recovery",
     *     tags={"Auth"},
     *     summary="Resetar senha",
     *     operationId="recovery",
     *     @OA\Response(response=200, ref="#components/responses/success"),
     *     @OA\Response(
     *         response=422,
     *         description="Email inválido"
     *     ),
     *     @OA\RequestBody(
     *         description="Parâmetros para recuperar senha",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="email", type="string")
     *         )
     *     )
     * )
     */
    public function recovery(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response !== Password::RESET_LINK_SENT) {
            return $this->responseFail(['message' => 'Email inválido.']);
        }

        return $this->responseSuccess(['message' => 'Um email para resetar sua senha foi enviado.']);
    }

}
