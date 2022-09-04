@extends('admin/layout')
@section('page_title', 'manage_brand')
@section('brand_select', 'active')
@section('container')
@error('image')
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">    
        {{$message}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@enderror
    <h1 class="mb10">Manage brand</h1>
    <a href="{{url('admin/brand')}}">
        <button type="button" class="btn btn-primary">
            Back
        </button>
    </a>
    <div class = "row m-t-30">
        <div class = "col-md-12">
            <div class = "row">
                <div class = "col-md-12">  
                    <div class="card">
                            <div class="card-body">
                                <form action="{{Route('brand.manage_brand_process')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class = "col-md-8">
                                                <label for="brand" class="control-label mb-1">brand Name</label>
                                                <input id="brand" value="{{$brand}}" name="brand" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                @error('brand') 
                                                    <div class="alert alert-primary" role="alert">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class = "col-md-4">
                                                <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                                <input id="is_home" name="is_home" type="checkbox" class="form-control" {{$is_home_selected}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="control-label mb-1">Image</label>
                                        <input id="image" value="{{$image}}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                        @error('image') 
                                        <div class="alert alert-primary" role="alert">
                                           {{$message}}
                                        </div>
                                        @enderror
                                        @if($image!='')
                                                 <a href="{{asset('storage/media/brand/'.$image)}}" target="_blank">
                                                    <img width="50" src="{{asset('storage/media/brand/'.$image)}}"  alt="">
                                                 </a>
                                              @endif
                                     </div>
                                     
                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            Submit
                                        </button>
                                    </div>
                                    <input type="hidden" name = "id" value = "{{$id}}">
                                </form>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection