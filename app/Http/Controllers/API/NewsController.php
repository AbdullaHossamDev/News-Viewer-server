<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $NewsData = News::where('userId', $userId)->get();
        return response()->json($NewsData, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'source' => 'required',
            'author' => 'required',
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'urlToImage' => 'required',
            'publishedAt' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        $request['source'] = json_encode($request->source);
        $request['userId'] = $request->user()->id;
        $request['publishedAt'] = date_create($request->publishedAt)->format('Y-m-d H:i:s');
        $newData = News::create($request->toArray());
        return response($newData, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;
        $result = News::where('id', $id)->where('userId', $userId)->delete();
        if($result == 0){
            return response()->json('No news deleted',400);
        }
        return response()->json(['result' => $result]);
    }
}
