<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Carbon\Carbon;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::with('roles')
                ->get())
                    ->addColumn('action', function($data) {
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat"><i class="fas fa-pen"></i></button>';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->editColumn('created_at', function ($user) {
                        return $user->created_at ? with(new Carbon($user->created_at))->format('d F Y') : '';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $usr = User::with('roles')->get();

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('user::admin.index')->with(
            array(
                'name' => $name,
                'usr' => $usr
            ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
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
