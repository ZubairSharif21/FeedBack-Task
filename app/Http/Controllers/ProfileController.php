<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(){
        $user=Auth::user();
        $questions=Question::where('user_id',$user->id)->latest()->paginate(6);
        return view('front.profile',compact('user','questions'));
    }
    public function edit_profile(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'email|required',
            'password'=>'required|min:6|max:16|confirmed'
        ]);
        $user=Auth::user();
        $password=$request->input('name');
        $Update=User::where('id',$user->id)->first();
        $Update->name=$request->input('name');
        $Update->email=$request->input('email');
        $Update->password=Hash::make($password);
        $Update->save();
        return redirect()->back()->with(['success'=>'Profile Has Been Updated']);
    }
    public function delete_question($id){
         $questions=Question::where('id',$id)->first();
         $questions->delete();
        return redirect()->back()->with(['success'=>'Question Has Been Deleted']);
        }
}
