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
        return $NewsData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $args)
    {
        //
        $validator = Validator::make($args, [
            'source' => 'required',
            'author' => 'required',
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'urlToImage' => 'required',
            'publishedAt' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }
        $args['source'] = json_encode($args['source']);
        $args['userId'] = $request->user()->id;
        $args['publishedAt'] = date_create($args["publishedAt"])->format('Y-m-d H:i:s');
        $newData = News::create($args);
        
        return $newData;
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
    {   // soft delete || "isActive" attribute 
        $userId = $request->user()->id;
        $result = News::where('id', $id)->where('userId', $userId)->delete();
        if ($result == 0) {
            return response()->json('No news deleted', 400);
        }
        return response()->json(['result' => $result]);
    }
}
