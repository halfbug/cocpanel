

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <!--<button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>-->

            <div class="order btn-group btn-group-justified" role="group" aria-label="Order By">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" value='by_client'>Order by Clients</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" value="by_package">Order by Packages</button>
                </div>

            </div>
            <div class="detail">
                <!--Clients Order by Packages-->
                <div class="panel-body order_by_package"> 


       
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
                            @foreach($package->selected_modules as $module)

                            @php
                            $clients = $collection->where('coache_id',$assigned->id)
                            ->where('package_id',$package->id)
                            ->where('module_id',$module->id);
                            @endphp


                            <tr colspan="3" class="warning" id="packmodule_{{$package->id}}">
                                <td style="width: 40px;">--</td>
                                <td colspan="2">{{$module->title}}</td> 
                                @if($clients->count() > 0)
                                <td><button class="btn btn-warning viewclients" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-arrow-circle-o-down" ></i></button></td>
                                @else
                                <td><button class="btn btn-warning viewclients disabled" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-arrow-circle-o-down" ></i></button></td>
                                @endif
                            </tr>

                            @foreach($clients as $client)
                            <tr colspan="3" class="success" id="packclient_{{$package->id}}-{{$module->id}}">
                                <td style="width: 40px;">-></td>
                                <td>{{$client->user->name}}</td>
                                <td>{{$client->getStatus()}}</td>
                                <td><a class="btn btn-info btn-detail preview_module" href="{{ url('assigned/'.$client->id) }}" title="Preview"><i class="fa fa-search" ></i></a></td>

                            </tr>
                            @endforeach
                            @endforeach

                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="order_by_client">
                    <table class="table" id="activeClientstbl">
                        <thead>
                            <tr>
    <!--                                        <th>ID</th>-->
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="client_active" name="client_active">
                            @foreach($collection->whereIn('coache_id',$assignments->pluck('id'))->unique('user_id') as $client)
                            <tr>
                                <td colspan="3">{{$client->user->name}} </td>
                            </tr>
                            @foreach($client->getPackages(null,$collection) as $package)
                            <tr class="info">
                                <td colspan="3">{{$package->title}} </td>
                            </tr>   
                            @foreach($package->selected_modules as $module)
                            <tr class="success">
                                <td>{{$module->title}} </td>

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
                                $activeModule=$collection->where('module_id',$module->id)->where('package_id',$package->id)->where('user_id',$client->user_id)->first();
                                $isActive=($activeModule == null)?false:true;
                                @endphp

                                <td>
                                    <form enctype='multipart/form-data' class="form-horizontal" role="form" method="POST"  id="statusform_{{$client->user_id}}" action="{{ url('assigned/update_status') }}">
                                        {{ csrf_field() }}
                                        <select class="form-control" name="status" id="module_status_{{$client->user_id}}">

                                            @foreach($client->getAllStatus() as $index=>$status) 
                                            @if($isActive) 
                                            @if($index == $activeModule->status)
                                            <option value="{{$index}}" selected="true">{{$status}}</option>
                                            @else 
                                            <option value="{{$index}}" >{{$status}}</option>   
                                            @endif
                                            @elseif($index == 2)
                                            <option value="{{$index}}" selected="true">{{$status}}</option>
                                            @else 
                                            <option value="{{$index}}" >{{$status}}</option>       
                                            @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="assignment_id" value="{{($isActive) ? $activeModule->id : '0' }}" />
                                        <input type="hidden" name="package_id" value="{{$package->id }}" />
                                        <input type="hidden" name="module_id" value="{{$module->id }}" />
                                        <input type="hidden" name="user_id" value="{{$client->user_id }}" />
                                        <input type="hidden" name="coache_id" value="{{Auth::user()->id }}" />
                                    </form>
                                </td>
                                <td>
                                    @if($isActive)
                                    <a class="btn btn-info btn-detail preview_module" href="{{ url('assigned/'.$activeModule->id) }}" title="Preview"><i class="fa fa-search" ></i></a></td>
                                @endif
                            </tr>   
                            @endforeach
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>


            </div><!-- end of detail -->




                                
                               
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
>>>>>>> origin/master
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
        $('.detail div').hide();
        $('.order_by_client').show();
        $('.btn-group .btn:first').addClass("btn-primary");
    });
    $(document).on('click', '.viewmodules', function (e) {
        var package_id = $(this).val();
        $('[id^=packmodule_' + package_id + ']').toggle();
        console.log(package_id);
    });
    $(document).on('click', '.viewclients', function (e) {
        var package_id = $(this).val();
        $('[id^=packclient_' + package_id + ']').toggle();
    });

    $('.btn-group .btn').on('click', function () { // On the click event for each button
        $('.btn-group .btn').removeClass('btn-primary');
        $(this) // get the button being clicked
                .addClass('btn-primary'); // add the `btn-primary` class
//    .siblings('.btn-primary') // get all sibling buttons which may already be selected
//    .removeClass('btn-primary'); // remove the selected class
//        alert($(this).val());
        $('.detail div').hide();
        $('.order_' + $(this).val()).show();
    });

    $('[id^=module_status]').change(function () {
        alert("Handler for .change() called.");
        //$('[id^=statusform').submit();
        $(this).parents('form').submit();
    });
</script>
@endsection