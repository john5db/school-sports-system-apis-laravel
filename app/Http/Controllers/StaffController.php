<?php

namespace App\Http\Controllers;

use App\School;
use App\Season;
use App\Staff;
use App\User;
use App\Year;
use App\Roster;
use App\RosterStaff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Filesystem\Cloud as FileSystems;
use League\Flysystem\File;

class StaffController extends Controller
{

    protected $filesystem;
    protected $basePath;
    /**
    public function __construct($basePath = "/", FileSystems $filesystem)
    {

    if(Schema::hasTable('schools')){
    $school = School::firstOrCreate([
    'school_email' => 'admin@gmail.com',
    'name' => 'Admin',
    'school_logo' => 'https://lh3.googleusercontent.com/YGqr3CRLm45jMF8eM8eQxc1VSERDTyzkv1CIng0qjcenJZxqV5DBgH5xlRTawnqNPcOp=w300'

    ]);

    $user = User::firstOrCreate([
    'name' => 'Admin',
    'email' => 'admin@gmail.com',
    'school_id' => $school->id
    ]);

    $user->password = bcrypt('admin');
    $user->save();

    $seasons = Season::where('name', 'Fall')->first();
    $now = Carbon::now('utc')->toDateTimeString();
    if(!($seasons)){
    Season::insert([
    ['name' => 'Fall', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'Spring', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'Winter', 'created_at' => $now, 'updated_at' => $now],
    ]);
    }
    }

    $this->basePath = $basePath;
    $this->filesystem = $filesystem;
    }
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school_id = Auth::user()->school_id;
        $staff = Staff::where('school_id', $school_id)->get();
        $year = '2016';

        return view('staff.show', compact('staff', 'school_id', 'year'));
    }

    /**
     * show staff for particular year
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yearStaff(Request $request)
    {
        $year = $request->input('year');
        $school_id = Auth::user()->school_id;
        $staff = Staff::where('school_id', $school_id)->get();

        return view('staff.show', compact('staff', 'school_id', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rosters = Roster::lists('name', 'id');
        $seasons = Season::lists('name', 'id');
        return view('staff.add', compact('seasons', 'rosters'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|max:15',
            'photo' => 'required'
        ]);

        $json = json_decode(Input::get('image_scale'), true);
        $fileName = "";
        if(Input::file('photo') != null){

            $extension = Input::file('photo')->getClientOriginalExtension();
            $fileName = rand(1111, 9999) . '.' . $extension;

            $destinationPath = "/uploads/staff/"; // upload path

            $img = Image::make(Input::file('photo'));
            $img->widen((int) ($img->width() * $json['scale']));
            $img->crop((int)$json['w'], (int)$json['h'], (int)$json['x'], (int)$json['y']);
            $img->encode();

            $filesystem = Storage::disk('s3');
            $filesystem->put($destinationPath . $fileName, $img->__toString(), 'public');
        }


        $staff = Staff::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
            'title' => $request->input('title'),
            'website' => $request->input('website'),
            'school_id' => $schoolId,
            'photo' => $fileName == ""? null : 'https://s3-' . env('S3_REGION','') . ".amazonaws.com/" . env('S3_BUCKET','') . $destinationPath . $fileName,
            'season_id' => $request->input('season_id')
        ]);
        if (true)
        {
            $staff->rosters()->attach(array_values($request->input('roster_id')));
        }

        $year = Year::create([
            'year' => date("Y"),
            'year_id' => $staff->id,
            'year_type' => 'App\Staff'
        ]);

        Session::flash('success', 'staff added successfully');
        return redirect('/staff');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        $seasons = Season::lists('name', 'id');
        $rosters = Roster::lists('name', 'id');
        $selected = RosterStaff::where('staff_id', '=', $id)->lists('roster_id');
        $rostersTags = [];
        foreach ($selected as $select) { $rostersTags[] = $select;
        }

        return view('staff.update', compact('staff', 'seasons', 'rosters', 'selected', 'rostersTags' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $file = Input::all();
        $rules = array();
        $schoolId = Auth::user()->school_id;
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //setting errors message
            Session::flash('message', $validator->errors()->all());

            // send back to the page with the input data and errors
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else
        {
            $json = json_decode(Input::get('image_scale'), true);
            $fileName = "";
            if (Input::file('photo') != null) {
                $filesystem = Storage::disk('s3');
                $staff =  Staff::where('id', $id)->get();
                $imagePath = explode(".amazonaws.com/" . env('S3_BUCKET',''),$staff->photo);
                $filesystem->delete(end($imagePath));

                $extension = Input::file('photo')->getClientOriginalExtension();
                $fileName = rand(1111, 9999) . '.' . $extension;

                $destinationPath = "/uploads/staff/"; // upload path

                $img = Image::make(Input::file('photo'));
                $img->widen((int) ($img->width() * $json['scale']));
                $img->crop((int)$json['w'], (int)$json['h'], (int)$json['x'], (int)$json['y']);
                $img->encode();

                $filesystem = Storage::disk('s3');
                $filesystem->put($destinationPath . $fileName, $img->__toString(), 'public');
                //update
                Staff::where('id', $id)->update(array('name' => $file['name'], 'email' => $file['email'],
                    'phone' => $file['phone'], 'description' => $file['description'], 'title' => $file['title'],
                    'description' => $file['description'], 'school_id' => $schoolId,
                    'photo' => $fileName == ""? null : 'https://s3-' . env('S3_REGION','') . ".amazonaws.com/" . env('S3_BUCKET','') . $destinationPath . $fileName ));
            } else {
                Staff::where('id', $id)->update(array('name' => $file['name'], 'email' => $file['email'],
                    'phone' => $file['phone'], 'description' => $file['description'], 'title' => $file['title'],
                    'description' => $file['description'], 'school_id' => $schoolId,   ));
            }
            $staff = Staff::where('id', '=', $id)->first();

            if (isset($file['roster_id']))
            {
                $staff->rosters()->sync(array_values($file['roster_id']));
            }
            else
            {
                $staff->rosters()->sync([]);
            }

            Session::flash('success', 'Updated successfully');
            return Redirect::back();


        }
    }



    /**

    public function update(Request $request, $id)
    {$fileName == ""? $fileNameOld:
    $schoolId = Auth::user()->school_id;

    $this->validate($request, [
    'name' => 'required',
    'email' => 'required|email|unique:staff,email,'.$id,
    'year' => 'required',
    'phone' => 'required|max:15'
    ]);

    $fileName = "";
    if(Input::file('photo') != null){
    $destinationPath = 'uploads/staff'; // upload path
    $extension = Input::file('photo')->getClientOriginalExtension();
    $fileName = rand(1111, 9999) . '.' . $extension;
    Input::file('photo')->move($destinationPath, $fileName);
    }

    $image = Staff::find($id);
    $fileNameOld= "";
    if($image->photo){
    $fileNameOld = $image->photo;
    }
    $staff = Staff::where('id', $id)->update([
    'name' => $request->input('name'),
    'email' => $request->input('email'),
    'phone' => $request->input('phone'),
    'description' => $request->input('description'),
    'title' => $request->input('title'),
    'website' => $request->input('website'),
    'school_id' => $schoolId,
    'photo' => $fileName == ""? $fileNameOld: asset('/uploads/staff/'.$fileName),
    'season_id' => $request->input('season_id')
    ]);

    $year = Year::where('year_id', $id)->where('year_type', 'App\Staff')->update([
    'year' => $request->input('year'),
    'year_id' => $id,
    'year_type' => 'App\Staff'
    ]);
    Session::flash('success', 'staff updated successfully');
    return redirect('/staff');
    }


     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);
        $filesystem = Storage::disk('s3');
        $imagePath = explode(".amazonaws.com/" . env('S3_BUCKET',''),$staff->photo);
        $filesystem->delete(end($imagePath));


        $staff->delete();

        return redirect('/staff')->with('success', 'Staff deleted successfully');
    }
}