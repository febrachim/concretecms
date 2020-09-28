<?php

namespace Modules\Media\Http\Controllers;

use Modules\Article\Entities\Article;
use Illuminate\Support\Facades\Auth;
use Modules\Media\Entities\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MediaAdminController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return Response
    */
    public function index()
    {
        $banners = [];
        $articles = Article::all();
        Foreach($articles as $article){
            $banners[] = $article->getMedia('article-banner');
        }
        
        $articles = Article::with('media')->get();
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('media::admin.index')->with(
            array(
                'name' => $name,
                'articles' => $articles,
                'banners' => $banners
            ));
        }
        
        /**
        * Show the form for creating a new resource.
        * @return Response
        */
        public function create()
        {
            return view('media::create');
        }
        
        /**
        * Store a newly created resource in storage.
        * @param Request $request
        * @return Response
        */
        public function store(Request $request)
        {
            // Article::create()
            //     ->addMedia($request->media)
            //     ->toMediaCollection();
            // return redirect()->back();
            
            return $request->all();
        }
        
        /**
        * Show the specified resource.
        * @param int $id
        * @return Response
        */
        public function show($id)
        {
            return view('media::show');
        }
        
        /**
        * Show the form for editing the specified resource.
        * @param int $id
        * @return Response
        */
        public function edit($id)
        {
            return view('media::edit');
        }
        
        /**
        * Update the specified resource in storage.
        * @param Request $request
        * @param int $id
        * @return Response
        */
        public function update(Request $request, $id)
        {
            //
        }
        
        /**
        * Remove the specified resource from storage.
        * @param int $id
        * @return Response
        */
        public function destroy($id)
        {
            //
        }
    }
    