<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;

class CategoryAdminController extends Controller
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
            return datatables()->of(Category::with('articles')
                ->get())
                ->addColumn('count', function($data) {
                    $count = '<a href="'.route('admin.article.category', $data->id).'" name="articles" id="'.$data->id.'">'.$data->id.'</a>';
                    return $count;
                })
                ->addColumn('action', function($data) {
                    $button = '<a href="'.route('admin.article.show', $data->id).'" type="button" name="view" id="'.$data->id.'" class="btn btn-default btn-flat btn-sm mr-1">'.$data->id.'</a>';
                    return $button;
                })
                ->rawColumns(['count','action'])
                ->make(true);
        }

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('category::admin.index')->with(
            array(
                'name' => $name,
            ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('category::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('category::edit');
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
