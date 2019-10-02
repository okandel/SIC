<?php

namespace App\Http\Controllers\Web\Firm;

use App\FirmLogin;
use App\Repositories\Missions\MissionsRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Snowfire\Beautymail\Beautymail;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 

class UsersController extends BaseFirmController
{
    protected $userRep;
    protected $missionRep;

    //***********************************************************************************
    public function __construct(UsersRepositoryInterface $userRep, MissionsRepositoryInterface $missionRep)
    {
        parent::__construct();
        $this->userRep = $userRep;
        $this->missionRep = $missionRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.users.index');
    }

    //***********************************************************************************
    public function get($id)
    {
        $user = $this->userRep->get($id);
        $missions = $this->missionRep->list(["AssignedBy" => $user->id]);

        return view('firm.users.profile')->with(['user' => $user, 'missions' => $missions]);
    }

    //***********************************************************************************
    public function getUsers(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        return datatables()->of($this->userRep->list($first_name, $last_name))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $user = new FirmLogin();
        return view('firm.users.create')->with(['user' => $user]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'password.required' => 'The password field is required!',
            'phone.required' => 'The phone field is required!',
        ];

        $firm = \CurrentFirm::get();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'max:255',
                Rule::unique('firms_logins')->where('FirmId', $firm->id),
            ],
            'password' => 'required|confirmed|min:6',
            'phone' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $user_array = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ];

        $created_user = $this->userRep->create($user_array);
        if ($created_user) {
            session()->flash('success_message', 'User created successfully');
            return redirect('/firm/users/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $user = $this->userRep->get($id);
        return view('firm.users.edit')->with(['user' => $user]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
        ];


        $firm = \CurrentFirm::get();
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'max:255',
                    Rule::unique('firms_logins')->where('FirmId', $firm->id)->ignore($id),
                ],
                'phone' => 'required',
                'password' => 'required|confirmed|min:6'
            ], $messages);
        } else {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'max:255',
                    Rule::unique('firms_logins')->where('FirmId', $firm->id)->ignore($id),
                ],
                'phone' => 'required',
            ], $messages);
        }

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $user_array = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        if ($request->password) {
            $user_array['password'] = bcrypt($request->password);
        }

        $user_array['hash'] = md5(rand() . time());

        $updated_user = $this->userRep->update($id, $user_array);
        if ($updated_user) {

            session()->flash('success_message', 'User updated successfully');
            return redirect('/firm/users/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }


    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_user = $this->userRep->delete($id);
        if ($deleted_user) {
            session()->flash('success_message', 'User deleted successfully');
            return redirect('/firm/users/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
