@extends('admin/layout')
@section('page_title', 'Show Customer Detail')
@section('customer_select', 'active')
@section('container')
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3"> 
                        <tr>
                            <td>ID</td>
                            <td>{{$customer_list->id}}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{$customer_list->name}}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$customer_list->mobile}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$customer_list->email}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{$customer_list->address}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$customer_list->city}}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{$customer_list->state}}</td>
                        </tr>
                        <tr>
                            <td>Zip</td>
                            <td>{{$customer_list->zip}}</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>{{$customer_list->company}}</td>
                        </tr>
                        <tr>
                            <td>GST Number</td>
                            <td>{{$customer_list->gstin}}</td>
                        </tr>
                        <tr>
                            <td>Created</td>
                            <td>{{\Carbon\Carbon::parse($customer_list->created_at)->format('d-m-y')}}</td>
                        </tr>
                        <tr>
                            <td>Updated</td>
                            <td>{{\Carbon\Carbon::parse($customer_list->updated_at)->format('d-m-y h:i')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
@endsection