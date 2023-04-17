<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Trainee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Image;
use Storage;
use File;
class TraineeController extends Controller
{
    
    public function index()
    {
        $trainees = Trainee::paginate(20);

        return view('trainee.index',compact('trainees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view("trainee.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $trainee = new Trainee();
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:instructors,email,',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048',
        ],[
            'name.required' => 'Name is must.',
            'name.min' => 'Name must have 5 char.',
            'email.required' => 'Email is must.',
            'password.required' => 'Password is must.',
           
        ]);
        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }
       
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $trainee->profile_picture = $filename;
            $path = storage_path('app/public/trainees/').$filename;
            Image::make($image)->save($path);
        }
        $trainee->name = $request->name;
        $trainee->lastname = $request->lastname;
        $trainee->email = $request->email;
        $trainee->password = Hash::make($request->password);
        
        $trainee->save();
        return redirect()->route('trainee.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainee $trainee)
    {
       return view('trainee.show',['trainee' => $trainee]);
    }

	 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainee $trainee)
    {
        return view('trainee.edit',['trainee'=> $trainee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trainee $trainee)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:trainees,email,' . $trainee->id,
        'password' => 'nullable|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|max:2048',
    ]);

    if($validate->fails()){
        return back()->withErrors($validate->errors())->withInput();
        }
    $trainee->name = $request->name;
    $trainee->lastname = $request->lastname;
    $trainee->email = $request->email;
    if ($request->password) {
        $trainee->password = Hash::make($request->password);
    }
    // Handle profile image upload
    if ($request->hasFile('profile_picture')) {
        if ($trainee->profile_picture) {
            Storage::delete('public/trainees/' . $trainee->profile_picture);
        }
        $image = $request->file('profile_picture');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $instructor->profile_picture = $filename;
        $path = storage_path('app/public/trainees/').$filename;
        Image::make($image)->save($path);
    }

    

    $trainee->save();

    return redirect()->route('trainee.show', $trainee)->with('success', 'trainee updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainee $trainee)
    {
        //Check if the instructor has a profile image and delete it from storage if they do
        if ($trainee->profile_image && Storage::exists($admin->profile_picture)) {
            Storage::delete('public/trainees/' . $trainee->profile_image);
        }
    
        //Delete the instructor from the database
        $trainee->delete();
    
        return redirect()->route('trainee.index')->with('success', 'trainee deleted successfully!');
    }
}
