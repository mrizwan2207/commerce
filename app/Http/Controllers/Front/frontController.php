<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Mail;
class frontController extends Controller
{
    
    public function index(Request $request)
    {
        
        $result['home_banner'] = DB::table('banners')->where(['status'=>1])->get();

        $result['home_categories_2'] = DB::table('categories')->where(['status'=>1])->where(['is_home'=>2])->get();
        if(isset($result['home_categories_2'][0])){
            $result['home_categories_2'] = $result['home_categories_2'][0];
        }else{
            $result['home_categories_2']="";
        }
        // echo "<pre>";
        // print_r($result['home_categories_2']);
        // die;
        $result['home_categories'] = DB::table('categories')->where(['status'=>1])->where(['is_home'=>1])->get();
        // echo "<pre>";
        // print_r($result);
        // die;
        $result['home_brands'] = DB::table('brands')->where(['status'=>1])->where(['is_home'=>1])->get();
        // echo "<pre>";
        // print_r($result);
        // die;
        foreach($result['home_categories'] as $list){
            $result['home_categories_product'][$list->id] = 
                DB::table('products')->where(['status'=>1])
                ->where(['category_id'=>$list->id])
                ->get();
            foreach($result['home_categories_product'][$list->id] as $listAttr){
                $result['home_product_attr'][$listAttr->id] = 
                    DB::table('product_attr')
                    ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                    ->leftjoin('colors','colors.id','=','product_attr.color_id')
                    ->where(['product_attr.product_id'=>$listAttr->id])        
                    ->get();
                
            }
        }
        ////////// Featured Data /////////
        $result['home_featured_product'][$list->id] = 
                DB::table('products')->where(['status'=>1])
                ->where(['is_featured'=>1])
                ->get();
        foreach($result['home_featured_product'][$list->id] as $listAttr){
            $result['home_featured_product_attr'][$listAttr->id] = 
                DB::table('product_attr')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id'=>$listAttr->id])        
                ->get();
        }

        ////////// Tranding Data /////////
        $result['home_tranding_product'][$list->id] = 
                DB::table('products')->where(['status'=>1])
                ->where(['is_tranding'=>1])
                ->get();
        foreach($result['home_tranding_product'][$list->id] as $listAttr){
            $result['home_tranding_product_attr'][$listAttr->id] = 
                DB::table('product_attr')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id'=>$listAttr->id])        
                ->get();
        }

        ////////// Discounted Data /////////
        $result['home_discounted_product'][$list->id] = 
                DB::table('products')->where(['status'=>1])
                ->where(['is_discounted'=>1])
                ->get();
        foreach($result['home_discounted_product'][$list->id] as $listAttr){
            $result['home_discounted_product_attr'][$listAttr->id] = 
                DB::table('product_attr')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id'=>$listAttr->id])        
                ->get();
        }
     
        // echo "<pre>";
        // print_r($result);
        // die;
        
        return view('front.index',$result);
    }
    public function category(Request $request,$slug)
    {
        $sort ="";
        $sort_txt ="";
        $filter_price_start= 100;
        $filter_price_end = 2000;
        $filter_color = "";
        $filterColorArr = [];

        $result['categories_left'] = DB::table('categories')->where(['status'=>1])->where(['is_home'=>1])->orWhere(['is_home'=>2])->get();
       
        if ($request->get('sort')!==null){
            $sort = $request->get('sort');
        }
        if ($request->get('filter_price_start')!==null && $request->get('filter_price_end')!==null){
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');
        }

        
        $query = DB::table('products');
        $query = $query->distinct()->select('products.*');
        $query = $query->leftjoin('categories','categories.id','=','products.category_id');
        $query = $query->leftjoin('product_attr','product_attr.product_id','=','products.id');
        $query = $query->where(['products.status'=>1]);
        $query = $query->where(['categories.category_slug'=>$slug]);
        if ( $sort == 'name'){
            $query = $query->orderby('products.name','desc');
            $sort_txt ="Product Name";
        }
        if ( $sort == 'date'){
            $query = $query->orderby('products.id','desc');
            $sort_txt ="Date";
        }
        if ( $sort == 'price_asc'){
            $query = $query->orderby('product_attr.price','asc');
            $sort_txt ="Price Asc";
        }
        if ( $sort == 'price_desc'){
            $query = $query->orderby('product_attr.price','desc');
            $sort_txt ="Price Desc";
        }
        if ($filter_price_start >0 && $filter_price_end> 0){
            $query = $query->wherebetween('product_attr.price',[$filter_price_start,$filter_price_end]);
        }
        if ($request->get('filter_color')!==null ){
            $filter_color = $request->get('filter_color');
            $filterColorArr = explode(":",$filter_color);
            $filterColorArr = array_filter($filterColorArr); // remove empty array
            $query = $query->where(['product_attr.color_id'=>$request->get('filter_color')]);
            
        }
        $query = $query->get();
        $result['product'] = $query;
        
        foreach($result['product'] as $listAttr){
            $query1 = DB::table('product_attr');
            $query1 = $query1->leftjoin('sizes','sizes.id','=','product_attr.size_id');
            $query1 = $query1->leftjoin('colors','colors.id','=','product_attr.color_id');
            $query1 = $query1->where(['product_attr.product_id'=>[$listAttr->id]]);        
            $query1 = $query1->get();
            $result['product_attr'][$listAttr->id]=$query1;
        }
               //prx($result);
               $result['slug']   = $slug;
               $result['sort']   = $sort;
               $result['sort_txt']   = $sort_txt;
               $result['filter_price_start']   = $filter_price_start;
               $result['filter_price_end']   = $filter_price_end;
               $result['filter_color']   = $filter_color;
               $result['filterColorArr']   = $filterColorArr;
               //echo $slug;
               
               //prx($result['categories_left']);      
        $result['colors'] = DB::table('colors')->where(['status'=>1])->get();
        return view('front.category',$result);
    }
    public function product(Request $request,$slug)
    {
        $result['product'] = 
                DB::table('products')->where(['status'=>1])
                ->where(['slug'=>$slug])
                ->get();
        foreach($result['product'] as $listAttr){
            $result['product_attr'][$listAttr->id] = 
                DB::table('product_attr')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id'=>$listAttr->id])        
                ->get();
        }
        foreach($result['product'] as $listAttr){
            $result['product_images'][$listAttr->id] = 
                DB::table('product_images')
                ->where(['product_images.product_id'=>$listAttr->id])        
                ->get();
        }
        //prx($result['product']);
        $result['related_product'] = 
                DB::table('products')->where(['status'=>1])
                ->where('slug','!=',$slug)
                ->where(['category_id'=>$result['product'][0]->category_id])
                ->get();
        //prx($result['product'][0]->category_id);
        foreach($result['related_product'] as $listAttr){
            $result['related_product_attr'][$listAttr->id] = 
                DB::table('product_attr')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id'=>$listAttr->id])        
                ->get();
        }
        //prx($result['related_product']);
        return view('front.product',$result);
        
    }
    public function add_to_cart(Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempID();
            $user_type="Not-Reg";
        }
        $size_id=$request->post('size_id');
        $color_id=$request->post('color_id');
        $pqty=$request->post('pqty');
        $product_id=$request->post('product_id');
        $result = 
                DB::table('product_attr')
                ->select('product_attr.id')
                ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftjoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_id'=>$product_id])       
                ->where(['sizes.size'=>$size_id])
                ->where(['colors.color'=>$color_id])
                ->get();
        $product_attr_id= $result[0]->id;

