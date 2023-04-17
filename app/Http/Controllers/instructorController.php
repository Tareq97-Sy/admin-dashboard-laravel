<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\instructor;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Image;
use Storage;
use File;
class instructorController extends Controller
{
    
    public function index()
    {
        $instructors = instructor::paginate(20);
        //return instructor::all();
        //return response()->json( $instructors);
       
        return view('instructor.index',compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view("instructor.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->middleware('auth');
        // $user = $request->user();   
        
        // if (!$user->is_admin) {
        //     abort(403, 'Unauthorized action.');
        // }       
       $instructor = new instructor();
       
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'email' => 'required|string|email|max:255|unique:instructors,email,',
            'department' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048',
        ],[
            'name.required' => 'Name is must.',
            'name.min' => 'Name must have 5 char.',
            'email.required' => 'Email is must.',
            'password.required' => 'Password is must.',
            'password.confirmed' => 'Password is not match.',
        ]);
        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }
   
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $instructor->profile_picture = $filename;
            $path = storage_path('app/public/instructors/').$filename;
            Image::make($image)->save($path);
        }
        $instructor->name = $request->name;
        $instructor->department = $request->department;
        $instructor->email = $request->email;
        $instructor->biography = $request->biography;
        $instructor->phone = $request->phone;
        $instructor->password = Hash::make($request->password); 
        $instructor->save();
        $instructor_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'is_instructor' => true,
        ]);

        $token = $instructor_user->createToken('instructor_token')->plainTextToken;
        return redirect()->route('instructor.index')->with('access_token',$token);
   
       
    // response()->json([
    //     'access_token' => $token,
    //     'token_type' => 'Bearer',
    // ]);
     }

    /**
     * Display the specified resource.
     */
    public function show(instructor $instructor)
    {
       return view('instructor.show',['instructor' => $instructor]);
    }

	 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(instructor $instructor)
    {
        return view('instructor.edit',['instructor'=> $instructor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:instructors,email,' . $instructor->id,
        'password' => 'nullable|string|min:8|confirmed',
        'department' => 'required|string|max:255',
        'profile_picture' => 'nullable|image|max:2048',
        'biography' => 'nullable|string',
    ]);

    // Update the instructor with the new data
    $instructor->name = $request->name;
    $instructor->email = $request->email;
    if ($request->password) {
        $instructor->password = Hash::make($request->password);
    }
    $instructor->department = $request->department;
    $instructor->biography = $request->biography;

    // Handle profile image upload
    if ($request->hasFile('profile_picture')) {
        // Delete the previous profile image if it exists
        if ($instructor->profile_picture) {
            Storage::delete('public/instructors/' . $instructor->profile_picture);
        }

        $profileImage = $request->file('profile_picture');
        $imageName = time() . '_' . $profileImage->getClientOriginalName();
        $profileImage->storeAs('public/instructors/', $imageName);
        $instructor->profile_picture = $imageName;
    }

    $instructor->save();

    return redirect()->route('instructor.show', $instructor)->with('success', 'Instructor updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        // Check if the instructor has a profile image and delete it from storage if they do
        if ($instructor->profile_image && Storage::exists($admin->profile_picture)) {
            Storage::delete('public/instructors/' . $instructor->profile_image);
        }
    
        // Delete the instructor from the database
        $instructor->delete();
    
        return redirect()->route('instructor.index')->with('success', 'Instructor deleted successfully!');
    }
}
