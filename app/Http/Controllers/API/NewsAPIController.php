<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsAPIController extends Controller
{
    public function getNews()
    {

        $egyBusiness = Http::get('http://newsapi.org/v2/top-headlines?country=EG&category=business&apiKey=8514314244904de3af1a0372a76b3f1b');
        $egySports = Http::get('http://newsapi.org/v2/top-headlines?country=EG&category=sports&apiKey=8514314244904de3af1a0372a76b3f1b');
        $aeBusiness = Http::get('http://newsapi.org/v2/top-headlines?country=AE&category=business&apiKey=8514314244904de3af1a0372a76b3f1b');
        $aeSports = Http::get('http://newsapi.org/v2/top-headlines?country=AE&category=sports&apiKey=8514314244904de3af1a0372a76b3f1b');
        $res = [
            $egyBusiness->json()['articles'],
            $egySports->json()['articles'],
            $aeBusiness->json()['articles'],
            $aeSports->json()['articles']
        ];
        return response()->json($res);
    }
}
