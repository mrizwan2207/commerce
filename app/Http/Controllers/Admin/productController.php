<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$result['collection'] =product::all();
        // $result['collection'] = DB::table('categories')
        // ->join('products','products.category_id','categories.id')
        // ->select('products.*','category_name')
        // ->get();

        // $result['collection'] = DB::table('products')
        // ->join('categories','products.category_id','categories.id')
        // ->leftjoin('brands','products.brand','brands.id')
        // ->select('products.*','category_name','brands.brand')
        // ->get();

        $result['collection'] = DB::table('products')
        ->join('categories','products.category_id','=','categories.id')
        ->leftjoin('brands','products.brand_id','=','brands.id')
        ->select('products.*','category_name','brands.brand')
        ->get();
        
        return view ('admin.product',$result);
    }
    public function manage_product(Request $request, $id='')
    {
        
        if ($id>0){
            $arr = product::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->name;
            $result['image']=$arr['0']->image;
            $result['slug']=$arr['0']->slug;
            $result['category_id']=$arr['0']->category_id;
            $result['brand_id']=$arr['0']->brand_id;
            $result['model']=$arr['0']->model;
            $result['short_desc']=$arr['0']->short_desc;
            $result['desc']=$arr['0']->desc;
            $result['keywords']=$arr['0']->keywords;
            $result['technical_specification']=$arr['0']->technical_specification;
            $result['uses']=$arr['0']->uses;
            $result['warranty']=$arr['0']->warranty;
            $result['lead_time']=$arr['0']->lead_time;
            $result['tax_id']=$arr['0']->tax_id;
            $result['is_promo']=$arr['0']->is_promo;
            $result['is_featured']=$arr['0']->is_featured;
            $result['is_discounted']=$arr['0']->is_discounted;
            $result['is_tranding']=$arr['0']->is_tranding;

            $productImageArr=DB::table('product_images')->where(['product_id'=>$id])->get();
            $productAttrArr=DB::table('product_attr')->where(['product_id'=>$id])->get();
            
            if (!isset($productImageArr[0])){
                $result['productImageArr'][0]['id']='';
                $result['productImageArr'][0]['product_id']='';
                $result['productImageArr'][0]['prd_image']='';
            }
            else{
                $result['productImageArr']=$productImageArr;
            }
            if (!isset($productAttrArr[0])){
                $result['productAttrArr'][0]['id']='';
                $result['productAttrArr'][0]['product_id']='';
                $result['productAttrArr'][0]['sku']='';
                $result['productAttrArr'][0]['attr_image']='';
                $result['productAttrArr'][0]['mrp']='';
                $result['productAttrArr'][0]['price']='';
                $result['productAttrArr'][0]['qty']='';
                $result['productAttrArr'][0]['size_id']='';
                $result['productAttrArr'][0]['color_id']='';
            }
            else{
                $result['productAttrArr']=$productAttrArr;
            }
            // echo '<pre>';
            // print_r($result['productImageArr']);
            // die;
        }else{
            $result['id']=0;
            $result['name']='';
            $result['image']='';
            $result['slug']='';
            $result['category_id']='';
            $result['brand_id']='';
            $result['model']='';
            $result['short_desc']='';
            $result['desc']='';
            $result['keywords']='';
            $result['technical_specification']='';
            $result['uses']='';
            $result['warranty']='';
            $result['lead_time']='';
            $result['tax_id']='';
            $result['is_promo']='';
            $result['is_featured']='';
            $result['is_discounted']='';
            $result['is_tranding']='';

            $result['productImageArr'][0]['id']='';
            $result['productImageArr'][0]['product_id']='';
            $result['productImageArr'][0]['prd_image']='';
            
            $result['productAttrArr'][0]['id']='';
            $result['productAttrArr'][0]['product_id']='';
            $result['productAttrArr'][0]['sku']='';
            $result['productAttrArr'][0]['attr_image']='';
            $result['productAttrArr'][0]['mrp']='';
            $result['productAttrArr'][0]['price']='';
            $result['productAttrArr'][0]['qty']='';
            $result['productAttrArr'][0]['size_id']='';
            $result['productAttrArr'][0]['color_id']='';
            
        }
            // echo '<pre>';
            // print_r($result['productImageArr']);
            // die;
        $result['category']=DB::table('categories')->where(['status'=>1])->get();

        $result['size']=DB::table('sizes')->where(['status'=>1])->get();
        $result['color']=DB::table('colors')->where(['status'=>1])->get();
        $result['brand']=DB::table('brands')->where(['status'=>1])->get();
        $result['tax']=DB::table('taxs')->where(['status'=>1])->get();
        // echo '<pre>';
        // print_r($result);
        // die;
        return view ('admin.manage_product',$result);
    }
    

    public function manage_product_process(Request $request)
    {
        
        
        if ($request->post('id')>0){
            $image_validation = "mimes:jpeg,jpg,png";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        $request->validate([
            'name'=>'required',
            'image'=>$image_validation,
            'name'=>'required|unique:products,name,'.$request->post('id'),
            'attr_image.*'=>'mimes:jpg,jpeg,png',
            'prd_image.*'=>'mimes:jpg,jpeg,png',
            // .* is used for image array
        ]);
        
        /* Product images Start*/        
        $pimageidArr= $request->post('pimageid');
        
        /* Product Attr Start*/        
        $paidArr= $request->post('paid');
        $skuArr= $request->post('sku');
        $mrpArr= $request->post('mrp');
        $priceArr= $request->post('price');
        $qtyArr= $request->post('qty');
        $size_idArr= $request->post('size_id');
        $color_idArr= $request->post('color_id');
        /*
        foreach($skuArr as $key => $val){
            $check=DB::table('product_attr')->
            where('sku','=',$skuArr[$key])->
            where('id','=',$paidArr[$key])->
            get();

            if(isset($check[0])){
                $request->session()->flash('sku_error',$skuArr[$key].' SKU already Used');
                return redirect(request()->headers->get('referer'));
            }
        }
        */
        if ($request->post('id')>0){
            $model = product::find($request->post('id'));
            $msg = "product Updated";
        }else{
            $model = new product();
            $msg = "product Inserted";
        }
        
        if($request->hasfile('image')){
            if ($request->post('id')>0){
                If (Storage::exists('/public/media/product/'.$model->image)){
                    Storage::delete('/public/media/product/'.$model->image);
                }
            }
            $image= $request->file('image');
            $ext = $image->extension();
            $image_name='product_'.time().'.'.$ext;
            $image->storeAs('/public/media/product',$image_name);
            $model->image=$image_name;
        }
        
        
        $result['id']=0;
        $model->name = $request->post('name');
        $model->slug = $request->post('slug');
        $model->category_id = $request->post('category_id');
        $model->short_desc = $request->post('short_desc');
        $model->brand_id = $request->post('brand_id');
        $model->model = $request->post('model');
        $model->desc = $request->post('desc');
        $model->keywords = $request->post('keywords');
        $model->technical_specification = $request->post('technical_specification');
        $model->uses = $request->post('uses');
        $model->warranty = $request->post('warranty');
        $model->lead_time = $request->post('lead_time');
        $model->tax_id = $request->post('tax_id');
        $model->is_promo = $request->post('is_promo');
        $model->is_featured = $request->post('is_featured');
        $model->is_discounted = $request->post('is_discounted');
        $model->is_tranding = $request->post('is_tranding');
        $model->status=1;
        $model->save();
        $savedPid = $model->id;
        
        foreach($pimageidArr as $key => $val){   
            $productImageArr=[];  // intiate with blank
            $productImageArr['product_id']=$savedPid;          
            if($request->hasfile("prd_image.$key")){
                if($pimageidArr[$key]!=''){  
                    $arrImage = DB::table('product_images')->where(['id'=>$pimageidArr[$key]])->get();
                    If (Storage::exists('/public/media/product/'.$arrImage[0]->prd_image)){
                        Storage::delete('/public/media/product/'.$arrImage[0]->prd_image);
                    }  
                } 
                $rand=rand('11111','99999');
                $prd_image=$request->file("prd_image.$key");
                $ext = $prd_image->extension();
                $image_name='prd_image_'.$rand.'.'.$ext;
                $request->file("prd_image.$key")->storeAs('/public/media/product',$image_name);
                $productImageArr['prd_image']=$image_name;           
            }

            if($pimageidArr[$key]!=''){
                DB::table('product_images')->where(['id'=>$pimageidArr[$key]])->update($productImageArr);
            }elseif($request->hasfile("prd_image.$key")){
                DB::table('product_images')->insert($productImageArr);
            }
            
        }
   
    //  echo "<pre>";
    // print_r ($skuArr);
    // die;
       if ($skuArr[0]!=null){
        foreach($skuArr as $key => $val){
            $productAttrArr=[]; // intiate with blank
            $productAttrArr['product_id']=$savedPid;
            $productAttrArr['sku']=$skuArr[$key];
            $productAttrArr['mrp']=$mrpArr[$key];
            $productAttrArr['price']=$priceArr[$key];
            $productAttrArr['qty']=$qtyArr[$key];
            if ($size_idArr[$key] == ''){
                $productAttrArr['size_id']=0;
            }else{
                $productAttrArr['size_id']=$size_idArr[$key];
            }
            if ($color_idArr[$key] == ''){
                $productAttrArr['color_id']=0;
            }else{
                $productAttrArr['color_id']=$color_idArr[$key];
            }
           
            //$productAttrArr['attr_image']='test';
            if($request->hasfile("attr_image.$key")){
                if($paidArr[$key]!=''){
                    $arrImage = DB::table('product_attr')->where(['id'=>$paidArr[$key]])->get();
                    If (Storage::exists('/public/media/product/'.$arrImage[0]->attr_image)){
                        Storage::delete('/public/media/product/'.$arrImage[0]->attr_image);
                    }
                }
                $rand=rand('11111','99999');
                $attr_image=$request->file("attr_image.$key");
                $ext = $attr_image->extension();
                $image_name='attr_image_'.$rand.'.'.$ext;
                $request->file("attr_image.$key")->storeAs('/public/media/product',$image_name);
                $productAttrArr['attr_image']=$image_name;
            }

            if($paidArr[$key]!=''){
                DB::table('product_attr')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
            }else{
                DB::table('product_attr')->insert($productAttrArr);
            }
        }
    }
      
        /**/
        $request->session()->flash('message',$msg);
        return redirect('admin/product');
        
    }

    public function delete(Request $request,$id){
        $model = product::find($id);
        If (Storage::exists('/public/media/product/'.$model->image)){
            Storage::delete('/public/media/product/'.$model->image);
        }
        $model->delete();
        $request->session()->flash('message','product Deleted');
        return redirect('admin/product');
    }
    public function status(Request $request,$status,$id){
        $model = product::find($id);
        $model->status = $status;
        $model->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/product');
    }

    public function product_image_delete(Request $request,$pimageid,$id){
        $arrImage = DB::table('product_images')->where(['id'=>$pimageid])->get();
        If (Storage::exists('/public/media/product/'.$arrImage[0]->prd_image)){
            Storage::delete('/public/media/product/'.$arrImage[0]->prd_image);
        }
        DB::table('product_images')->where(['id'=>$pimageid])->delete();
        return redirect('admin/product/manage_product/'.$id);        
    }
    public function product_attr_delete(Request $request,$paid,$id){
        $arrImage = DB::table('product_attr')->where(['id'=>$paid])->get();
        If (Storage::exists('/public/media/product/'.$arrImage[0]->attr_image)){
            Storage::delete('/public/media/product/'.$arrImage[0]->attr_image);
        }
        
        DB::table('product_attr')->where(['id'=>$paid])->delete();
        return redirect('admin/product/manage_product/'.$id);
    }
    
    
}
