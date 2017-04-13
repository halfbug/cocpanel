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
                            <!--<th style="width: 100px;"></th>-->
                            <th>Name </th>
                            <!--<th> </th>
                            <th> </th>-->
                        </tr>
                    </thead>
                    <tbody id="coach-list" name="coach-list">
                        @foreach ($coaches as $coach)
                        <tr id="coache_{{$coach->id}}" class="coaches_coach">
                            <!--<td>C</td>-->
                            <td><strong>[Coach]</strong> {{$coach->email}}</td>
                            <td><button class="btn btn-success viewpackages" value="{{$coach->id}}" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Packages</button></td>
                            <!--<td></td>-->
                        </tr>
                        @php
                        $pack =$collection->where('role_id', \App\role::coache())->where('user_id',$coach->id)->unique("package_id")->pluck("package_id");
                        $packages= \App\package::whereIn("id",$pack)->get();
                        @endphp

                        @foreach ($packages as $package)
                            @if($loop->index == 0)
                            <tr id="packmodule_{{$coach->id}}" class="coach_packages"><td colspan="3">                 
                                            <table class="table">
                                                <tbody id="clients-list" name="clients-list">                            
                                                    @endif
                        <tr class="coaches_pkg">
                            <!--<td></td>-->
                            <td>&nbsp;&nbsp;&nbsp; <strong>[Package]</strong> &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;{{$package->title}}</td>  
                        </tr>
                        @foreach ($package->selected_modules as $module)
                        <tr class="coaches_pkg_module">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>[Module]</strong> &nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;{{$module->title}}</td>  
                        </tr>
                        @endforeach


                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                </td>
                            </tr>
                            @endif
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
<script>
    $(document).ready(function () {
        console.log("ready!");
        $('[id^=packmodule_]').hide();
    });
    $(document).on('click', '.viewpackages', function (e) {
        var package_id = $(this).val();
        $('[id^=packmodule_'+package_id+']').toggle();
    });
</script>
@endsection