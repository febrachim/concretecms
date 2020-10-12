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
use Session;

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
                    $count = '<a href="'.route('admin.article.category', $data->id).'" name="articles" id="'.$data->id.'">'.count($data->articles).'</a>';
                    return $count;
                })
                ->addColumn('action', function($data) {
                    $button = '<a href="'.route('admin.category.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat btn-sm mr-1"><i class="fas fa-pen fa-sm"></i></a>';
                    $button .= '<button type="button" class="btn btn-danger btn-flat btn-sm mr-1 deleteCategory" data-toggle="modal" data-target="#deleteModal" id="'.$data->id.'"><i class="fas fa-trash fa-sm"></i></button>';
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
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        
        return view('category::admin.create')->with(
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
            'name' => 'required|max:255|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        Session::flash('success', 'Category successfully created');

        return redirect()->route('admin.category.index');
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
        $category = Category::findOrFail($id);

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';

        return view('category::admin.create')->with(
            array(
                'name' => $name,
                'category' => $category,
            ));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:categories,name,'.$id,
            'slug' => 'required|unique:categories,slug,'.$id,
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        Session::flash('success', 'Category successfully updated');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $count = Category::all()->count();

        // failed
        if($count <= 1) {
            Session::flash('error', 'There must be at least 1 category');
            return view('backoffice::inc.messages'); 
        }
        $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);

        // success
        $category->articles()->detach();
        if($category->delete()){ 
            $arr = array('msg' => 'Successfully delete category '.$name, 'status' => true);
            Session::flash('success', 'Successfully delete category '.$name);
        }

        // redirect
        return view('backoffice::inc.messages'); 
    }
}
