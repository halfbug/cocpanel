

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <button id="btn_add_coach" name="btn_add_coach" class="btn btn-secondary pull-right" >New Coach</button>



            <!--Clients Order by Packages-->
            <div class="panel-body"> 


                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 30px;"></th>
                            <th>Name </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="coach-list" name="coach-list">
                        @foreach ($coaches as $coach)
                        <tr id="coache_{{$coach->id}}">
                            <td>+</td>
                            <td>{{$coach->name}}</td>

                            <td></td>

                            <td>

                                <!-- butons here-->
                            </td>
                        </tr>
                        @php
                        $pack =$collection->where('role_id', \App\role::coache())->where('user_id',$coach->id)->unique("package_id")->pluck("package_id");
                        $packages= \App\package::whereIn("id",$pack)->get();
                        @endphp

                        @foreach ($packages as $package)
                        <tr class="success">
                            <td>-</td>
                            <td>{{$package->title}}</td>  
                        </tr>
                        @foreach ($package->selected_modules as $module)
                        <tr class="warning">
                            <td>--</td>
                            <td>{{$module->title}}</td>  
                        </tr>
                        @endforeach
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>




        </div>
        <!--       incluides here-->
        @include('modals.add_coach')
    </div>






</div>





@endsection

@section('heading')
Coaches <small>management</small>
@endsection

@section('title')
Coaches
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/coaches.js')}}"></script>
@endsection
