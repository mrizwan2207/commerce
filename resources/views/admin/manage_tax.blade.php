@extends('admin/layout')
@section('page_title', 'manage_tax')
@section('tax_select', 'active')
@section('container')
    <h1 class="mb10">Manage Tax</h1>
    <a href="{{url('admin/tax')}}">
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
                                <form action="{{Route('tax.manage_tax_process')}}" method="post" >
                                    @csrf
                                    <div class="form-group">
                                        <label for="tax" class="control-label mb-1">Tax Name</label>
                                        <input id="tax" value="{{$tax}}" name="tax" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('tax') 
                                            <div class="alert alert-primary" role="alert">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="value" class="control-label mb-1">Value</label>
                                        <input id="value" value="{{$value}}" name="value" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
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