<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ArticleAdminController extends Controller
{
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
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat"><i class="fas fa-pen"></i></button>';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>';
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

        return view('article::admin.create')->with(
            array(
                'name' => $name
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
            'excerpt' => 'required',
            'content' => 'required',
            'banner' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'banner_mobile' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user_id = isset(Auth::user()->id) ? Auth::user()->id : '';

        $banner = $request->file('banner');
        $banner_mobile = $request->file('banner_mobile');

        // generate a new filename. getClientOriginalExtension() for the file extension
        $banner_name = 'banner-' . $request->input('title') . '-' . time() . '.' . $banner->getClientOriginalExtension();
        $banner_mobile_name = 'mobile-banner-' . $request->input('title') . '-' . time() . '.' . $banner_mobile->getClientOriginalExtension();

        // save to public/uploads
        $banner_path = $banner->storeAs('banner', $banner_name, 'public_uploads');
        $banner_mobile_path = $banner_mobile->storeAs('banner', $banner_mobile_name, 'public_uploads');

        // Create Article
        $article = new Article;
        $article->title = $request->input('title');
        $article->slug = $request->input('slug');
        $article->excerpt = $request->input('excerpt');
        $article->content = $request->input('content');
        $article->author_id = $user_id;
        $article->banner = $banner_path;
        $article->banner_mobile = $banner_mobile_path;
        $article->published_at = Carbon::now();

        $article->save();

        return redirect('backoffice/article')->with('success', 'Article Created');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('article::show');
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
