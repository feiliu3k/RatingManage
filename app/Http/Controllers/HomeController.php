<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    public function  resetPassword(){
        return view('auth.reset');
    }

    public function  changePassword(Request $request){

        $this->validate($request, [
            '_token' => 'required',
            'oldpassword' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);




        $user=Auth::user();
        $name=$user->name;
        $oldpassword=trim($request->oldpassword);
        $password=trim($request->password);
        $password_confirmation=trim($request->password_confirmation);


        $eqflag=Auth::attempt(['name' => $name, 'password' => $oldpassword]);



        if (($password==$password_confirmation) and $eqflag){
            $user->password = bcrypt($password);
            $user->save();
            Auth::logout($user);
            return redirect('logout');
        }else if($password==$password_confirmation){
            return redirect('resetpassword')
                        ->withErrors("老密码出错了！");
        }else{
            return redirect('resetpassword')
                        ->withErrors("新密码不一致！");
        }

    }



}
