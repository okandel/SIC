<?php

namespace App\Http\Controllers\Web\Firm;


use App\Announcement;
use App\Repositories\Announcements\AnnouncementsRepositoryInterface;
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AnnouncementsController extends BaseFirmController
{
    protected $announcementRep;
    protected $clientRep;
    protected $employeeRep;

    //***********************************************************************************
    public function __construct(AnnouncementsRepositoryInterface $announcementRep,
                                ClientsRepositoryInterface $clientRep,
                                EmployeesRepositoryInterface $employeeRep)
    {
        parent::__construct();
        $this->announcementRep = $announcementRep;
        $this->clientRep = $clientRep;
        $this->employeeRep = $employeeRep;
    }

    //***********************************************************************************
    public function index()
    {
        $clients = $this->clientRep->list();
        $employees = $this->employeeRep->list();
        return view('firm.announcements.index')
            ->with([
                'clients' => $clients,
                'employees' => $employees
            ]);
    }

    //***********************************************************************************
    public function getAnnouncements(Request $request)
    {
        return datatables()->of($this->announcementRep->list())->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $announcement = new Announcement();
        $clients = $this->clientRep->list();
        $employees = $this->employeeRep->list();
        return view('firm.announcements.create')
            ->with([
                'announcement' => $announcement,
                'clients' => $clients,
                'employees' => $employees
            ]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'subject.required' => 'The subject field is required!',
            'message.required' => 'The message field is required!',
            'published_at.required' => 'The published at field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
            'published_at' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $announcement_array = [
            'Client_IDs' => json_encode($request->Client_IDs),
            'Emp_IDs' => json_encode($request->Emp_IDs),
            'subject' => $request->subject,
            'message' => $request->message,
            'published_at' => $request->published_at,
        ];

        $created_announcement = $this->announcementRep->create($announcement_array);
        if ($created_announcement) {
            session()->flash('success_message', 'Announcement created successfully');
            return redirect()->back();
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $announcement = $this->announcementRep->get($id);
        $clients = $this->clientRep->list();
        $employees = $this->employeeRep->list();
        return view('firm.announcements.edit')
            ->with([
                'announcement' => $announcement,
                'clients' => $clients,
                'employees' => $employees
            ]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'subject.required' => 'The subject field is required!',
            'message.required' => 'The message field is required!',
            'published_at.required' => 'The published at field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
            'published_at' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $announcement_array = [
            'Client_IDs' => json_encode($request->Client_IDs),
            'Emp_IDs' => json_encode($request->Emp_IDs),
            'subject' => $request->subject,
            'message' => $request->message,
            'published_at' => $request->published_at,
        ];

        $updated_announcement = $this->announcementRep->update($id, $announcement_array);
        if ($updated_announcement) {
            session()->flash('success_message', 'Announcement updated successfully');
            return redirect('/firm/announcements/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_announcement = $this->announcementRep->delete($id);
        if ($deleted_announcement) {
            session()->flash('success_message', 'Announcement deleted successfully');
            return redirect('/firm/announcements/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
