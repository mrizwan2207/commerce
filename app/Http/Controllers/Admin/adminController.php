<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\admin;
use Illuminate\Http\Request;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        if ($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return redirect('admin/login');
        }
        */
        return view('admin.login');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request)
    {
        //return $request->post();
        $email = $request->post('email');
        $password = $request->post('password');
        $result = admin::where(['email'=>$email,'password'=>$password])->get();
        /*
        if($result){
            if(Hash::check($request->post('password'),$result->password)){
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result['0']->id);
                return redirect('admin/dashboard');
            }else{
            $request->session()->flash('errors','please enter correct login details');
            return redirect('admin');
        }

        }else{
            $request->session()->flash('errors','please enter valid login details');
            return redirect('admin');
        }
        */
        if (isset($result['0']->id)){
            $request->session()->put('ADMIN_LOGIN',true);
            $request->session()->put('ADMIN_ID',$result['0']->id);
            return redirect('admin/dashboard');
        }else{
            $request->session()->flash('errors','please enter valid login details');
            return redirect('admin');
        }
        //echo '<pre>';
        //print_r($result);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
