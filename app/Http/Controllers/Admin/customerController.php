<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\customer;
use Illuminate\Http\Request;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =customer::all();
        return view ('admin.customer',$result);
    }
    
    public function show(Request $request, $id='')
    {
        
            $arr = customer::where(['id'=>$id])->get();
            $result['customer_list']=$arr[0];
            echo "<pre>";
            print_r( $result['customer_list']);
            die;
        return view ('admin/show_customer',$result);
    }
    public function status(Request $request,$status,$id){
        $model = customer::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/customer');
    }
}
