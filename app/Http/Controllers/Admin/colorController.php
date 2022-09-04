<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\color;
use Illuminate\Http\Request;

class colorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =color::all();
        return view ('admin.color',$result);
    }
    public function manage_color(Request $request, $id='')
    {
        if ($id>0){
            $arr = color::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['color']=$arr['0']->color;
            
        }else{
            $result['id']=0;
            $result['color']='';
        }
        
        return view ('admin.manage_color',$result);
    }
    

    public function manage_color_process(Request $request)
    {

        $request->validate([
            'color'=>'required',
            'color'=>'required|unique:colors,color,'.$request->post('id'),
        ]);
        
        if ($request->post('id')>0){
            $model = color::find($request->post('id'));
            $msg = "color Updated";
        }else{
            $model = new color();
            $msg = "color Inserted";
        }
        
        $model->color = $request->post('color');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/color');
    }

    public function delete(Request $request,$id){
        $model = color::find($id);
        $model->delete();
        $request->session()->flash('message','color Deleted');
        return redirect('admin/color');
    }
    public function status(Request $request,$status,$id){
        $model = color::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/color');
    }

    }
