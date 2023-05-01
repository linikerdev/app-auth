<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    private $baseUrl = 'http://192.168.0.222:3333';
    public  $loading = false;

    public function Home(Request $request){
        $users  = [];
        // obter um token

        if (!$request->session()->exists('token')) {
        $requestToken = Http::post($this->baseUrl.'/api/auth/signin', [
	        "username" => "magno",
            "password" => "123123"
        ]);
            $tokenGenerated = $requestToken->json()['accessToken'];
            $refreshTokenGenerated = $requestToken->json()['refreshToken'];

            session(['token' => $tokenGenerated]);
            session(['refreshToken' => $refreshTokenGenerated]);
        }


        if(session('token')){
                $responseUsers = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'x-access-token' => session('token')
                ])->get($this->baseUrl.'/api/test/user');

                if($responseUsers->status() === 401){
                    $this->refreshToken();
                    $this->loading = true;
                }

            if($responseUsers->status() === 200){
                $users = $responseUsers->json();
                $this->loading = false;
            }

        }else{
            return new \Error('deu ruim');
        }

        return view('welcome', [
            "users" => $users,
            "loading" =>  $this->loading
        ]);
    }



    public function RefreshToken(){

            $requestToken = Http::post($this->baseUrl.'/api/auth/refreshtoken', [
                "refreshToken" =>  session('refreshToken')
            ]);
            $tokenGenerated = $requestToken->json()['accessToken'];
            $refreshTokenGenerated = $requestToken->json()['refreshToken'];
            session()->put(['token' => $tokenGenerated]);
            session()->put(['refreshToken' => $refreshTokenGenerated]);
    }

}
