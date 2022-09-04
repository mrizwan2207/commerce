<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\coupon;
use Illuminate\Http\Request;

class couponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =coupon::all();
        return view ('admin.coupon',$result);
    }
    public function manage_coupon(Request $request, $id='')
    {
        if ($id>0){
            $arr = coupon::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['title']=$arr['0']->title;
            $result['code']=$arr['0']->code;
            $result['value']=$arr['0']->value;
            $result['type']=$arr['0']->type;
            $result['min_order_amount']=$arr['0']->min_order_amount;
            $result['is_one_time']=$arr['0']->is_one_time;
            
        }else{
            $result['id']=0;
            $result['title']='';
            $result['code']='';
            $result['value']='';
            $result['type']='';
            $result['min_order_amount']='';
            $result['is_one_time']='';
            
        }
        
        return view ('admin.manage_coupon',$result);
    }
    

    public function manage_coupon_process(Request $request)
    {
       
        $request->validate([
            'title'=>'required',
            'code'=>'required|unique:coupons,code,'.$request->post('id'),
        ]);
       
        if ($request->post('id')>0){
            $model = coupon::find($request->post('id'));
            $msg = "coupon Updated";
        }else{
            $model = new coupon();
            $msg = "coupon Inserted";
        }
        
        $model->title = $request->post('title');
        $model->code = $request->post('code');
        $model->value = $request->post('value');
        $model->type = $request->post('type');
        $model->min_order_amount = $request->post('min_order_amount');
        $model->is_one_time = $request->post('is_one_time');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/coupon');
    }

    public function delete(Request $request,$id){
        $model = coupon::find($id);
        $model->delete();
        $request->session()->flash('message','coupon Deleted');
        return redirect('admin/coupon');   
    }

    public function status(Request $request,$status,$id){
        $model = coupon::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/coupon');
    }
    
}
