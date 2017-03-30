

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <!--<button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>-->



            <!--Clients Order by Packages-->
            <div class="panel-body"> 


                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Name </th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="clients-list" name="clients-list">
                        @foreach ($packages as $package)
                        <tr id="package_{{$package->id}}">
                            <td>+</td>
                            <td>{{$package->title}}</td>

                            <td><button class="btn btn-success viewmodules" value="{{$package->id}}" title="Show Modules"><i class="fa fa-arrow-circle-o-down" ></i></button></td>

                        </tr>

                        @foreach ($package->selected_modules as $module)
                        <tr colspan="3" class="warning" id="packmodule_{{$package->id}}">
                        <td style="width: 40px;">--</td>
                        <td>{{$module->title}}</td>  
                        <td><button class="btn btn-warning btn-detail preview_module" value="{{$module->id}}" title="Preview"><i class="fa fa-search" ></i></button></td>
                        
                    </tr>
                    @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>




        </div>
        <!--       incluides here-->
    </div>






</div>





@endsection

@section('heading')
Clients <small>management</small>
@endsection

@section('title')
Clients
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<script src="{{asset('js/client.js')}}"></script>-->
<script>
$(document).ready(function() {
    console.log( "ready!" );
    $('[id^=packmodule_]').hide();
});    
$(document).on('click', '.viewmodules', function (e) {
    var package_id = $(this).val();
    $("#packmodule_"+package_id).toggle();
});
</script>
@endsection
