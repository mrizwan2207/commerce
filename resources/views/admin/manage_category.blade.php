@extends('admin/layout')
@section('page_title', 'manage_category')
@section('category_select', 'active')
@section('container')
    <h1 class="mb10">Manage Category</h1>
    <a href="{{url('admin/category')}}">
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
                                <form action="{{Route('category.manage_category_process')}}" method="post"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class = "row">
                                            <div class = "col-md-4">
                                                <label for="category_name" class="control-label mb-1">Category Name</label>
                                                <input id="category_name" value="{{$category_name}}" name="category_name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                @error('category_name') 
                                                    <div class="alert alert-primary" role="alert">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class = "col-md-4">
                                                <label for="parent_category_id" class="control-label mb-1">Parent Category ID</label>
                                                <select name="parent_category_id" id="parent_category_id" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                                    <option value=0>Select Category</option>
                                                    @foreach ($category as $item)
                                                    @if($parent_category_id==$item->id)
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
                                            <div class = "col-md-4">
                                                <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                                <input id="category_slug" value="{{$category_slug}}" name="category_slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                @error('category_slug') 
                                                    <div class="alert alert-primary" role="alert">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                        <input id="is_home" name="is_home" type="checkbox" {{$is_home_selected}}>
                                       
                                     </div>
                                    <div class="form-group">
                                        <label for="category_image" class="control-label mb-1">category_image</label>
                                        <input id="category_image" value="{{$category_image}}" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false" >
                                        @error('category_image') 
                                        <div class="alert alert-primary" role="alert">
                                           {{$message}}
                                        </div>
                                        @enderror
                                        @if($category_image!='')
                                                 <a href="{{asset('storage/media/category/'.$category_image)}}" target="_blank">
                                                    <img width="50" src="{{asset('storage/media/category/'.$category_image)}}"  alt="">
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