

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <button id="btn_add" name="btn_add" class="btn btn-default pull-right">Add New Module</button>




            <div id="exTab2" >	
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a  href="#1" data-toggle="tab">Draft </a>
                    </li>
                    <li>
                        <a href="#2" data-toggle="tab">Live</a>
                    </li>

                </ul>

                <div class="tab-content ">
                    <div class="tab-pane active" id="1">
                        <h3>Draft Modules</h3>
                        <div class="panel-body"> 


                            <table class="table">
                                <thead>
                                    <tr>
<!--                                        <th>ID</th>-->
                                        <th>Title</th>
                                        <!--<th>Details</th>-->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="modules-list" name="modules-list">
                                    @foreach ($modules as $module)
                                    <tr id="module{{$module->id}}">
<!--                                        <td>{{$module->id}}</td>-->
                                        <td>{{$module->title}}</td>
                                        <!--<td>{{$module->description}}</td>-->
                                        <td>
                                            <button class="btn btn-secondary btn-detail open_modal" value="{{$module->id}}" title="Edit"><i class="fa fa-edit" ></i></button>
                                            <button class="btn btn-primary btn-detail open_doc" value="{{$module->id}}" title="Documents"><i class="fa fa-file-text-o" ></i></button>
                                            <button class="btn btn-warning open_ques" value="{{$module->id}}"  title="Questions"><i class="fa fa-question-circle"></i></button>
                                            |
                                            <button class="btn btn-success make_live" value="{{$module->id}}" title="Make Live"><i class="fa fa-plus-square-o" ></i></button>
                                            <button class="btn btn-danger btn-delete delete-module" value="{{$module->id}}" title="Delete"><i class="fa fa-remove" ></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="tab-pane" id="2">
                        <h3>Live Modules</h3>

                        <div class="panel-body"> 


                            <table class="table">
                                <thead>
                                    <tr>
<!--                                        <th>ID</th>-->
                                        <th>Title</th>
                                        <!--<th>Details</th>-->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="modules-list" name="modules-list">
                                    @foreach ($live_modules as $module)
                                    <tr id="module{{$module->id}}">
<!--                                        <td>{{$module->id}}</td>-->
                                        <td>{{$module->title}}</td>
                                        <!--<td>{{$module->description}}</td>-->
                                        <td>
                                            <button class="btn btn-secondary btn-detail open_modal" value="{{$module->id}}" title="Edit"><i class="fa fa-edit" ></i></button>
                                            <button class="btn btn-primary btn-detail copy_module" value="{{$module->id}}" title="Copy"><i class="fa fa-copy" ></i></button>
                                            <button class="btn btn-warning btn-detail preview_module" value="{{$module->id}}" title="Preview"><i class="fa fa-search" ></i></button>
                                            <button class="btn btn-danger btn-delete delete-module" value="{{$module->id}}" title="Delete"><i class="fa fa-remove" ></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>






        </div>
        @include('models.add_module')
        @include('models.document')
        @include('question.document') 
    </div>


    @endsection

    @section('heading')
    Modules <small>management</small>
    @endsection

    @section('title')
    Modules
    @endsection

    @section('script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/module.js')}}"></script>

    @endsection
