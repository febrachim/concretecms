<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

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
                        $button = '<a href="'.route('admin.user.show', $data->id).'" type="button" name="edit" id="'.$data->id.'" class="btn btn-default btn-flat"><i class="fas fa-eye"></i></a>';
                        $button .= '<a href="'.route('admin.user.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat"><i class="fas fa-pen"></i></a>';
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
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        return view('user::admin.create')->with(
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
        ]);

        if($request->has('password') && !empty($request->password)) {
            $password = $request->password; 
        } else {
            //Auto generate password
            $length = 10;
            $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }
            $password = $str;
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->api_token = bin2hex(openssl_random_pseudo_bytes(30)); 
        $user->save();

        if($user->save()) {
             return redirect()->route('admin.user.show', $user->id);
        } else {
            Session::flash('danger', 'Sorry, a problem occured while creating user ');
            return redirect()->route('admin.user.create');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $user = User::findOrFail($id);

        return view('user::admin.show')->with(
            array(
                'name' => $name,
                'user' => $user
            ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $user = User::findOrFail($id);

        return view('user::admin.edit')->with(
            array(
                'name' => $name,
                'user' => $user
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password_options == 'auto') {
            //Auto generate password
            $length = 10;
            $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }
            $user->password = Hash::make($str);
        } else if ($request->password_options == 'manual') {
            $user->password = Hash::make($request->password);
        }

        if($user->save()) {
             return redirect()->route('admin.user.show', $user->id);
        } else {
            Session::flash('danger', 'Sorry, a problem occured while updating user ');
            return redirect()->route('admin.user.edit');
        }
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
