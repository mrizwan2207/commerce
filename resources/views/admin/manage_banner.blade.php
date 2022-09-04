@extends('admin/layout')
@section('page_title', 'manage_banner')
@section('banner_select', 'active')
@section('container')
@error('image')
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">    
        {{$message}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@enderror
    <h1 class="mb10">Manage banner</h1>
    <a href="{{url('admin/banner')}}">
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
                                <form action="{{Route('banner.manage_banner_process')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class = "col-md-6">
                                                <label for="btn_text" class="control-label mb-1">btn_text Name</label>
                                                <input id="btn_text" value="{{$btn_text}}" name="btn_text" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                            </div>
                                            <div class = "col-md-6">
                                                <label for="btn_link" class="control-label mb-1">btn_link Name</label>
                                                <input id="btn_link" value="{{$btn_link}}" name="btn_link" type="text" class="form-control" aria-required="true" aria-invalid="false" >
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
                                                 <a href="{{asset('storage/media/banner/'.$image)}}" target="_blank">
                                                    <img width="50" src="{{asset('storage/media/banner/'.$image)}}"  alt="">
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