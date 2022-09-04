@extends('admin/layout')
@section('page_title', 'Brand')
@section('brand_select', 'active')
@section('container')
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
    <h1 class="mb10">Brand</h1>
    <a href="brand/manage_brand">
        <button type="button" class="btn btn-primary">
            Add Brand
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
                            <th>Brand</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                        
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->brand}}</td>
                            <td>
                                @if($item->image!='')
                                    <img width="50" src="{{asset('storage/media/brand/'.$item->image)}}"  alt="">
                                @endif
                                
                            </td>
                            <td>
                                <a href="{{url('admin/brand/manage_brand/')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                @if($item->status==1)
                                    <a href="{{url('admin/brand/status/0')}}/{{$item->id}}">
                                        <button type="button" class="btn btn-warning">Active</button>
                                    </a>
                                @elseif($item->status==0)
                                <a href="{{url('admin/brand/status/1')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-secondary">Deactive</button>
                                </a>
                                @endif
                                
                                <a href="{{url('admin/brand/delete/')}}/{{$item->id}}">
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