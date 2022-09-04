@extends('admin/layout')
@section('page_title', 'manage_product')
@section('product_select', 'active')
@section('container')
@if($id>0)
{{$image_require=''}}
@else
{{$image_require='required'}}
@endif
<h1 class="mb10">Manage product</h1>

@if(session()->has('sku_error'))
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    
        {{session('sku_error')}}
   
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif
@error('attr_image.*')
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    
        {{$message}}
   
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@enderror
<a href="{{url('admin/product')}}">
<button type="button" class="btn btn-primary">
Back
</button>
</a>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<div class = "row m-t-30">
   <div class = "col-md-12">
      <form action="{{Route('product.manage_product_process')}}" method="post" enctype="multipart/form-data" >
         <div class = "row">
            <div class = "col-md-12">
               <div class="card">
                  <div class="card-body">
                     @csrf
                     <div class="form-group">
                        <label for="name" class="control-label mb-1">Name</label>
                        <input id="name" value="{{$name}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        @error('name') 
                        <div class="alert alert-primary" role="alert">
                           {{$message}}
                        </div>
                        @enderror
                     </div>
                     <div class="form-group">
                        <label for="image" class="control-label mb-1">Image</label>
                        <input id="image" value="{{$image}}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_require}}>
                        @error('image') 
                        <div class="alert alert-primary" role="alert">
                           {{$message}}
                        </div>
                        @enderror
                        @if($image!='')
                                 <a href="{{asset('/storage/media/product/'.$image)}}" target="_blank">
                                    <img width="50" src="{{asset('/storage/media/product/'.$image)}}"  alt="">
                                 </a>
                              @endif
                     </div>
                     <div class="form-group">
                        <label for="slug" class="control-label mb-1">Slug</label>
                        <input id="slug" value="{{$slug}}" name="slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-4">
                              <label for="category_id" class="control-label mb-1">Category</label>
                              <select name="category_id" id="category_id" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 <option value="">Select Category</option>
                                 @foreach ($category as $item)
                                 @if($category_id==$item->id)
                                 <option selected value="{{$item->id}}">
                                    {{$item->category_name}}
                                 </option>
                                 @else
                                 <option value="{{$item->id}}">
                                    {{$item->category_name}}
                                 </option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label for="brand_id" class="control-label mb-1">Brand</label>
                              <select name="brand_id" id="brand_id" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 <option value="">Select Brand</option>
                                 @foreach ($brand as $item)
                                 @if($brand_id==$item->id)
                                 <option selected value="{{$item->id}}">
                                    {{$item->brand}}
                                 </option>
                                 @else
                                 <option value="{{$item->id}}">
                                    {{$item->brand}}
                                 </option>
                                 @endif
                                 @endforeach
                              </select>
                              
                           </div>
                           <div class="col-md-4">
                              <label for="model" class="control-label mb-1">model</label>
                              <input id="model" value="{{$model}}" name="model" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="short_desc" class="control-label mb-1">Short_desc</label>
                        <textarea id="short_desc"  name="short_desc" class="form-control" aria-required="true" aria-invalid="false" required>{{$short_desc}}</textarea>
                     </div>
                     <div class="form-group">
                        <label for="desc" class="control-label mb-1">desc</label>
                        <input id="desc" value="{{$desc}}" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                     </div>
                     <div class="form-group">
                        <label for="keywords" class="control-label mb-1">keywords</label>
                        <input id="keywords" value="{{$keywords}}" name="keywords" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                     </div>
                     <div class="form-group">
                        <label for="technical_specification" class="control-label mb-1">technical_specification</label>
                        <textarea id="technical_specification"  name="technical_specification" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$technical_specification}}</textarea>
                     </div>
                     <div class="form-group">
                        <label for="uses" class="control-label mb-1">uses</label>
                        <input id="uses" value="{{$uses}}" name="uses" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                     </div>                  
                     <div class="form-group">
                        <label for="warranty" class="control-label mb-1">warranty</label>
                        <input id="warranty" value="{{$warranty}}" name="warranty" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-6">
                              <label for="lead_time" class="control-label mb-1">Lead_time</label>
                              <input id="lead_time" value="{{$lead_time}}" name="lead_time" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                           </div>
                           <div class="col-md-6">
                              <label for="tax_id" class="control-label mb-1">tax</label>
                              <select name="tax_id" id="tax_id" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 <option value="">Select tax</option>
                                 @foreach ($tax as $item)
                                 @if($tax_id==$item->id)
                                 <option selected value="{{$item->id}}">
                                    {{$item->tax}}
                                 </option>
                                 @else
                                 <option value="{{$item->id}}">
                                    {{$item->tax}}
                                 </option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>                    
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-3">
                              <label for="is_promo" class="control-label mb-1">Is_Promo</label>
                              <select name="is_promo" id="is_promo" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 @if($is_promo=='1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                 @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                 @endif
                              </select>
                           </div>
                           <div class="col-md-3">
                              <label for="is_featured" class="control-label mb-1">is_featured</label>
                              <select name="is_featured" id="is_featured" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 @if($is_featured=='1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                 @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                 @endif
                              </select>
                           </div>
                           <div class="col-md-3">
                              <label for="is_tranding" class="control-label mb-1">is_tranding</label>
                              <select name="is_tranding" id="is_tranding" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 @if($is_tranding=='1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                 @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                 @endif
                              </select>
                           </div>
                           <div class="col-md-3">
                              <label for="is_discounted" class="control-label mb-1">is_discounted</label>
                              <select name="is_discounted" id="is_discounted" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                 @if($is_discounted=='1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                 @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                 @endif
                              </select>
                           </div>
                        </div>
                     </div>
                     <input type="hidden" name = "id" value = "{{$id}}">                               
                  </div>
               </div>
            </div>
            <h2 class="m-t-30">Product Images</h2>
            <div class = "col-md-12" id="product_image_box">
               @php               
                  $loop_count_Image_num=1;
               @endphp
               @foreach($productImageArr as $key => $value)
               <?php 
                  // echo '<pre>';
                  // print_r($value);
                  $pImageArr = (array)$value;               
                  //print_r($pImageArr);
               ?>
               @php
                  $loop_count_Image_prev=$loop_count_Image_num;
               @endphp
               <input id="id" value="{{$pImageArr['id']}}" name="pimageid[]" type="hidden" class="form-control" aria-required="true" aria-invalid="false" >
               <div class="card" id="product_image_{{$loop_count_Image_num++}}">
                  <div class="card-body">
                     <div class="form-group">                        
                        <div class="row">                           
                           <div class="col-md-4">                              
                              <input id="prd_image[]"  name="prd_image[]"  type="file" class="form-control" aria-required="true" aria-invalid="false">                                                     
                           </div>                       
                           <div class="col-md-4">
                              @if($loop_count_Image_num==2)
                                 <button type="button" class="btn btn-success btn-lg" onclick="add_more_prd_image()">
                                 <i class="fa fa-plus"></i>&nbsp; Add</button>
                              @else
                                 <a href="{{url('admin/product/product_image_delete/')}}/{{$pImageArr['id']}}/{{$id}}">   
                                 <button type="button" class="btn btn-danger btn-lg" onclick="remove_prd_image('{{$loop_count_Image_prev}}')">
                                 <i class="fa fa-minus"></i>&nbsp; remove</button></a>   
                              @endif
                           </div>
                           <div class="col-md-4">                              
                              @if($pImageArr['prd_image']!='')
                                 <a href="{{asset('/storage/media/product/'.$pImageArr['prd_image'])}}" target="_blank">
                                    <img width="50" src="{{asset('/storage/media/product/'.$pImageArr['prd_image'])}}"  alt="">
                                 </a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
            <h2 class="m-t-30">Product Attribute</h2>
            <div class = "col-md-12" id="product_attr_box">
               @php               
                  $loop_count_num=1;
               @endphp
               @foreach($productAttrArr as $key => $value)
               <?php 
                  // echo '<pre>';
                  // print_r($value);
                  $pAArr = (array)$value;               
                  //print_r($pAArr);
               ?>
               @php
                  $loop_count_prev=$loop_count_num;
               @endphp
               <input id="id" value="{{$pAArr['id']}}" name="paid[]" type="hidden" class="form-control" aria-required="true" aria-invalid="false" required>
               <div class="card" id="product_attr_{{$loop_count_num++}}">
                  <div class="card-body">
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-3">
                              <label for="sku" class="control-label mb-1">SKU</label>
                              <input id="sku" value="{{$pAArr['sku']}}" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                           <div class="col-md-3">
                              <label for="mrp" class="control-label mb-1">mrp</label>
                              <input id="mrp" value="{{$pAArr['mrp']}}" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                           <div class="col-md-3">
                              <label for="price" class="control-label mb-1">price</label>
                              <input id="price" value="{{$pAArr['price']}}" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                           <div class="col-md-3">
                              <label for="qty" class="control-label mb-1">qty</label>
                              <input id="qty" value="{{$pAArr['qty']}}" name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                              <label for="size_id" class="control-label mb-1">size</label>
                              <select name="size_id[]" id="size_id" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                 <option value="">Select size</option>
                                 @foreach ($size as $item)

                                 @if($pAArr['size_id']==$item->id)
                                 <option selected value="{{$item->id}}">
                                    {{$item->size}}
                                 </option>
                                 @else
                                 <option value="{{$item->id}}">
                                    {{$item->size}}
                                 </option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-3">
                              <label for="color_id" class="control-label mb-1">color</label>
                              <select name="color_id[]" id="color_id" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                 <option value="">Select Color</option>
                                 @foreach ($color as $item)
                                 @if($pAArr['color_id']==$item->id)
                                 <option selected value="{{$item->id}}">
                                    {{$item->color}}
                                 </option>
                                 @else
                                 <option value="{{$item->id}}">
                                    {{$item->color}}
                                 </option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-3">
                              <label for="attr_image" class="control-label mb-1">attr_image</label>
                              <input id="attr_image[]"  name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" >                                                     
                           </div>
                           <div class="col-md-3">
                              @if($pAArr['attr_image']!='')
                                 <a href="{{asset('/storage/media/product/'.$pAArr['attr_image'])}}" target="_blank">
                                    <img width="50" src="{{asset('/storage/media/product/'.$pAArr['attr_image'])}}"  alt="">
                                 </a>
                              @endif
                           </div>
                           
                        </div>
                        
                        <div class="row">
                           <div class="col-md-3">
                              @if($loop_count_num==2)
                                 <button type="button" class="btn btn-success btn-lg" onclick="add_more()">
                                 <i class="fa fa-plus"></i>&nbsp; Add</button>
                              @else
                                 <a href="{{url('admin/product/product_attr_delete/')}}/{{$pAArr['id']}}/{{$id}}">   
                                 <button type="button" class="btn btn-danger btn-lg" onclick="remove('{{$loop_count_prev}}')">
                                 <i class="fa fa-minus"></i>&nbsp; remove</button></a>   
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
         Submit
         </button>
      </form>
   </div>
</div>
@endsection
<script>
    var loop_count=1;
    var loop_count_prd_image=1;
   function add_more(){
        
        loop_count++;
        
      var html = '<div class="card" id ="product_attr_' + loop_count+ '" ><div class="card-body"><div class="form-group">';
               html+='<div class="row">'
               html+='<input id="id"  name="paid[]" type="hidden" class="form-control" aria-required="true" aria-invalid="false" >'
               html+='<div class="col-md-3">' +
                '<label for="sku" class="control-label mb-1">SKU</label>' +
                '<input id="sku"  name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+
              '</div>';
              html+='<div class="col-md-3">' +
                '<label for="mrp" class="control-label mb-1">mrp</label>' +
                '<input id="mrp"  name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+
              '</div>';
              html+='<div class="col-md-3">' +
                '<label for="price" class="control-label mb-1">price</label>' +
                '<input id="price"  name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+
              '</div>';
              html+='<div class="col-md-3">' +
                '<label for="qty" class="control-label mb-1">qty</label>' +
                '<input id="qty"  name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+
              '</div>';

              var size_id_html=jQuery('#size_id').html();  
              size_id_html=size_id_html.replace("selected", "");            
              html+='</div>'
              html+='<div class="row">'
              html+='<div class="col-md-3">' +
              '<label for="size_id" class="control-label mb-1">size</label>' +
               '<select name="size_id[]" id="size_id" type="text" class="form-control" aria-required="true" aria-invalid="false" >' + size_id_html+'</select>'+
               '</div>'
               var color_id_html=jQuery('#color_id').html(); 
               color_id_html=color_id_html.replace("selected", "");            
               html+='<div class="col-md-3">' +
              '<label for="color_id" class="control-label mb-1">color</label>' +
               '<select name="color_id[]" id="color_id" type="text" class="form-control" aria-required="true" aria-invalid="false" >' + color_id_html+'</select>'+
               '</div>'
               html+='<div class="col-md-6">' +
                              '<label for="attr_image" class="control-label mb-1">attr_image</label>' +
                              '<input id="attr_image[]"  name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" >' +
                           '</div>'
              html+='</div>'
              html+='<div class="row">'
              html+='<div class="col-md-3"><button type="button" class="btn btn-danger btn-lg" onclick=remove("'+loop_count +'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>'
              html+='</div>'
             

      html+='</div></div></div>';
      
      jQuery('#product_attr_box').append(html)
   }
   function remove(loop_count){
       jQuery('#product_attr_'+loop_count).remove();
   }
   function add_more_prd_image(){
      loop_count_prd_image++;
      var html = '<div class="card" id ="product_image_' + loop_count_prd_image+ '" ><div class="card-body"><div class="form-group">';
               html+='<div class="row">'
               html+='<input id="id"  name="pimageid[]" type="hidden" class="form-control" aria-required="true" aria-invalid="false" >'
               html+='<div class="col-md-4">' +
                              '<input id="prd_image[]"  name="prd_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" >' +
                     '</div>'
              html+='<div class="col-md-4"><button type="button" class="btn btn-danger btn-lg" onclick=remove_prd_image("'+loop_count_prd_image +'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>'
              html+='</div>'
             

      html+='</div></div></div>';
      
      jQuery('#product_image_box').append(html)
   }
   function remove_prd_image(loop_count_prd_image){
       jQuery('#product_image_'+loop_count_prd_image).remove();
   }
   
</script>
<script>
   CKEDITOR.replace('short_desc');
</script>
