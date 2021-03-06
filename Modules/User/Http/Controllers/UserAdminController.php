<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use Carbon\Carbon;
use DB;
use Hash;
use Session;
use Input;

class UserAdminController extends Controller
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
            return datatables()->of(User::with('roles')
                ->get())
                    ->addColumn('action', function($data) {
                        $button = '<a href="'.route('admin.user.show', $data->id).'" type="button" name="view" id="'.$data->id.'" class="btn btn-default btn-flat btn-sm mr-1"><i class="fas fa-eye fa-sm"></i></a>';
                        $button .= '<a href="'.route('admin.user.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'" class="btn btn-info btn-flat btn-sm mr-1"><i class="fas fa-pen fa-sm"></i></a>';
                        $button .= '<button type="button" class="btn btn-danger btn-flat btn-sm mr-1 deleteUser" data-toggle="modal" data-target="#deleteModal" id="'.$data->id.'"><i class="fas fa-trash fa-sm"></i></button>';
                        return $button;
                    })
                    ->editColumn('created_at', function ($user) {
                        return $user->created_at ? with(new Carbon($user->created_at))->format('d F Y') : '';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $current_user_id = isset(Auth::user()->id) ? Auth::user()->id : '';
        return view('user::admin.index')->with(
            array(
                'name' => $name,
                'current_user_id' => $current_user_id,
            ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $roles = Role::all();
        return view('user::admin.create')->with(
            array(
                'name' => $name,
                'roles' => $roles
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
            'avatar' =>  'required|file|mimes:jpeg,png',
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
        $user->save();

        if($user->save()) {
            flash('User sucessfully created')->success();
        } else {
            flash('An error occured')->error()->important();
        }

        if($request->roles) {
            $user->syncRoles(explode(',', $request->roles));
        }

        if($request->avatar) {
            $user->addMedia($request->avatar)->toMediaCollection();
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $name = isset(Auth::user()->name) ? Auth::user()->name : '';
        $user = User::where('id', $id)->with('roles')->first();

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
        $user = User::where('id', $id)->with('roles')->first();
        $roles = Role::all();

        return view('user::admin.edit')->with(
            array(
                'name' => $name,
                'user' => $user,
                'roles' => $roles
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
        $user->save();

        $user->syncRoles(explode(',', $request->roles));
        return redirect()->route('admin.user.show', $user->id);

        // if() {
        //      return redirect()->route('admin.user.show', $user->id);
        // } else {
        //     Session::flash('danger', 'Sorry, a problem occured while updating user ');
        //     return redirect()->route('admin.user.edit');
        // }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $user = User::findOrFail($id);

        if($user->delete()){
            // success
            $arr = array('msg' => 'Successfully delete user data', 'status' => true);
            Session::flash('success', 'Successfully delete user data');
        } else {
            // failed
            $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
            Session::flash('error', 'Something went wrong. Please try again!');
        }

        // pass sub view alert
        return view('backoffice::inc.messages');

        // redirect
        // return Response()->json($arr);
        // return redirect()->route('admin.user.index');
    }
}
