<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Image;
use Storage;
use File;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate(15);
        return response()->json($admins);
        return view('admin.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view("admin.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->middleware('auth');
        $user = $request->user();   
        
        // if (!$user->is_admin) {
        //     abort(403, 'Unauthorized action.');
        // }  
        

        $admin = new Admin();
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'email' => 'required|string|email|max:255|unique:admins,email,',
            'password' => 'required|string|min:8|confirmed',
            'department' => 'nullable|string|max:255',
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
            $admin->profile_picture = $filename;
            $path = storage_path('app/public/admins/').$filename;
            Image::make($image)->save($path);
        }
        $admin->name = $request->name;
        $admin->department = $request->department;
        $admin->email = $request->email;
        $admin->password = $request->password;
        $admin->password = Hash::make($request->password); 
       
        $admin->save();
        $admin_user = User::create([
            'name' => $request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        $token = $admin_user->createToken('instructor_token')->plainTextToken;
       
        return redirect()->route('admin.index')->with('access_token',$token);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
       return view('admin.show',['admin' => $admin]);
    }

	 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('admin.edit',['admin'=> $admin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
{
    $this->middleware('auth');
    $user = $request->user();   
    
    if (!$user->is_admin) {
        abort(403, 'Unauthorized action.');
    }  
    $validate = Validator::make($request->all(), [
        'name' => 'required|string|min:5',
        'email' => 'required|string|email|max:255|unique:admin,email,' . $admin->id,
        'password' => 'required|string|min:8|confirmed',
        'department' => 'nullable|string|max:255',
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
 if ($request->password) {
        $admin->password = Hash::make($request->password);
    }
    // Update the instructor with the new data
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->department = $request->department;
   
    // Handle profile image upload
    if ($request->hasFile('profile_picture')) {
        // Delete the previous profile image if it exists
        if ($admin->profile_picture) {
            Storage::delete('public/admins/' . $admin->profile_picture);
        }

        $profileImage = $request->file('profile_picture');
        $imageName = time() . '_' . $profileImage->getClientOriginalName();
        $profileImage->storeAs('public/admins/', $imageName);
        $admin->profile_picture = $imageName;
    }

    $admin->save();
    $user->name = $request->name;
    $user->email = $request->email;
   
    return redirect()->route('admin.show', $admin)->with('success', 'Admin updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        // Check if the instructor has a profile image and delete it from storage if they do
        if ($admin->profile_picture && Storage::exists($admin->profile_picture)) {
            Storage::delete('public/admins/' . $admin->profile_image);
        }
    
        // Delete the instructor from the database
        $admin->delete();
    
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully!');
    }
}