        $check = DB::table('cart')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->where(['product_id'=>$product_id])
        ->where(['product_attr_id'=>$product_attr_id])
        ->get();
        if(isset($check[0])){
            $update_id=$check[0]->id;
            if($pqty==0){
                DB::table('cart')
                ->where(['id'=>$update_id])
                ->delete();
                $msg="removed";
            }else{
                DB::table('cart')
                ->where(['id'=>$update_id])
                ->update(['qty'=>$pqty]);
                $msg="Updated";
            }
        }else{
            $id=DB::table('cart')->insertGetID([
                'user_id'=>$uid,
                'user_type'=>$user_type,
                'product_id'=>$product_id,
                'product_attr_id'=>$product_attr_id,
                'qty'=>$pqty,
                'added_on'=>date('Y-m-d h:i:s')
            ]);
            $msg="Added";
        }
        $result = DB::table('cart')
        ->leftjoin('products','products.id','=','cart.product_id')
        ->leftjoin('product_attr','cart.product_id','=','product_attr.product_id')
        ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
        ->leftjoin('colors','colors.id','=','product_attr.color_id')   
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->select('products.id as pid','product_attr.id as attr_id', 'cart.qty','products.name','products.image','sizes.size','colors.color','product_attr.price','products.slug')
        ->get();
        return response()->json(['msg'=>$msg,'data'=>$result,'totalItem'=>count($result)]);
    }
    public function cart(Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempID();
            $user_type="Not-Reg";
        }
        $result['list'] = DB::table('cart')
        ->leftjoin('products','products.id','=','cart.product_id')
        ->leftjoin('product_attr','cart.product_id','=','product_attr.product_id')
        ->leftjoin('sizes','sizes.id','=','product_attr.size_id')
        ->leftjoin('colors','colors.id','=','product_attr.color_id')   
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->select('products.id as pid','product_attr.id as attr_id', 'cart.qty','products.name','products.image','sizes.size','colors.color','product_attr.price','products.slug')
        ->get();
        //prx($result);
        return view('front.cart',$result);
        
    }
    public function search(Request $request,$str)
    {
        
        $result['product'] = 
                $query = DB::table('products');
                $query = $query->distinct()->select('products.*');
                $query = $query->leftjoin('categories','categories.id','=','products.category_id');
                $query = $query->leftjoin('product_attr','product_attr.product_id','=','products.id');
                $query = $query->where(['products.status'=>1]);
                $query = $query->where('name','like',"%$str%");
                $query = $query->orwhere('model','like',"%$str%");
                $query = $query->orwhere('short_desc','like',"%$str%");
                $query = $query->orwhere('desc','like',"%$str%");
                $query = $query->orwhere('keywords','like',"%$str%");
                $query = $query->orwhere('technical_specification','like',"%$str");
                
                $query = $query->get();
                $result['product'] = $query;
                
                foreach($result['product'] as $listAttr){
                    $query1 = DB::table('product_attr');
                    $query1 = $query1->leftjoin('sizes','sizes.id','=','product_attr.size_id');
                    $query1 = $query1->leftjoin('colors','colors.id','=','product_attr.color_id');
                    $query1 = $query1->where(['product_attr.product_id'=>[$listAttr->id]]);        
                    $query1 = $query1->get();
                    $result['product_attr'][$listAttr->id]=$query1;
                }
        //prx($result['product']);
        
        return view('front.search',$result);
                
                
    }
    public function registration(Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')!=null){
            return redirect('/');
        }
        $result[]='';  
        return view('front.registration',$result);
    }
    
    public function registration_process(Request $request)
    {
        //prx($_POST);
        //prx($request);
        $valid = Validator::make($request->all(),[
                "name"=>'required',
                "email"=>'required|email|unique:customers,email',
                "password"=>'required',
                "mobile"=>'required|numeric|digits:11'
        ]);
        
        if (!$valid->passes()){ // if validation not passed
            return response()->json(['status'=>'error',
            'error'=>$valid->errors()->toArray()]); //use json to send error
        }else{
            $rand_id = rand(111111111,999999999);
            $arr=[
                "name"=>$request->name,
                "email"=>$request->email,
                "password"=>Crypt::encrypt($request->password),
                "mobile"=>$request->mobile,
                "status"=>1,
                "is_verify"=>0,
                "rand_id"=>$rand_id,
                "created_at"=>date('Y-m-d h:i:s'),
                "updated_at"=>date('Y-m-d h:i:s')
            ];
            $query = DB::table('customers')->insert($arr);
            if($query){
                $data=['name'=>$request->name,'rand_id'=>$rand_id];
                $user['to']=$request->email;
                Mail::send('front/email_verification',$data,function($message) use
                ($user){
                    $message->to($user['to']);
                    $message->subject('Email Id Verificaton');
                });
                return response()->json(['status'=>'success',
            'msg'=>'Registration Successfully. Please check your email id for verification']); //use json to send error
            }
        }
    }

    public function login_process(Request $request)
    {
        //prx($_POST);
        //prx($request);
        $result = DB::table('customers')
                ->where(['email'=>$request->str_login_email])
                ->get();
                //prx($result);       
        if(isset($result[0])){
            $db_pwd = Crypt::decrypt($result[0]->password);
            $email_status=$result[0]->status;
            $is_verify=$result[0]->is_verify;
            
            if($is_verify==0){
                return response()->json(['status'=>"error",'msg'=>'Please verify your email id']);
            }

            if($email_status==0){
                return response()->json(['status'=>"error",'msg'=>'Your account has been deactiviated']);
            }

            if($db_pwd==$request->str_login_password){
                if($request->rememberme===null){
                    setcookie('login_email',$request->str_login_email,100);
                    setcookie('login_pwd',$request->str_login_password,100);
                    
                }else{
                    setcookie('login_email',$request->str_login_email,time()+60*60*24*365);
                    setcookie('login_pwd',$request->str_login_password,time()+60*60*24*365);
                    
                }
               
                //echo $request->rememberme;
                //die;
                $request->session()->put('FRONT_USER_LOGIN',true);
                $request->session()->put('FRONT_USER_ID',$result[0]->id);
                $request->session()->put('FRONT_USER_NAME',$result[0]->name);
                $status = "success";
                $msg = "Ok";

               
                $getUserTempID = getUserTempID();
                DB::table('cart')
                ->where(['user_id'=>$getUserTempID,'user_type'=>'Not-Reg'])
                ->update(['user_id'=>$result[0]->id,'user_type'=>'Reg']);
            }else{
                $status = "error";
                $msg = "Please enter valid password";
            }
           
        }else{
            $status = "error";
            $msg = "Please enter valid email";
        }
        //echo ($db_pwd);
        
                //prx($request);
                
        return response()->json(['status'=>$status,'msg'=>$msg]); //use json to send message
        
    }
    public function email_verification(Request $request,$id)
    {
        $result = DB::table('customers')
                ->where(['rand_id'=>$id])
                ->where(['is_verify'=>0])
                ->get();
        if(isset($result[0])){
            DB::table('customers')
                ->where(['id'=>$result[0]->id])
                ->update(['is_verify'=>1,'rand_id'=>'']);
            return view('front.verification');
        }else{
            return redirect('/');
        }
    }
    public function forgot_password(Request $request)
    {
        
        $result = DB::table('customers')
                ->where(['email'=>$request->str_forgot_email])
                ->get();
        $rand_id = rand(111111111,999999999);
                //prx($result);       
        if(isset($result[0])){

            DB::table('customers')
            ->where(['email'=>$request->str_forgot_email])
            ->update(['is_forgot_password'=>1,'rand_id'=>$rand_id]);

            $data=['name'=>$result[0]->name,'rand_id'=>$rand_id];
                $user['to']=$request->str_forgot_email;
                Mail::send('front/forgot_password',$data,function($message) use
                ($user){
                    $message->to($user['to']);
                    $message->subject('Forgot Password');
                });
                return response()->json(['status'=>"success",'msg'=>'Please check your email for password']);
        }else{
            return response()->json(['status'=>"error",'msg'=>'email id not registered']);
        }
        
    }
    public function forgot_password_Change(Request $request,$id)
    {
        $result = DB::table('customers')
                ->where(['rand_id'=>$id])
                ->where(['is_forgot_password'=>1])
                ->get();
        if(isset($result[0])){
            $request->session()->put('FORGOT_PASSWORD_USER_ID',$result[0]->id);
            return view('front.forgot_password_change');
        }else{
            return redirect('/');
        }
    }

    public function forgot_password_change_process(Request $request)
    {
        DB::table('customers')
            ->where(['id'=>$request->session()->get('FORGOT_PASSWORD_USER_ID')])
            ->update([
                'is_forgot_password'=>0,
                'password'=>encrypt($request->password),
                'rand_id'=>''
            ]);

                
            return response()->json(['status'=>"success",'msg'=>'Password Changed']);
    }
    public function checkout(Request $request)
    {
        $result['cart_data'] = getAddToCartTotalItem();
        
        if(isset($result['cart_data'])){
            if($request->session()->has('FRONT_USER_LOGIN')){
                $uid=$request->session()->get('FRONT_USER_ID');
                $customer_info = DB::table('customers')
                ->where(['id'=>$uid])
                ->get();
                $result['customers']['name']= $customer_info[0]->name;
                $result['customers']['email']= $customer_info[0]->email;
                $result['customers']['mobile']= $customer_info[0]->mobile;
                $result['customers']['address']= $customer_info[0]->address;
                $result['customers']['city']= $customer_info[0]->city;
                $result['customers']['state']= $customer_info[0]->state;
                $result['customers']['zip']= $customer_info[0]->zip;
                $result['customers']['name']= $customer_info[0]->name;
                $result['customers']['name']= $customer_info[0]->name;

            }else{
                $result['customers']['name']= '';
                $result['customers']['email']= '';
                $result['customers']['mobile']= '';
                $result['customers']['address']= '';
                $result['customers']['city']= '';
                $result['customers']['state']= '';
                $result['customers']['zip']= '';
                $result['customers']['name']= '';
                $result['customers']['name']= '';
            }
            return view('front.checkout',$result);
        }else{
            return redirect('/');
        }

    }
    public function apply_coupon_code(Request $request)
    {
        $arr = check_coupon_code($request->coupon_code);
        $arr = json_decode($arr,true); // convert into array
        //prx($arr);
        return response()->json(['status'=>$arr['status'],'msg'=>$arr['msg'],'totalPrice'=>$arr['totalPrice']]); //use json to send message
        
    }
    public function remove_coupon_code(Request $request)
    {
        $totalPrice =0;
        $result = DB::table('coupons')
                ->where(['code'=>$request->coupon_code])
                ->get();  
        
        $getAddToCartTotalItem = getAddToCartTotalItem();
        
        foreach($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice+($list->qty*$list->price);
        }
        
        return response()->json(['status'=>'success','msg'=>'Coupon code removed','totalPrice'=>$totalPrice]); //use json to send message
        
    }   
    
    public function place_order(Request $request)
    {
        //prx($_POST);
        $payment_url='';
        if($request->session()->has('FRONT_USER_LOGIN')){
            
        }else{
            $valid = Validator::make($request->all(),[
                "email"=>'required|email|unique:customers,email'
            ]);
            
            if (!$valid->passes()){ // if validation not passed
                return response()->json(['status'=>'error',
                'msg'=>'The email has already been taken']); //use json to send error
                
            }else{
                // Register Guest Checkout
                $rand_id = rand(111111111,999999999);
                $arr=[
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "address"=>$request->address,
                    "city"=>$request->city,
                    "state"=>$request->state,
                    "zip"=>$request->zip,
                    "password"=>Crypt::encrypt($rand_id),
                    "mobile"=>$request->mobile,
                    "status"=>1,
                    "is_verify"=>1,
                    "is_forgot_password"=>0,
                    "rand_id"=>$rand_id,
                    "created_at"=>date('Y-m-d h:i:s'),
                    "updated_at"=>date('Y-m-d h:i:s')
                ];
                $user_id = DB::table('customers')->insertGetId($arr);

                $data=['name'=>$request->name,'password'=>$rand_id];
                $user['to']=$request->email;
                Mail::send('front.password_sent',$data,function($message) use
                ($user){
                    $message->to($user['to']);
                    $message->subject('New Password');
                });
                $request->session()->put('FRONT_USER_LOGIN',true);
                $request->session()->put('FRONT_USER_ID',$user_id);
                $request->session()->put('FRONT_USER_NAME',$request->name);
                
                $getUserTempID = getUserTempID();
                DB::table('cart')
                ->where(['user_id'=>$getUserTempID,'user_type'=>'Not-Reg'])
                ->update(['user_id'=>$user_id,'user_type'=>'Reg']);
                //die('sss');
            }
        }
            $coupon_value= 0;
            if($request->coupon_code!=''){
                $arr = check_coupon_code($request->coupon_code);
                $arr = json_decode($arr,true); // convert into array
                if($arr['status']=='success'){
                    $coupon_value=$arr['coupon_code_value'];
                }else{
                    
                    return response()->json(['status'=>'error','msg'=>$arr['msg'],$arr['coupon_code_value']]); //use json to send message
                }
            }
            //prx($arr);
            $uid=$request->session()->get('FRONT_USER_ID');
            $totalPrice=0;
            $getAddToCartTotalItem = getAddToCartTotalItem();
            foreach($getAddToCartTotalItem as $list) {
                $totalPrice = $totalPrice+($list->qty*$list->price);
            }
            
            $arr=[
                "customer_id"=> $uid,
                "name"=>$request->name,
                "email"=>$request->email,
                "mobile"=>$request->mobile,
                "address"=>$request->address,
                "city"=>$request->city,
                "pincode"=>$request->zip,
                "payment_type"=>$request->payment_type,
                "coupon_code"=>$request->coupon_code,
                "coupon_value"=>$coupon_value,
                "order_status"=>1,
                "payment_status"=>'Pending',
                "total_amt"=>$totalPrice,
                "coupon_code"=>$request->coupon_code,
                "added_on"=>date('Y-m-d h:i:s')
            ];
            $order_id = DB::table('orders')->insertGetId($arr);
            if($order_id>0){
                $productDetail =[];
                
                foreach($getAddToCartTotalItem as $list) {
                    $productDetail['product_id'] = $list->pid;
                    $productDetail['product_attr_id'] = $list->attr_id;
                    $productDetail['price'] = $list->price;
                    $productDetail['qty'] = $list->qty;
                    $productDetail['order_id'] = $order_id;
                    DB::table('orders_details')->insert($productDetail);
                }
                if($request->payment_type=='Gateway'){
                    $final_amt = $totalPrice-$coupon_value;
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // for local host
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER,
                                array("X-Api-Key:test_c1058857ae27d01dc7140380098",
                                    "X-Auth-Token:test_b3a91d7b7a152b2efeda7682f6f"));
                    $payload = Array(
                        'purpose' => 'Buy Product',
                        'amount' => $final_amt,
                        'phone' => $request->mobile,
                        'buyer_name' => $request->name,
                        'redirect_url' => 'http://127.0.0.1:8000/instamojo_payemtn_redirect',
                        'send_email' => true,
                        'send_sms' => true,
                        'email' => $request->email,
                        'allow_repeated_payments' => false
                    );
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                    $response = curl_exec($ch);
                    curl_close($ch); 
                    $response =json_decode($response);
                    if(isset($response->payment_request->id)){
                        $txn_id =$response->payment_request->id;
                        DB::table('orders')
                        ->where(['id'=>$order_id])
                        ->update(['txn_id'=>$txn_id]);
                        $payment_url = $response->payment_request->longurl;
                    }else{
                        //$msg=$response->message;
                        $msg="";
                        foreach($response->message as $key=> $val){
                            $msg.=strtoupper($key).":".$val[0].'<br>';
                        }
                        //prx($msg);
                        return response()->json(['status'=>'error','msg'=>$msg,'totalPrice'=>'','payment_url'=>'']); //use json to send message
                    }
                    
                    //prx($response);
                }
                /*
                DB::table('cart')
                    ->where(['user_id'=>$uid,'user_type'=>'Reg'])
                    ->delete();
                */
                $request->session()->put('ORDER_ID',$order_id);
                $status= "success";
                $msg = "Order Placed";

            }else{
                $status= "error";
                $msg = "Please try after sometime";
            }
        
        return response()->json(['status'=>$status,'msg'=>$msg,'totalPrice'=>$totalPrice,'payment_url'=>$payment_url]); //use json to send message
    }

    public function order_placed(Request $request)
    {
        if($request->session()->has('ORDER_ID')){
            return view('front.order_placed');
        }else{            
            return redirect('/');
        }
    }
    public function order_fail(Request $request)
    {
        if($request->session()->has('ORDER_ID')){
            return view('front.order_fail');
        }else{            
            return redirect('/');
        }
    }
    public function instamojo_payemtn_redirect(Request $request)
    {
        
        //prx($_GET);
        
        if($request->get('payment_id')!=null && $request->get('payment_status')!=null && $request->get('payment_request_id')!=null){
            if($request->get('payment_status')=='Credit'){
                $status ='Success';
                $redirect_url = '/order_placed';
            }else{
                $status ='Fail';
                $redirect_url = '/order_fail';
            }
            $request->session()->put('status',$status);
            DB::table('orders')
            ->where(['txn_id'=>$request->get('payment_request_id')])
            ->update(['payment_status'=>$status,'payment_id'=>$request->get('payment_id')]);
            return redirect($redirect_url);
        }else{
            die('something went wrong');
        }
        
    }
}
