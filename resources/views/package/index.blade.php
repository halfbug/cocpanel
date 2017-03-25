

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>



            <!--<h3>Draft Modules</h3>-->
            <div class="panel-body"> 


                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Clients</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="package-list" name="package-list">
                        @foreach ($packages as $package)
                        <tr id="package_{{$package->id}}">
                            <td>{{$package->title}}</td>
                            <td>{{$package->price}}</td>
                            <td>{{$package->clients}}</td>

                            <td>
                                <button class="btn btn-danger btn-detail add_client" value="{{$package->id}}" title="Add Client"><i class="fa fa-user" ></i></button>
                                <button class="btn btn-secondary btn-detail edit_package" value="{{$package->id}}" title="Edit"><i class="fa fa-edit" ></i></button>
                                <button class="btn btn-warning linked_client" value="{{$package->id}}"  title="Linked Client"><i class="fa fa-group"></i></button>
                                <button class="btn btn-success preview_package" value="{{$package->id}}" title="Preview"><i class="fa fa-search" ></i></button>
                                <button class="btn btn-primary btn-delete copy_package" value="{{$package->id}}" title="Copy"><i class="fa fa-copy" ></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




        </div>
        @include('modals.add_package')
        @include('modals.document')
        @include('modals.question') 
    </div>






</div>




@endsection

@section('heading')
Packages <small>management</small>
@endsection

@section('title')
Packages
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/package.js')}}"></script>
@endsection
