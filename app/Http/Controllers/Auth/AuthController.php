<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Retcode;
use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $req) {
        try {
            $request = $req->validated();
            $request['password'] = Hash::make($req->password);
            $user = User::create(array_merge($request));

            return $this->successResponse('register success');
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function login(LoginRequest $req) {
        try {
            $request = $req->validated();

            $user = User::where('email', $request['email'])
                        ->first();
            if (!$user) {
                return $this->errorResponse('user with email: '.$request['email'].' not found', 'unauthorized', Retcode::UNATHORIZED_ERROR, 403);
            }

            if (!Hash::check($request['password'], $user->password)) {
                return $this->errorResponse('password hash check failed', 'unauthorized', Retcode::UNATHORIZED_ERROR, 403);
            }

            $token = $user->createToken('acces-token', [TokenAbility::BOOK_CRUDS])->plainTextToken;
            $user->token = $token;

            // TODO: move this to model
            unset($user->password);
            unset($user->email_verified_at);
            unset($user->created_at);
            unset($user->updated_at);
            unset($user->deleted_at);
            unset($user->deleted_by);
            return $this->successResponse('authorized', $user);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
