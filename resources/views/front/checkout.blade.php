@extends('front/layout')
@section('page_title', 'Check Out')
@section('container')
  <!-- Cart view section -->
 <section id="checkout">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
       <div class="checkout-area">
         <form action="" id="frmPlaceOrder">
           <div class="row">
             <div class="col-md-8">
               <div class="checkout-left">
                 <div class="panel-group" id="accordion">
                    @if(session()->has('FRONT_USER_LOGIN')==null)
                      <input  type="button" value="Login" class="aa-browse-btn" data-toggle="modal" data-target="#login-modal">
                    @endif
                   <!-- Coupon section -->
                   <div class="panel panel-default aa-checkout-coupon apply_coupon_code_box">
                     <div class="panel-heading">
                       <h4 class="panel-title">
                         <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                           Have a Coupon?
                         </a>
                       </h4>
                     </div>
                     <div id="collapseOne" class="panel-collapse collapse in">
                       <div class="panel-body">
                         <input type="text" placeholder="Coupon Code" class="aa-coupon-code" name="coupon_code" id="coupon_code">
                         <input type="button" value="Apply Coupon" class="aa-browse-btn"  onclick="applyCouponCode()">
                         <div id="coupon_code_msg">
                           
                         </div>
                       </div>
                     </div>
                   </div>
                   <!-- Login section -->
                  
                   <!-- Shipping Address -->
                   <div class="panel panel-default aa-checkout-billaddress">
                     <div class="panel-heading">
                       <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class aria-expanded="true">
                          Shippping Address
                        </a>
                       </h4>
                     </div>
                     <div id="collapseFour" class="panel-collapse collapse in" aria-expanded="true">
                       <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12">
                             <div class="aa-checkout-single-bill">
                               <input type="text" placeholder="Name*" name="name" value="{{$customers['name']}}" required>
                             </div>                             
                           </div>
                         </div>  
                         <div class="row">
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="email" placeholder="Email Address*" name="email" value="{{$customers['email']}}" required>
                             </div>                             
                           </div>
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="tel" placeholder="Phone*" name="mobile" value="{{$customers['mobile']}}" required>
                             </div>
                           </div>
                         </div> 
                         <div class="row">
                           <div class="col-md-12">
                             <div class="aa-checkout-single-bill">
                               <textarea cols="8" rows="3" name="address" required> {{$customers['address']}}</textarea>
                             </div>                             
                           </div>                            
                         </div>   
                         
                         <div class="row">
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="text" placeholder="Appartment, Suite etc.">
                             </div>                             
                           </div>
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="text" placeholder="City / Town*" name="city" value="{{$customers['city']}}" required>
                             </div>
                           </div>
                         </div>   
                         <div class="row">
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="text" placeholder="State*" name="state" value="{{$customers['state']}}" required>
                             </div>                             
                           </div>
                           <div class="col-md-6">
                             <div class="aa-checkout-single-bill">
                               <input type="text" placeholder="Postcode / ZIP*" name="zip" value="{{$customers['zip']}}" required>
                             </div>
                           </div>
                         </div> 
                          <div class="row">
                           <div class="col-md-12">
                             <div class="aa-checkout-single-bill">
                               <textarea cols="8" rows="3">Special Notes</textarea>
                             </div>                             
                           </div>                            
                         </div>              
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-md-4">
               <div class="checkout-right">
                 <h4>Order Summary</h4>
                 <div class="aa-order-summary-area">
                   <table class="table table-responsive">
                     <thead>
                       <tr>
                         <th>Product</th>
                         <th>Total</th>
                       </tr>
                     </thead>
                     <tbody>
                       @php
                         $totalPrice = 0;
                       @endphp
                       @foreach($cart_data as $list)                       
                        <tr>
                          <td>{{$list->name}} <strong> x  {{$list->qty}}</strong></td>
                          <td>{{$list->price*$list->qty}}</td>
                        </tr>  
                        @php
                         $totalPrice = $totalPrice+($list->price*$list->qty);
                       @endphp
                       @endforeach
                     </tbody>
                     <tfoot>
                      <tr class="hide show_coupon_box">
                        <th>Coupon Code <a href="javascript:void(0)" onClick="remove_coupon_code()" class="remove_coupon_code_link">Remove</a> </th>
                        <td id="coupon_code_str"></td>
                      </tr>
                       <tr> 
                         <th>Total</th>
                         <td id="total_price">{{$totalPrice}}</td>
                       </tr>
                     </tfoot>
                   </table>
                 </div>
                 <h4>Payment Method</h4>
                 <div class="aa-payment-method">                    
                   <label for="cashdelivery"><input type="radio" id="cod" name="payment_type" value="COD"> Cash on Delivery </label>
                   <label for="paypal"><input type="radio" id="instamojo" name="payment_type"  checked value ="Gateway"> Via Instamojo </label>
                   <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">    
                   <input type="submit" value="Place Order" class="aa-browse-btn" id="btnPlaceOrder">                
                 </div>
                 <div id="order_place_msg"></div>
               </div>
             </div>
           </div>
           @csrf
         </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / Cart view section -->
@endsection