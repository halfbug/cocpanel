

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
                            <!--<th style="width: 40px;"></th>-->
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="clients-list" name="clients-list">
                      @foreach ($assignments as $assigned)
                        @foreach ($assigned->package()->get() as $package)
                        <tr id="package_{{$package->id}}" class="package_row">
                            <!--<td>+</td>-->
                            <td>{{$package->title}}</td>
                            <td>{{$package->description}}</td> 

                            <td><button class="btn btn-success viewmodules" value="{{$package->id}}" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Modules</button></td>

                        </tr>
                    
                            @foreach($package->selected_modules as $module)
                            @if($loop->index == 0)
                            <tr id="packmodule_{{$package->id}}" class="active_modules"><td colspan="3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Modules</h3>
                                        </div>
                                        <div class="panel-body">                    

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!--<th style="width: 40px;"></th>-->
                                                        <th>Name </th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th width="50">Action</th>                
                                                    </tr>
                                                </thead>
                                                <tbody id="clients-list" name="clients-list">                            
                                                    @endif
                                
                                @php
                                $clients = $collection->where('coache_id',$assigned->id)
                                ->where('package_id',$package->id)
                                ->where('module_id',$module->id);
                                @endphp
                                
                               
                                <tr colspan="3" class="warning">  <!--id="packmodule_{{$package->id}}"-->
                                    <!--<td style="width: 40px;">--</td>-->
                                    <td>{{$module->title}}</td>
                                    <td>{{$module->description}}</td>
                                    @if($clients->count() > 0)
                                    <td class="success">{{$assigned->first()->getStatus()}}</td>
                                    <td><button class="btn btn-warning viewclients" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-caret-square-o-down" ></i> Show Clients</button></td>
                                    @else
                                    <td class="danger">Pending</td>
                                    <td><button class="btn btn-warning viewclients disabled" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-caret-square-o-down" ></i> Show Clients</button></td>
                                    @endif
                                </tr>
                                
                                @foreach($clients as $client)
                                <tr colspan="3" class="success package_client" id="packclient_{{$package->id}}-{{$module->id}}">
                                    <!--<td style="width: 40px;">-></td>-->
                                    <td>{{$client->user->name}}</td>
                                    <td>{{$client->getStatus()}}</td>
                                    <td>&nbsp;</td>
                                    <td><a class="btn btn-info btn-detail preview_module" href="{{ url('assigned/'.$client->id) }}" title="View Client"><i class="fa fa-search" ></i>  View Client</a></td>
                                </tr>
                                @endforeach

                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                        </div>
                                </td>
                            </tr>
                            @endif


                            @endforeach
                        
                        @endforeach
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--incluides here-->
    </div>
</div>

@endsection

@section('heading')
Coach <small>management</small>
@endsection

@section('title')
Coach
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<script src="{{asset('js/client.js')}}"></script>-->
<script>
    $(document).ready(function () {
        console.log("ready!");
        $('[id^=packmodule_]').hide();
        $('[id^=packclient_]').hide();
    });
    $(document).on('click', '.viewmodules', function (e) {
        var package_id = $(this).val();
        $('[id^=packmodule_'+package_id+']').toggle();
       console.log(package_id);
    });
    $(document).on('click', '.viewclients', function (e) {
        var package_id = $(this).val();
       $('[id^=packclient_'+package_id+']').toggle();
    });
</script>
@endsection