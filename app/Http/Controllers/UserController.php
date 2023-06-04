<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends AppBaseController
{
    /**
     * @return Response
     *
     * @OA\Post(
     *      path="/login",
     *      summary="Login to systems and return the token.",
     *      tags={"Authentication"},
     *      description="Do Login",
     *      @OA\Parameter(
     *          name="body",
     *          in="query",
     *          description="Login Username & Password",
     *          required=true,
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="admin@gmail.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  example="admin"
     *              ),
     *              @OA\Property(
     *                  property="c_password",
     *                  type="string",
     *                  example="admin"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $login  = $this->authenticate($email, $password);
        $data = $login;

        if (empty($login)) {
            return $this->sendError('Email atau password anda kurang tepat!');
        }

        return $this->sendResponse($data, 'Login Sukses');
    }

    /**
     * login saja, tanpa kembalikan data user
     */
    public function authenticate($email, $password)
    {
        $credentials['email']   = $email;
        $credentials['password']   = $password;

        if (!Auth::attempt($credentials)) {
            return false;
        }

        /** @var \App\Models\Model $user **/
        $user = Auth::user();
        $tokenResult = $user->createToken('ApiPassToken');

        $data = array();
        $data['data'] = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        return $data;
    }

    /**
     * @return Response
     *
     * @OA\Post(
     *      path="/register",
     *      summary="Register New Account.",
     *      tags={"Authentication"},
     *      description="Do Register",
     *      @OA\Parameter(
     *          name="body",
     *          in="query",
     *          description="Register Username & Password",
     *          required=true,
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="admin"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="admin@gmail.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  example="admin"
     *              ),
     *              @OA\Property(
     *                  property="c_password",
     *                  type="string",
     *                  example="admin"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function register(Request $request)
    {
        $email = $request->input('email');

        if (!is_string($email)) {
            return __('messages.auth.email_invalid');
        }
        if (User::where("email", $email)->exists()) {
            return __('messages.auth.email_exist');
        }
        $response = $this->newRegister($request);

        if (isset($response)) {
            return $this->sendResponse($response, __('messages.auth.register_success'));
        }
    }

    private function newRegister($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('ApiPassToken')->accessToken;
        $success['name'] =  $user->name;

        return $success;
    }
}
