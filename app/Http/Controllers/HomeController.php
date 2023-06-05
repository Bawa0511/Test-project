<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function changepassword()
    {
        return view('change_password');
    }
    
    public function updatepassword(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();

        $validator = Validator::make($request->all(), [
            'new_password' => 'required_with:current_password|nullable|min:8',
            'confirm_password' => 'required_with:current_password|nullable|min:8|same:new_password',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }
        
        if(!empty($request->new_password) || !empty($request->confirm_password))
        {
            if(!Hash::check($request->current_password,$user->password))
            {
                return response()->json([
                    'status' => 401,
                    'message' => 'Password not match'
                ]);
            }
            $user->password=Hash::make($request->new_password);
        }
        
        if ($user->save()) {
            session()->flash('message', "User Updated Successfully");
            return response()->json([
                'status' => 200,
                'message' =>"User Updated Successfully"
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Something Wrong. Try Again.'
            ]);
        }
        
    }

    
}
