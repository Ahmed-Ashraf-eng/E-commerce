<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
        

        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'governrate_id' => 'required|string',
            
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $userData= $request->all();
        $userData['status'] = 0;
        $userData['password']=Hash::make($request->get('password'));
        //dd($userData);
        $user = User::create($userData);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser(Request $request)
        {
                
                try {
                        
                        $user = JWTAuth::toUser(JWTAuth::getToken());
                        

                        if (! $user) {
                                
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                return response()->json(compact('user'));
        }
        public function logout() {
                if(JWTAuth::invalidate(JWTAuth::getToken())){
                        return response()->json(["message"=>"logoud out successfully"],200);
                }else{
                        return response()->json(["message"=>"logoud out faild"],400);
                }
            }
}
