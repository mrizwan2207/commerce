<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['collection'] =category::all();
        return view ('admin.category',$result);
    }
    public function manage_category(Request $request, $id='')
    {
        if ($id>0){
            $arr = category::where(['id'=>$id])->get();
            // $id=$arr['0']->id;
            // $category_name=$arr['0']->category_name;
            // $category_slug=$arr['0']->category_slug;
            $result['id']=$arr['0']->id;
            $result['category_name']=$arr['0']->category_name;
            $result['category_slug']=$arr['0']->category_slug;
            $result['parent_category_id']=$arr['0']->parent_category_id;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']=$arr['0']->is_home;
            if($arr['0']->is_home==1){
                $result['is_home_selected']='checked';
            }else{
                $result['is_home_selected']='';
            }
            $result['category_image']=$arr['0']->category_image;
            
        }else{
            $result['id']=0;
            $result['category_name']='';
            $result['category_slug']='';
            $result['parent_category_id']='';
            $result['is_home']='';
            $result['category_image']='';
            $result['is_home_selected']='';
        }
        $result['category']=DB::table('categories')->where(['status'=>1])->where('id','!=',$id)->get();
        return view ('admin.manage_category',$result);
    }
    

    public function manage_category_process(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
            //'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
            'category_image'=>"mimes:jpeg,jpg,png",
        ]);
        
        if ($request->post('id')>0){
            $model = category::find($request->post('id'));
            $msg = "category Updated";
        }else{
            $model = new category();
            $msg = "category Inserted";
        }
        
        $model->category_name = $request->post('category_name');
        $model->category_slug = $request->post('category_slug');
        $model->parent_category_id = $request->post('parent_category_id');
        $model->is_home=0;
        if ($request->post('is_home')!==null){
            $model->is_home=1;
        }

        if($request->hasfile('category_image')){
            if ($request->post('id')>0){
                If (Storage::exists('/public/media/category/'.$model->category_image)){
                    Storage::delete('/public/media/category/'.$model->category_image);
                }
            }
            $image= $request->file('category_image');
            $ext = $image->extension();
            $image_name='category_'.time().$request->post('category_image').'.'.$ext;
            $image->storeAs('/public/media/category',$image_name);
            $model->category_image=$image_name;
        }
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/category');
    }

    public function delete(Request $request,$id){
        $model = category::find($id);
        If (Storage::exists('/public/media/category/'.$model->category_image)){
            Storage::delete('/public/media/category/'.$model->category_image);
        }
        $model->delete();
        $request->session()->flash('message','category Deleted');
        return redirect('admin/category');
    }
    public function status(Request $request,$status,$id){
        $model = category::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/category');
    }
    
}
