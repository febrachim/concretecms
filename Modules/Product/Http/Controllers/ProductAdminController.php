<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;
use Sopamo\LaravelFilepond\Filepond;
use Session;
use Storage;

class ProductAdminController extends Controller
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
        $products = Product::with('productCategories')->get();
        if(request()->ajax()) {
            return datatables()->of($products)
                    ->addColumn('action', function($data) {
                        $button = '<a href="'.route('admin.product.show', $data->id).'" type="button" name="view" id="'.$data->id.'" class="btn btn-default btn-flat btn-sm mr-1"><i class="fas fa-eye fa-sm"></i></a>';
                        $button .= '<a href="'.route('admin.product.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat btn-sm mr-1"><i class="fas fa-pen fa-sm"></i></a>';
                        $button .= '<button type="button" class="btn btn-danger btn-flat btn-sm mr-1 deleteProduct" data-toggle="modal" data-target="#deleteModal" id="'.$data->id.'"><i class="fas fa-trash fa-sm"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('product::admin.index')->with(
            array(
                'name' => $name,
                'products' => $products
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
        $categories = ProductCategory::all();
        foreach ($categories as $key => $category) {
            $checkbox_categories[$key]['text'] = $category->name;
            $checkbox_categories[$key]['value'] = $category->id;
        }
        return view('product::admin.create')->with(
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
            'name' => 'required|max:255|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'categories' => 'required',
            'packaging' => 'required',
            'composition' => 'required',
            'overview' => 'required',
            'instruction' => 'required',
            'packshots' => 'required'
        ]);
        $product = new Product;
        
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->packaging = $request->packaging;
        $product->composition = $request->composition;
        $product->overview = $request->overview;
        $product->instruction = $request->instruction;

        if($request->hasFile('packshots')) {
            foreach ($request->file('packshots') as $packshot) {
                $product->addMedia($packshot)->toMediaCollection('packshot');
            }
        }
        $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
        
        if($product->save()) {
            $product->productCategories()->sync($request->input('categories'));
            $arr = array('msg' => 'Product Added Successfully!', 'status' => true);
        }

        Session::flash('success', 'Product successfully created');
        // return as JSON
        return Response()->json($arr);

        // return redirect()->route('admin.product.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
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

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function imageUpload(Request $request) {
        $filepond = new FilePond;
        if($request->has('packshots')) 
        {
            foreach ($request->packshots as $key => $packshot) {
                // $product->addMedia($packshot)->toMediaCollection('packshot');
                // Get the temporary path using the serverId returned by the upload function in `FilepondController.php`
                $path = $filepond->getPathFromServerId($packshot.serverId);
            }
        }

        return $path;
    }
}
