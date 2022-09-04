<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use Storage;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =banner::all();
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
        return view ('admin.banner',$result);
    }
    public function manage_banner(Request $request, $id='')
    {
        if ($id>0){
            $arr = banner::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['image']=$arr['0']->image;
            $result['btn_text']=$arr['0']->btn_text;
            $result['btn_link']=$arr['0']->btn_link;
            $result['stauts']=$arr['0']->status;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']=$arr['0']->is_home;
            // if($arr['0']->is_home==1){
            //     $result['is_home_selected']='checked';
            // }else{
            //     $result['is_home_selected']='';
            // }
            

        }else{
            $result['id']=0;
            $result['image']='';
            $result['btn_text']="";
            $result['btn_link']="";
            // $result['is_home']='';
            // $result['is_home_selected']='';
        }
        
        return view ('admin.manage_banner',$result);
    }
    

    public function manage_banner_process(Request $request)
    {
        
        $request->validate([
            'image'=>'required|mimes:jpeg,jpg,png',
        ]);
        
        if ($request->post('id')>0){
            $model = banner::find($request->post('id'));
            $msg = "banner Updated";
        }else{
            $model = new banner();
            $msg = "banner Inserted";
        }
        
        if($request->hasfile('image')){
            if ($request->post('id')>0){
                If (Storage::exists('/public/media/banner/'.$model->image)){
                    Storage::delete('/public/media/banner/'.$model->image);
                }
            }
            $image= $request->file('image');
            $ext = $image->extension();
            $image_name="banner_".time().'.'.$ext;
            $image->storeAs('/public/media/banner',$image_name);
            $model->image=$image_name;
        }
        
        // $model->is_home=0;
        // if ($request->post('is_home')!==null){
        //     $model->is_home=1;
        // }
        $model->btn_text=$request->post('btn_text');
        $model->btn_link=$request->post('btn_link');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/banner');
    }

    public function delete(Request $request,$id){
        $model = banner::find($id);
        If (Storage::exists('/public/media/banner/'.$model->image)){
            Storage::delete('/public/media/banner/'.$model->image);
        }
        $model->delete();
        $request->session()->flash('message','banner Deleted');
        return redirect('admin/banner');
    }
    public function status(Request $request,$status,$id){
        $model = banner::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/banner');
    }
}
