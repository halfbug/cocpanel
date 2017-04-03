

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-10">
        <div class="panel panel-default panel-shadow">
            <div class="panel-body">
                {{$module->description}}

            </div>

        </div>
        @foreach ($module->questions()->get() as $question)        
        <div class="col-sm-12">
            <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                    <div class="pull-left image">
                        <img src="../../images/question.png" class="img-circle avatar" alt="q">
                    </div>
                    {!!$question->content!!}

                </div> 
                <div class="post-footer">
                    <ul class="comments-list">
                        {{$assignment }}
                        @if($assignment)
{{$question->getDiscussion($question,$assignment) }}
{{$question->id}} {{$assignment->id}}
                        @foreach ( $question->getDiscussion($question,$assignment) as $response )  

                        <li class="comment">
                            <a class="pull-left" href="#">
                                <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
                            </a>
                            <div class="comment-body">

                                <div class="comment-heading">
                                    <h4 class="user">{{$response->getAName($response->user_id)}}</h4>

                                    <h5 class="time"> {{$response->getTime($response->response_id)}}</h5>
                                </div>
                                <p>{!!$response->getContent($response->response_id)!!}</p>  
                            </div>

                        </li>


                        @endforeach
                        @endif 
                    </ul>
                    <div class="input-group"> 
                        <form class="form-horizontal" role="form" method="POST"  action="{{ url('assigned/'.$assignment->package_id.'/'.$module->id) }}">
                            {{ csrf_field() }}
                            <textarea class="form-control input-lg" name="content" placeholder="Add a responce" type="text">
                            </textarea>                        
                            <input type="hidden" name="assignment_id" value="{{$assignment->id}}">
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <input type="hidden" name="responseby" value="{{Auth::user()->id}}">


                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default  right" >
                                    <i class="fa fa-edit">Submit</i>
                                </button>  
                            </span>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @endforeach

        @endsection

        @section('heading')
        {{$module->title}} 
        @endsection

        @section('title')
        {{$module->title}}Modules
        @endsection

        @section('breadcrumbs')
        <!--<i class="fa fa-file"></i>-->
        {{$module->title}}Modules
        @endsection

        @section('script')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{asset('js/module.js')}}"></script>
        @endsection

        @section('css')
        <style>

            .panel-shadow {
                box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
            }
            .panel-white {
                border: 1px solid #dddddd;
            }
            .panel-white  .panel-heading {
                color: #333;
                background-color: #fff;
                border-color: #ddd;
            }
            .panel-white  .panel-footer {
                background-color: #fff;
                border-color: #ddd;
            }

            .post .post-heading {
                /*height: 95px;*/
                padding: 20px 15px;
            }
            .post .post-heading .avatar {
                width: 60px;
                height: 60px;
                display: block;
                margin-right: 15px;
            }
            .post .post-heading .meta .title {
                margin-bottom: 0;
            }
            .post .post-heading .meta .title a {
                color: black;
            }
            .post .post-heading .meta .title a:hover {
                color: #aaaaaa;
            }
            .post .post-heading .meta .time {
                margin-top: 8px;
                color: #999;
            }
            .post .post-image .image {
                width: 100%;
                height: auto;
            }
            .post .post-description {
                padding: 15px;
            }
            .post .post-description p {
                font-size: 14px;
            }
            .post .post-description .stats {
                margin-top: 20px;
            }
            .post .post-description .stats .stat-item {
                display: inline-block;
                margin-right: 15px;
            }
            .post .post-description .stats .stat-item .icon {
                margin-right: 8px;
            }
            .post .post-footer {
                border-top: 1px solid #ddd;
                padding: 15px;
            }
            .post .post-footer .input-group-addon a {
                color: #454545;
            }
            .post .post-footer .comments-list {
                padding: 0;
                margin-top: 20px;
                list-style-type: none;
            }
            .post .post-footer .comments-list .comment {
                display: block;
                width: 100%;
                margin: 20px 0;
            }
            .post .post-footer .comments-list .comment .avatar {
                width: 35px;
                height: 35px;
            }
            .post .post-footer .comments-list .comment .comment-heading {
                display: block;
                width: 100%;
            }
            .post .post-footer .comments-list .comment .comment-heading .user {
                font-size: 14px;
                font-weight: bold;
                display: inline;
                margin-top: 0;
                margin-right: 10px;
            }
            .post .post-footer .comments-list .comment .comment-heading .time {
                font-size: 12px;
                color: #aaa;
                margin-top: 0;
                display: inline;
            }
            .post .post-footer .comments-list .comment .comment-body {
                margin-left: 50px;
            }
            .post .post-footer .comments-list .comment > .comments-list {
                margin-left: 50px;
            }

        </style>
        @endsection
