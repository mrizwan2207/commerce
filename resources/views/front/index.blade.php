@extends('front/layout')
@section('page_title', 'Home Page')
@section('container')
  <!-- Start slider -->
  <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <!-- single slide item -->
            @foreach ($home_banner as $list)
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('storage/media/banner/'.$list->image)}}" />
              </div>
              @if($list->btn_text != '')
              <div class="seq-title">                
                <a data-seq href="{{$list->btn_link}}" class="aa-shop-now-btn aa-secondary-btn">{{$list->btn_text}}</a>
              </div>
              @endif
            </li>
            @endforeach                  
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>
  <!-- / slider -->
  <!-- Start Promo section -->
  <section id="aa-promo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-promo-area">
            <div class="row">
              <!-- promo left -->
              <div class="col-md-5 no-padding">                
                <div class="aa-promo-left">
                  <div class="aa-promo-banner">     
                    @if($home_categories_2 != "")               
                    <img src="{{asset('storage/media/category/'.$home_categories_2->category_image)}}" alt="img">                    
                    <div class="aa-prom-content">
                      <span>75% Off</span>
                      <h4><a href="{{url('category/'.$home_categories_2->category_slug)}}">{{$home_categories_2->category_name}}</a></h4>                      
                    </div>
                    @else
                    <img src="{{asset('storage/media/banner/'.$list->image)}}" alt="img">                    
                    <div class="aa-prom-content">
                      <span>Off</span>
                      <h4><a href="javascript:void">No Image</a></h4>                      
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              <!-- promo right -->
              <div class="col-md-7 no-padding">
                <div class="aa-promo-right">
                  @foreach ($home_categories as $list)
                  <div class="aa-single-promo-right">
                    <div class="aa-promo-banner">                      
                      <img src="{{asset('storage/media/category/'.$list->category_image)}}" alt="img">                      
                      <div class="aa-prom-content">
                        <span>25% Off</span>
                        <h4><a href="{{url('category/'.$list->category_slug)}}">{{$list->category_name}}</a></h4>                        
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Promo section -->
  <!-- Products section -->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                 <ul class="nav nav-tabs aa-products-tab">
                    @php
                      $loop_count=1;  
                    @endphp
                    @foreach($home_categories as $list)
                    @php
                      $cat_class="";
                      if($loop_count==1){
                        $cat_class="active";
                      }
                      $loop_count++;
                  @endphp  
                        <li class="{{$cat_class}}"><a href="#cat{{$list->id}}" data-toggle="tab">{{$list->category_name}}</a></li>
                    @endforeach
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Start men product category -->
                    
                    @php
                      $loop_count=1;  
                    @endphp                                    
                    @foreach($home_categories as $list)
                    @php
                      $cat_class="";
                      if($loop_count==1){
                        $cat_class="in active";
                      }
                        $loop_count++;
                    @endphp  
                    <div class="tab-pane fade {{$cat_class}}" id="cat{{$list->id}}">
                      <ul class="aa-product-catg">
                        @if(isset($home_categories_product[$list->id][0]))
                        @foreach ($home_categories_product[$list->id] as $produtArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$produtArr->slug)}}"><img src="{{asset('storage/media/product/'.$produtArr->image)}}" alt="polo shirt img"></a>
                            <a class="aa-add-card-btn"href="javascript:void(0)" onclick="home_add_to_cart('{{$produtArr->id}}','{{$home_product_attr[$produtArr->id][0]->color}}','{{$home_product_attr[$produtArr->id][0]->size}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$produtArr->slug)}}">{{$produtArr->name}}</a></h4>
                              <span class="aa-product-price">{{$home_product_attr[$produtArr->id][0]->price}}</span>
                              <span class="aa-product-price"><del>{{$home_product_attr[$produtArr->id][0]->mrp}}</del></span>
                            </figcaption>
                          </figure>                         
                          <div class="aa-product-hvr-content">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                          </div>
                          <!-- product badge -->
                           <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                        </li>    
                        @endforeach 
                        @else
                        <li>
                          <figure>
                            No Data Fount
                          </figure>                         
                        </li>
                        @endif                   
                      </ul>
                      
                    </div>
                    @endforeach
                    <!-- / men product category -->
                    <!-- start women product category -->
                  <!-- quick view modal -->                  
                  <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">                      
                        <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <div class="row">
                            <!-- Modal view slider -->
                            <div class="col-md-6 col-sm-6 col-xs-12">                              
                              <div class="aa-product-view-slider">                                
                                <div class="simpleLens-gallery-container" id="demo-1">
                                  <div class="simpleLens-container">
                                      <div class="simpleLens-big-image-container">
                                          <a class="simpleLens-lens-image" >
                                              
                                          </a>
                                      </div>
                                  </div>
                                  <div class="simpleLens-thumbnails-container">
                                      <a href="#" class="simpleLens-thumbnail-wrapper"
                                         >
                                      </a>                                    
                                      <a href="#" class="simpleLens-thumbnail-wrapper"
                                         >
                                      </a>

                                      <a href="#" class="simpleLens-thumbnail-wrapper"
                                         >
                                      </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Modal view content -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="aa-product-view-content">
                                <h3>T-Shirt</h3>
                                <div class="aa-price-block">
                                  <span class="aa-product-view-price">$34.99</span>
                                  <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
                                <h4>Size</h4>
                                <div class="aa-prod-view-size">
                                  <a href="#">S</a>
                                  <a href="#">M</a>
                                  <a href="#">L</a>
                                  <a href="#">XL</a>
                                </div>
                                <div class="aa-prod-quantity">
                                  <form action="">
                                    <select name="" id="">
                                      <option value="0" selected="1">1</option>
                                      <option value="1">2</option>
                                      <option value="2">3</option>
                                      <option value="3">4</option>
                                      <option value="4">5</option>
                                      <option value="5">6</option>
                                    </select>
                                  </form>
                                  <p class="aa-prod-category">
                                    Category: <a href="#">Polo T-Shirt</a>
                                  </p>
                                </div>
                                <div class="aa-prod-view-bottom">
                                  <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                  <a href="#" class="aa-add-to-cart-btn">View Details</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>                        
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- / quick view modal -->              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->
  <!-- banner section -->
  <section id="aa-banner">
    <div class="container">
      <div class="row">
        <div class="col-md-12">        
          <div class="row">
            <div class="aa-banner-area">
            <a href="#"></a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#feature" data-toggle="tab">Featured</a></li>
                <li><a href="#tranding" data-toggle="tab">Tranding</a></li>
                <li><a href="#discounted" data-toggle="tab">Discounted</a></li>                    
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men Featured category -->
                <div class="tab-pane fade in active" id="featured">
                  <ul class="aa-product-catg aa-popular-slider">
                    <!-- start single product item -->
                    @if(isset($home_tranding_product[$list->id][0]))
                        @foreach ($home_featured_product[$list->id] as $produtArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$produtArr->slug)}}"><img src="{{asset('storage/media/product/'.$produtArr->image)}}" alt="polo shirt img"></a>
                            <a class="aa-add-card-btn"href="{{url('product/'.$produtArr->slug)}}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$produtArr->slug)}}">{{$produtArr->name}}</a></h4>
                              <span class="aa-product-price">{{$home_featured_product_attr[$produtArr->id][0]->price}}</span>
                              <span class="aa-product-price"><del>{{$home_featured_product_attr[$produtArr->id][0]->mrp}}</del></span>
                            </figcaption>
                          </figure>                         
                          <div class="aa-product-hvr-content">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                          </div>
                          <!-- product badge -->
                           <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                        </li>    
                        @endforeach 
                        @else
                        <li>
                          <figure>
                            No Data Fount
                          </figure>                         
                        </li>
                        @endif                                                                                                      
                  </ul>
                </div>
                <!-- / popular product category -->
                
                <!-- start Tranding product category -->
                <div class="tab-pane fade" id="tranding">
                 <ul class="aa-product-catg aa-featured-slider">
                    <!-- start single product item -->
                    @if(isset($home_tranding_product[$list->id][0]))
                    @foreach ($home_tranding_product[$list->id] as $produtArr)
                    <li>
                      <figure>
                        <a class="aa-product-img" href="{{url('product/'.$produtArr->slug)}}"><img src="{{asset('storage/media/product/'.$produtArr->image)}}" alt="polo shirt img"></a>
                        <a class="aa-add-card-btn"href="{{url('product/'.$produtArr->slug)}}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                        <figcaption>
                          <h4 class="aa-product-title"><a href="{{url('product/'.$produtArr->slug)}}">{{$produtArr->name}}</a></h4>
                          <span class="aa-product-price">{{$home_tranding_product_attr[$produtArr->id][0]->price}}</span>
                          <span class="aa-product-price"><del>{{$home_tranding_product_attr[$produtArr->id][0]->mrp}}</del></span>
                        </figcaption>
                      </figure>                         
                      <div class="aa-product-hvr-content">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                        <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                      </div>
                      <!-- product badge -->
                       <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                    </li>    
                    @endforeach 
                    @else
                    <li>
                      <figure>
                        No Data Fount
                      </figure>                         
                    </li>
                    @endif 
                  </ul>
                </div>
                <!-- / Tranding product category -->

                <!-- start Discounted product category -->
                <div class="tab-pane fade" id="discounted">
                  <ul class="aa-product-catg aa-latest-slider">
                    <!-- start single product item -->
                    @if(isset($home_discounted_product[$list->id][0]))
                        @foreach ($home_discounted_product[$list->id] as $produtArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$produtArr->slug)}}"><img src="{{asset('storage/media/product/'.$produtArr->image)}}" alt="polo shirt img"></a>
                            <a class="aa-add-card-btn"href="{{url('product/'.$produtArr->slug)}}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$produtArr->slug)}}">{{$produtArr->name}}</a></h4>
                              <span class="aa-product-price">{{$home_discounted_product_attr[$produtArr->id][0]->price}}</span>
                              <span class="aa-product-price"><del>{{$home_discounted_product_attr[$produtArr->id][0]->mrp}}</del></span>
                            </figcaption>
                          </figure>                         
                          <div class="aa-product-hvr-content">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                          </div>
                          <!-- product badge -->
                           <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                        </li>    
                        @endforeach 
                        @else
                        <li>
                          <figure>
                            No Data Fount
                          </figure>                         
                        </li>
                        @endif                                                                                                      
                                                                                                    
                  </ul>
                </div>
                <!-- / discounted product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  
  <!-- Client Brand -->
  <section id="aa-client-brand">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-client-brand-area">
            <ul class="aa-client-brand-slider">
              @foreach ($home_brands as $list)
                <li><a href="#"><img src="{{asset('storage/media/brand/'.$list->image)}}" alt="{{$list->brand}}"></a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Client Brand -->
  <input type = "hidden" id="qty" value = "1">
  <Form id="frmAddToCart">
    <input type="hidden" id="size_id" name="size_id"/>
    <input type="hidden" id="color_id" name="color_id"/>
    <input type="hidden" id="pqty" name="pqty"/>
    <input type="hidden" id="product_id" name="product_id"/>
    @csrf
  
   </Form>
  @endsection