<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;
use App\Http\Controllers\Controller;
use Coderello\Laraflash\Facades\Laraflash;
use Carbon\Carbon;
use Validator,Redirect;

class ArticleAdminController extends Controller
{
    public function __construct() {
        $this->middleware('role:superadministrator|administrator|editor|author|contributor');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Article::with('categories', 'author')
                ->get())
                    ->addColumn('action', function($data) {
                        $button = '<a href="'.route('admin.article.show', $data->id).'" type="button" name="view" id="'.$data->id.'" class="btn btn-default btn-flat btn-sm mr-1"><i class="fas fa-eye fa-sm"></i></a>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat btn-sm mr-1"><i class="fas fa-pen fa-sm"></i></button>';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="btn btn-danger btn-flat btn-sm mr-1"><i class="fas fa-trash fa-sm"></i></button>';
                        return $button;
                    })
                    ->editColumn('created_at', function ($article) {
                        return $article->created_at ? with(new Carbon($article->created_at))->format('d F Y') : '';
                    })
                    ->editColumn('published_at', function ($article) {
                        return $article->published_at ? with(new Carbon($article->published_at))->format('d F Y') : '';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $categories = Category::withCount('articles')->get();

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('article::admin.index')->with(
            array(
                'name' => $name,
                'categories' => $categories,
            ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $checkbox_categories = [];
        $categories = Category::all();
        foreach ($categories as $key => $category) {
            $checkbox_categories[$key]['text'] = $category->name;
            $checkbox_categories[$key]['value'] = $category->id;
        }

        return view('article::admin.create')->with(
            array(
                'name' => $name,
                'categories' => $categories,
                'checkbox_categories' => $checkbox_categories
            ));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
            'categories' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'fileBanner' => 'required',
            'fileBannerMobile' => 'required',
        ]);

        $banner_path = '';
        $banner_mobile_path = '';

        // Quill Editor Images
        // $images = $request->images;


        // // return as JSON
        // return response()->json([
        //     'banner_name' => $banner_name,
        //     'banner_path' => $banner_path,
        //     'banner_mobile_name' => $banner_mobile_name,
        //     'banner_mobile_path' => $banner_mobile_path,
        // ]);

        // COMMENT DULU SEMENTARA GW DEVELOP VUE FORM

        $user_id = isset(Auth::user()->id) ? Auth::user()->id : '';

        // Create Article
        $article = new Article;
        $article->title = $request->input('title');
        $article->slug = $request->input('slug');
        $article->excerpt = $request->input('excerpt');
        $article->content = $request->input('content');
        $article->author_id = $user_id;
        $article->banner = 'uploads/'.$banner_path;
        $article->banner_mobile = 'uploads/'.$banner_mobile_path;
        $article->published_at = Carbon::now();

        // If Quill Editor images not empty

        // if(!empty($request->input('images'))) {
        //     foreach ($images as $image)
        //     {
        //         $article->content = str_replace($image, '1', $article->content);

        //         // Create a new image from base64 string and attach it to article in article-images collection
        //         $article->addMediaFromBase64($image)->toMediaCollection('article-images');

        //         // Get all images as we will need the last one uploaded
        //         $mediaItems = $article->load('media')->getMedia('article-images');

        //         // Replace the base64 string in article body with the url of the last uploaded image
        //         $article->content = str_replace($image, $mediaItems[count($mediaItems) - 1]->getFullUrl(), $article->content);
        //     }
        // }

        $article->save();

        $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
        if($article->save()){ 
            $arr = array('msg' => 'Article Added Successfully!', 'status' => true);
        }


        // Make array categories
        // $categoriesArray = explode(',', $request->input('categories'));
        $currentArticle = Article::where('slug', '=', $request->input('slug'))->first();
        $currentArticle->categories()->sync($request->input('categories'));


        // Check if banner is not null
        if($request->has('fileBanner')){
            $currentArticle->addMedia($request->fileBanner)->toMediaCollection('article-banner');

            // $banner = $request->file('fileBanner');

            // // Set banner name
            // $banner_name = 'banner-' . $request->input('slug') . '-' . time() . '.' . $banner->getClientOriginalExtension();

            // // Save banner to public/uploads directory
            // $banner_path = $banner->storeAs('banner', $banner_name, 'public_uploads');
        }

        // Check if mobile banner is not null
        if($request->has('fileBannerMobile')){
            $currentArticle->addMedia($request->fileBannerMobile)->toMediaCollection('article-mobile-banner');
            
            // $banner_mobile = $request->file('fileBannerMobile');

            // // Set mobile banner name
            // $banner_mobile_name = 'banner-mobile-' . $request->input('slug') . '-' . time() . '.' . $banner_mobile->getClientOriginalExtension();

            // // Save mobile banner to public/uploads directory
            // $banner_mobile_path = $banner_mobile->storeAs('banner', $banner_mobile_name, 'public_uploads');
        }


        // return redirect('backoffice/article')->with('success', 'Article Created');

        // return json_encode($request->all());
        // return as JSON
        return Response()->json($arr);

        // if($article->save()) {
        //     flash('Article sucessfully created')->success();
        // } else {
        //     flash('An error occured')->error()->important();
        // }

        // return redirect()->route('admin.article.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $article = Article::where('id', $id)->with('categories')->first();

        return view('article::admin.show')->with(
            array(
                'name' => $name,
                'article' => $article
            ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('article::edit');
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
