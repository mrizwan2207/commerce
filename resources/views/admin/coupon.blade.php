@extends('admin/layout')
@section('page_title', 'Coupon')
@section('coupon_select', 'active')
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
    <h1 class="mb10">coupon</h1>
    <a href="{{url('admin/coupon/manage_coupon')}}">
        <button type="button" class="btn btn-primary">
            Add Coupon
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
                            <th>Title</th>
                            <th>Code</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                        
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->code}}</td>
                            <td>{{$item->value}}</td>
                            <td>
                                <a href="{{url('admin/coupon/manage_coupon')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                
                                @if($item->status==1)
                                    <a href="{{url('admin/coupon/status/0')}}/{{$item->id}}">
                                        <button type="button" class="btn btn-warning">Active</button>
                                    </a>
                                @elseif($item->status==0)
                                <a href="{{url('admin/coupon/status/1')}}/{{$item->id}}">
                                    <button type="button" class="btn btn-secondary">Deactive</button>
                                </a>
                                @endif
                                

                                <a href="{{url('admin/coupon/delete/')}}/{{$item->id}}">
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