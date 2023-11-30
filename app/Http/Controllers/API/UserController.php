<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRoleView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = UserRoleView::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            dd($error->getMessage());
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $request->validate([
                    'identity_number' => ['required', 'integer', 'unique:users'],
                    'name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'type' => ['required'],
                    'password' => ['required']
                ]);

                $user = User::create([
                    'name' => $request->name,
                    'identity_number' => $request->identity_number,
                    'email' => $request->email,
                    'last_name' => $request->last_name,
                    'password' => Hash::make($request->password),
                ]);

                $dosenRole = Role::where('name', 'dosen')->first();
                $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
                $sadminRole = Role::where('name', 'sadmin')->first();

                switch ($request->type) {
                    case 'lecturer':
                        $user->syncRolesWithoutDetaching([$dosenRole]);
                        break;
                    case 'student':
                        $user->syncRolesWithoutDetaching([$mahasiswaRole]);
                        break;
                    case 'admin':
                        $user->syncRolesWithoutDetaching([$sadminRole]);
                        break;
                }

                $tokenResult = $user->createToken('authToken')->plainTextToken;

                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user
                ], 'User Registered');
            } catch (Exception $error) {
                DB::rollBack();
                dd($error->getMessage());
                return ResponseFormatter::error([
                    'message' => 'Something went wrong',
                    'error' => $error,
                ], 'Authentication Failed', 500);
            }
        });
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }
}
