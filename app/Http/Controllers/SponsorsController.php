<?php

namespace App\Http\Controllers;

use App\Social;
use App\Sponsor;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsor::where('school_id', $this->schoolId)->get();

        return view('sponsors.show', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sponsors.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'bio' => 'required',
            'email' => 'required|email|unique:sponsors,email',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $photo = "";
        $logo = "";
        $logo2 = "";

        if(Input::file('photo') != null){
            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('photo')->getClientOriginalExtension();
            $photo = rand(1111, 9999) . '.' . $extension;
            Input::file('photo')->move($destinationPath, $photo);
        }

        if(Input::file('logo') != null){
            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('logo')->getClientOriginalExtension();
            $logo = rand(1111, 9999) . '.' . $extension;
            Input::file('logo')->move($destinationPath, $logo);
        }

        if(Input::file('logo2') != null){
            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('logo2')->getClientOriginalExtension();
            $logo2 = rand(1111, 9999) . '.' . $extension;
            Input::file('logo2')->move($destinationPath, $logo2);
        }

        $sponsor = Sponsor::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'logo' => $logo == '' ? '' : asset('uploads/sponsors/'.$logo),
            'logo2' => $logo2 == '' ? '' :asset('uploads/sponsors/'.$logo2),
            'photo' => $photo == '' ? '' :asset('uploads/sponsors/'.$photo),
            'address' => $request->input('address'),
            'school_id' => $this->schoolId,
            'color' => $request->input('color'),
            'color2' => $request->input('color2'),
            'color3' => $request->input('color3'),
            'video' => $request->input('video'),
            'tagline' => $request->input('tagline'),
            'bio' => $request->input('bio'),
            'url' => $request->input('url'),
            'order' => $request->input('order')
        ]);

        Social::create([
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'socialLinks_id' => $sponsor->id,
            'socialLinks_type' => 'App\Sponsor',
        ]);

        return redirect('/sponsors')->with('success', 'Sponsor Added Successfully');
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
        $sponsor = Sponsor::where('id', $id)->first();
        $social = Social::where('socialLinks_id', $id)->where('socialLinks_type', 'App\Sponsor')->first();

        return view('sponsors.update', compact('sponsor', 'social'));
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
        $this->validate($request, [
            'name' => 'required|max:255',
            'bio' => 'required',
            'email' => 'required|email|unique:sponsors,email,'.$id,
            'address' => 'required',
            'phone' => 'required'
        ]);

        $photo = "";
        $logo = "";
        $logo2 = "";

        $checkImages = Sponsor::where('id', $id)->first();

        //if user added new image while updating
        if(Input::file('photo') != null){

            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('photo')->getClientOriginalExtension();
            $photo = rand(1111, 9999) . '.' . $extension;
            Input::file('photo')->move($destinationPath, $photo);
            $photo = asset('uploads/sponsors/'.$photo);
        }

        //check if image is already in db
        else{
            if($checkImages->photo != null){
                $photo = $checkImages->photo;
            }
            else{
                $photo = null;
            }
        }

        if(Input::file('logo2') != null){
            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('logo2')->getClientOriginalExtension();
            $logo2 = rand(1111, 9999) . '.' . $extension;
            Input::file('logo2')->move($destinationPath, $logo2);
            $logo2 = asset('uploads/sponsors/'.$logo2);
        }
        //check if image is already in db
        else{
            if($checkImages->logo2 != null){
                $logo2 = $checkImages->logo2;
            }
            else{
                $logo2 = null;
            }
        }

        if (Input::file('logo') != null) {

            $destinationPath = 'uploads/sponsors'; // upload path
            $extension = Input::file('logo')->getClientOriginalExtension();
            $logo = rand(1111, 9999) . '.' . $extension;
            Input::file('logo')->move($destinationPath, $logo);

            $logo = asset('uploads/sponsors/'.$logo);

        }
        //check if image is already in db
        else{
            if($checkImages->logo != null){
                $logo = $checkImages->logo;
            }
            else{
                $logo = null;
            }
        }

        Sponsor::find($id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'logo' => $logo,
            'logo2' => $logo2,
            'photo' => $photo,
            'address' => $request->input('address'),
            'school_id' => $this->schoolId,
            'color' => $request->input('color'),
            'color2' => $request->input('color2'),
            'color3' => $request->input('color3'),
            'video' => $request->input('video'),
            'tagline' => $request->input('tagline'),
            'bio' => $request->input('bio'),
            'url' => $request->input('website'),
            'order' => $request->input('order')
        ]);

        Social::where('socialLinks_id', $id)->where('socialLinks_type', 'App\Sponsor')->update([
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'socialLinks_id' => $id,
            'socialLinks_type' => 'App\Sponsor',
        ]);

        return redirect('/sponsors')->with('success', 'Sponsor Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::find($id);

        $social = Social::where('socialLinks_id', $id)->where('socialLinks_type', 'App\Sponsor')->first();

        if ($social){
            $social->delete();
        }
        $sponsor->delete();

        return redirect('/sponsors')->with('success', 'Sponsor Deleted Successfully');
    }
}
