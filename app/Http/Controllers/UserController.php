<?php
/**
 * Created by PhpStorm.
 * User: artemy
 * Date: 6/7/19
 * Time: 4:52 AM
 */

namespace App\Http\Controllers;

use App\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if(Hash::check($request->input('password'), $user->password)){
            $api_token = base64_encode(str_random(40));

            User::where('username', $request->input('username'))->update(['api_token' => "$api_token"]);
            return response()->json(['status' => 'success','api_key' => $api_token]);
        } else {
            return response()->json(['error' => 'Userdata Incorrect'],401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrent(Request $request)
    {
        if ($request->header('x-access-token')) {
            $user = User::where('api_token', $request->header('x-access-token'))->first();
            return response()->json(['user' => $user],200);
        }

        return response()->json(['error' => 'Unauthorized.'], 401);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteToken(Request $request)
    {
        if ($request->header('x-access-token')) {
            User::where('api_token', $request->header('x-access-token'))->update(['api_token' => '']);
            return response()->json(['success' => 'Current user access token is deleted'],200);
        }

        return response()->json(['error' => 'Unauthorized.'], 401);
    }

}