<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\size;
use Illuminate\Http\Request;

class sizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =size::all();
        return view ('admin.size',$result);
    }
    public function manage_size(Request $request, $id='')
    {
        if ($id>0){
            $arr = size::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['size']=$arr['0']->size;
            
        }else{
            $result['id']=0;
            $result['size']='';
        }
        
        return view ('admin.manage_size',$result);
    }
    

    public function manage_size_process(Request $request)
    {
        
        $request->validate([
            'size'=>'required',
            'size'=>'required|unique:sizes,size,'.$request->post('id'),
        ]);
        
        if ($request->post('id')>0){
            $model = size::find($request->post('id'));
            $msg = "size Updated";
        }else{
            $model = new size();
            $msg = "size Inserted";
        }
        
        $model->size = $request->post('size');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/size');
    }

    public function delete(Request $request,$id){
        $model = size::find($id);
        $model->delete();
        $request->session()->flash('message','size Deleted');
        return redirect('admin/size');
    }
    public function status(Request $request,$status,$id){
        $model = size::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/size');
    }
}
