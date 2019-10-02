<?php

namespace App\Http\Controllers\Web\Firm;

use App\Repositories\Tutorials\TutorialsRepositoryInterface;
use App\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class TutorialsController extends BaseFirmController
{
    protected $tutorialRep;

    //***********************************************************************************
    public function __construct(TutorialsRepositoryInterface $tutorialRep)
    {
        parent::__construct();
        $this->tutorialRep = $tutorialRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.tutorials.index');
    }

    //***********************************************************************************
    public function getTutorials(Request $request)
    {
        $title = $request->title;
        return datatables()->of($this->tutorialRep->list($title))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $tutorial = new Tutorial();
        return view('firm.tutorials.create')->with('tutorial', $tutorial);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'The title field is required!',
            'image.mimes' => 'The image must be valid image!',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            //'image' => 'image|mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $tutorial_array = [
            'title' => $request->title,
            'content' => $request["content"],
        ];

        $created_tutorial = $this->tutorialRep->create($tutorial_array);
        if ($created_tutorial) {
            if ($image = $request->image) {
                $path = 'uploads/' . $created_tutorial->firm->Slug . '/tutorials/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_tutorial->image = $path . $image_new_name;

                $created_tutorial->save();
            }
            session()->flash('success_message', 'Tutorial created successfully');
            return redirect('/firm/tutorials/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $tutorial = $this->tutorialRep->get($id);
        return view('firm.tutorials.edit')->with(['tutorial' => $tutorial]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'title.required' => 'The title field is required!',
            'image.mimes' => 'The image must be valid image!'
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $tutorial_array = [
            'title' => $request->title,
            'content' => $request["content"],
        ];

        $updated_tutorial = $this->tutorialRep->update($id, $tutorial_array);
        if ($updated_tutorial) {
            if ($image = $request->image) {
                if ($updated_tutorial->image) {
                    @unlink($updated_tutorial->getOriginal('image'));
                }
                $path = 'uploads/' . $updated_tutorial->firm->Slug . '/tutorials/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_tutorial->image = $path . $image_new_name;

                $updated_tutorial->save();
            }
            session()->flash('success_message', 'Tutorial updated successfully');
            return redirect('/firm/tutorials/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $tutorial = $this->tutorialRep->get($id);
        if ($tutorial->image) {
            @unlink($tutorial->getOriginal('image'));
        }

        $deleted_tutorial = $this->tutorialRep->delete($id);
        if ($deleted_tutorial) {
            session()->flash('success_message', 'Tutorial deleted successfully');
            return redirect('/firm/tutorials/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
