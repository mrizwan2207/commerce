@extends('front/layout')
@section('page_title', 'Category')
@section('container')
  
  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-left">
                <form action="" class="aa-sort-form">
                  <label for="">Sort by</label>
                  <select name="" id="sort_by_value" onchange="sort_by()">
                    <option value="default" selected="Default">Default</option>
                    <option value="name">Name</option>
                    <option value="price_desc">Price - Desc</option>
                    <option value="price_asc">Price - Asc</option>
                    <option value="date">Date</option>
                  </select>
                </form>
                {{$sort_txt}}
                <form action="" class="aa-show-form">
                  <label for="">Show</label>
                  <select name="">
                    <option value="1" selected="12">12</option>
                    <option value="2">24</option>
                    <option value="3">36</option>
                  </select>
                </form>
              </div>
              <div class="aa-product-catg-head-right">
                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
              </div>
            </div>
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                @if(isset($product[0]))
                        @foreach ($product as $produtArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$produtArr->slug)}}"><img src="{{asset('storage/media/product/'.$produtArr->image)}}" alt="polo shirt img"></a>
                            <a class="aa-add-card-btn"href="javascript:void(0)" onclick="home_add_to_cart('{{$produtArr->id}}','{{$product_attr[$produtArr->id][0]->color}}','{{$product_attr[$produtArr->id][0]->size}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$produtArr->slug)}}">{{$produtArr->name}}</a></h4>
                              <span class="aa-product-price">{{$product_attr[$produtArr->id][0]->price}}</span>
                              <span class="aa-product-price"><del>{{$product_attr[$produtArr->id][0]->mrp}}</del></span>
                            </figcaption>
                          </figure>                         
                          
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
              </div>
              <!-- / quick view modal -->   
            </div>
            <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Category</h3>
              <ul class="aa-catg-nav">
                @foreach($categories_left as $cate_left)
                  @if($slug== $cate_left->category_slug)
                    <li><a href="{{url('category/'.$cate_left->category_slug)}}" class="cate_left_active">{{$cate_left->category_name}}</a></li>
                  @else
                  <li><a href="{{url('category/'.$cate_left->category_slug)}}">{{$cate_left->category_name}}</a></li>  
                  @endif
                @endforeach
              </ul>
            </div>
            
            <div class="aa-sidebar-widget">
              <h3>Shop By Price</h3>              
              <!-- price range -->
              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <span id="skip-value-lower" class="example-val">100.00</span>
                 <span id="skip-value-upper" class="example-val">2000.00</span>
                 <button class="aa-filter-btn" type="button" onclick="filterPrice()">Filter</button>
               </form>
              </div>              

            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Shop By Color</h3>
              <div class="aa-color-tag">
                @foreach ($colors as $color)
                  @if(in_array($color->id,$filterColorArr))
                    <a class="aa-color-{{strtolower($color->color)}} active_color" href="javascript:void(0)" onclick="setColor('{{$color->id}}',1)"></a> 
                  @else
                  <a class="aa-color-{{strtolower($color->color)}}" href="javascript:void(0)" onclick="setColor('{{$color->id}}',0)"></a> 
                  @endif
                @endforeach 
              </div>                            
            </div>
            
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->
  <input type = "hidden" id="qty" value = "1">
  <Form id="frmAddToCart">
    <input type="hidden" id="size_id" name="size_id"/>
    <input type="hidden" id="color_id" name="color_id"/>
    <input type="hidden" id="pqty" name="pqty"/>
    <input type="hidden" id="product_id" name="product_id"/>
    @csrf
  
   </Form>
   <Form id="categoryFilter">
    <input type="hidden" id="sort" name="sort" value ="{{$sort}}"/> 
    <input type="hidden" id="filter_price_start" name="filter_price_start" value="{{$filter_price_start}}" /> 
    <input type="hidden" id="filter_price_end" name="filter_price_end" value="{{$filter_price_end}}" /> 
    <input type="hidden" id="filter_color" name="filter_color" value="{{$filter_color}}" /> 
   </Form>
  @endsection