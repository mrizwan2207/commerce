<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\brand;
use Illuminate\Http\Request;
use Storage;

class brandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =brand::all();
        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        // echo "<br>".$result['collection'];
        // echo "<br>".$result['collection'][0];
        // echo "<br>".$result['collection'][0]['connection:protec'];

        // echo "<br>";
        // $test['color'] =array("red","yellow","blue","green");
        // echo "<pre>";
        // print_r($test);
        // echo "</pre>";
        // die;
        return view ('admin.brand',$result);
    }
    public function manage_brand(Request $request, $id='')
    {
        if ($id>0){
            $arr = brand::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['brand']=$arr['0']->brand;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']=$arr['0']->is_home;
            if($arr['0']->is_home==1){
                $result['is_home_selected']='checked';
            }else{
                $result['is_home_selected']='';
            }
            $result['image']=$arr['0']->image;

        }else{
            $result['id']=0;
            $result['brand']='';
            $result['image']='';
            $result['is_home']='';
            $result['is_home_selected']='';
        }
        
        return view ('admin.manage_brand',$result);
    }
    

    public function manage_brand_process(Request $request)
    {
        $image_validation = "mimes:jpeg,jpg,png";
        $request->validate([
            'brand'=>'required',
            'brand'=>'required|unique:brands,brand,'.$request->post('id'),
            'image'=>$image_validation,
        ]);
        
        if ($request->post('id')>0){
            $model = brand::find($request->post('id'));
            $msg = "brand Updated";
        }else{
            $model = new brand();
            $msg = "brand Inserted";
        }
        
        if($request->hasfile('image')){
            if ($request->post('id')>0){
                If (Storage::exists('/public/media/brand/'.$model->image)){
                    Storage::delete('/public/media/brand/'.$model->image);
                }
            }
            $image= $request->file('image');
            $ext = $image->extension();
            $image_name="brand_".time().$request->post('brand').'.'.$ext;
            $image->storeAs('/public/media/brand',$image_name);
            $model->image=$image_name;
        }
        $model->brand = $request->post('brand');
        $model->is_home=0;
        if ($request->post('is_home')!==null){
            $model->is_home=1;
        }
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/brand');
    }

    public function delete(Request $request,$id){
        $model = brand::find($id);
        If (Storage::exists('/public/media/brand/'.$model->image)){
            Storage::delete('/public/media/brand/'.$model->image);
        }
        $model->delete();
        $request->session()->flash('message','brand Deleted');
        return redirect('admin/brand');
    }
    public function status(Request $request,$status,$id){
        $model = brand::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/brand');
    }
}
