@extends('admin/layout')
@section('page_title', 'category')
@section('category_select', 'active')
@section('container')

    
    <h1 class="mb10">category</h1>
    @if(session()->has('message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success">
                {{session('message')}}
            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    
    <a href="category/manage_category">
        <button type="button" class="btn btn-primary">
            Add Category
        </button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                        
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->category_name}}</td>
                            <td>{{$item->category_slug}}</td>
                            <td>
                                <a href="{{url('admin/category/manage_category/')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                @if($item->status==1)
                                    <a href="{{url('admin/category/status/0')}}/{{$item->id}}">
                                        <button type="button" class="btn btn-warning">Active</button>
                                    </a>
                                @elseif($item->status==0)
                                <a href="{{url('admin/category/status/1')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-secondary">Deactive</button>
                                </a>
                                @endif
                                
                                <a href="{{url('admin/category/delete/')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
@endsection