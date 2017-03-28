

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
                            <th style="width: 14px;"></th>
                            <th>Name </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="clients-list" name="clients-list">
                        @foreach ($coaches as $coache)
                        <tr id="coache_{{$coache->id}}">
                            <td>+</td>
                            <td>{{$coache->getName($users)}}</td>

                            <td></td>

                            <td>

                                <!-- butons here-->
                            </td>
                        </tr>
                        @foreach ($coache->getClients($users,$collection) as $client)
                        <tr class="success">
                            <td>-</td>
                            <td>{{$client->name}}</td>  
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
@endsection
