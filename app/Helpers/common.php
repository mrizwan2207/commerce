<?php
use Illuminate\Support\Facades\DB;
function prx($arr){
    echo "<pre>";
    print_r($arr);
    die();
}
function getTopNavCat(){
    $result = DB::table('categories')
                ->where(['status'=>1])
                ->get();
    foreach($result as $row){      
        $arr[$row->id]['category_name']=$row->category_name;
        $arr[$row->id]['parent_category_id']=$row->parent_category_id;
        $arr[$row->id]['category_slug']=$row->category_slug;
        }
    $str=buildTreeView($arr,0);
    return $str;
}
$html = '';
    function buildTreeView($arr,$parent,$level=0,$previouslevel  = -1){
        global $html;
        foreach($arr as $id=>$data){
            if($parent==$data['parent_category_id']){
                if($level>$previouslevel ){
                  if ($html==''){
                    $html.='<ul class="nav navbar-nav">';
                  }else{
                    $html.='<ul class="dropdown-menu">';
                  }
                }
                if($level==$previouslevel ){
                  $html.='</li>';
                }
                $html.='<li><a href="category/'.$data['category_slug'].'">'.$data['category_name'].'<span class="caret"></span></a>';
                
                if($level>$previouslevel ){
                    $previouslevel =$level;
                }
                $level++;
                buildTreeView($arr,$id,$level,$previouslevel );
                $level--;
            } 
        } 
        if($level==$previouslevel ){
            $html.= '</li></ul>';
        }          
        return $html;
    }
    function getUserTempID(){
        if(!session()->has('USER_TEMP_ID')){
            $rand = rand(111111111,999999999);
            session()->put('USER_TEMP_ID',$rand);
            return $rand;
        }else{
            return session()->get('USER_TEMP_ID');
        }

    }
    
    function getAddToCartTotalItem(){
        if(session()->has('FRONT_USER_LOGIN')){
            $uid=session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempID();
            $user_type="Not-Reg";
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
        //prx($result);
        return ($result);
        
    }
  
    function check_coupon_code($coupon_code)
    {
        $totalPrice =0;
        $result = DB::table('coupons')
                ->where(['code'=>$coupon_code])
                ->get();     
        if(isset($result[0])){
            $value = $result[0]->value;
            $type = $result[0]->type;
            if($result[0]->status==1){
                if($result[0]->is_one_time==1){
                    $status = "success";
                    $msg = "Coupon Code already used";
                }else{
                    $min_order_amount = $result[0]->min_order_amount; 
                     if($min_order_amount>0){
                        $getAddToCartTotalItem = getAddToCartTotalItem();
                        $totalPrice =0;
                        foreach($getAddToCartTotalItem as $list) {
                        $totalPrice = $totalPrice+($list->qty*$list->price);
                        if($min_order_amount<$totalPrice){
                            $status = "success";
                            $msg = "Coupon Code applied";
                        }else{
                            $status = "error";
                            $msg = "Cart Amount must be greater than $totalPrice";
                        }
                     }
                    }else{
                        $status = "success";
                        $msg = "Coupon Code applied";
                     }
                }                
            }else{
                $status = "success";
                $msg = "Coupon Code deactivated";
            }
            
        }else{
            $status = "error";
            $msg = "Please Enter Valid Coupon Code";
        }
        $coupon_code_value=0;
        if($status=='success'){
            if($type='Value'){
                $coupon_code_value = $value;
                $totalPrice = $totalPrice-$value;
            }
            if($type='Per'){
                $newPrice = ($value/100)*$totalPrice;
                $totalPrice = round($totalPrice -$newPrice);
                $coupon_code_value = $newPrice;
            }
        }
        return json_encode(['status'=>$status,'msg'=>$msg,'totalPrice'=>$totalPrice,'coupon_code_value'=>$coupon_code_value]); //use json to send message
        
    }
?>