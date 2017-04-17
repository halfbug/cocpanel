

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>



            <!--Clients Order by Packages-->
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
                            <td id="clients_{{$package->id}}">{{$package->linked_clients->unique('user_id')->count() }}</td>

                            <td>
                                <div class="dropup">
                                    <button class="btn btn-danger btn-detail dropdown-toggle pull-left dropdownMenu1" value="{{$package->id}}"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Add Client"><i class="fa fa-user" ></i>
                                    <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li ><a class="add_client" data-value="{{$package->id}}" href="#">Add Existing Client</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a class="new_client" data-value="{{$package->id}}" href="#">Add New Client</a></li>
                                    </ul>
                                </div>&nbsp;
                                <button class="btn btn-secondary btn-detail edit_package" value="{{$package->id}}" title="Edit"><i class="fa fa-edit" ></i></button>
                                <button class="btn btn-warning linked_client" value="{{$package->id}}"  title="Linked Client"><i class="fa fa-group"></i></button>
                                <!--<button class="btn btn-success preview_package" value="{{$package->id}}" title="Preview"><i class="fa fa-search" ></i></button>-->
                                <!--<button class="btn btn-primary btn-delete copy_package" value="{{$package->id}}" title="Copy"><i class="fa fa-copy" ></i></button>-->
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
        @include('modals.add_client')
        @include('modals.linked_clients')
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
