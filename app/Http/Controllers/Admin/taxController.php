<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\tax;
use Illuminate\Http\Request;

class taxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =tax::all();
        return view ('admin.tax',$result);
    }
    public function manage_tax(Request $request, $id='')
    {
        if ($id>0){
            $arr = tax::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['tax']=$arr['0']->tax;
            $result['value']=$arr['0']->value;
            
        }else{
            $result['id']=0;
            $result['tax']='';
            $result['value']='';
        }
        
        return view ('admin.manage_tax',$result);
    }
    

    public function manage_tax_process(Request $request)
    {
        
        $request->validate([
            'tax'=>'required',
            'tax'=>'required|unique:taxs,tax,'.$request->post('id'),
        ]);
        
        if ($request->post('id')>0){
            $model = tax::find($request->post('id'));
            $msg = "tax Updated";
        }else{
            $model = new tax();
            $msg = "tax Inserted";
        }
        
        $model->tax = $request->post('tax');
        $model->value = $request->post('value');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/tax');
    }

    public function delete(Request $request,$id){
        $model = tax::find($id);
        $model->delete();
        $request->session()->flash('message','tax Deleted');
        return redirect('admin/tax');
    }
    public function status(Request $request,$status,$id){
        $model = tax::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/tax');
    }
}
