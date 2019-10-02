<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Admins\AdminsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiAdminsController extends Controller
{
    protected $admin;

    public function __construct(AdminsRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }

    public function get(Request $request)
    {
        $admin = $this->admin->get($request->id);
        return response()->json(['data' => $admin]);
    }

    public function list()
    {
        $admins = $this->admin->list();
        return response()->json(['data' => $admins]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
//            'email_verified_at' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $admin_array = [
            'name' => $request->name,
            'email' => $request->email,
//            'email_verified_at' => $request->email_verified_at,
            'password' => $request->password,
        ];
        $admin = $this->admin->create($admin_array);

        return response()->json(['data' => $admin]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
//            'email_verified_at' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $admin_array = [
            'name' => $request->name,
            'email' => $request->email,
//            'email_verified_at' => $request->email_verified_at,
            'password' => $request->password,
        ];
        $admin = $this->admin->update($request->id ,$admin_array);

        return response()->json(['data' => $admin]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $admin = $this->admin->delete($request->id);
        return response()->json(['message' => 'Admin deleted successfully', 'deleted_admin' => $admin]);
    }

}
