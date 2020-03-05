@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop @section('styles') @parent @endsection {{-- Content --}} @section('main') @include('app.user.layouts.records')


@if(Auth::user()->confirmed != 1)
<div class="row">

    <div class="alert alert-warning" role="alert">    You can access the system after your accoutn verification , if you have any issues to verify the account please write to us contact@domain.com</div>

      <div class="text-center darken-grey-text mb-4">
                <h1 class="font-bold mt-4 mb-3 h5">Upload your documents for verifications</h1>
                 
            </div>

    <div class="col-sm-6 col-sm-offset-3 panel">
        <form action="{{url('user/savedocument')}}" method="post" enctype="multipart/form-data">
            {!!csrf_field()!!}
         <div class="form-group">
                <label>Full Name:</label>
                <input class="form-control" type="text" name="fullname" value="{{Auth::user()->name}}"  readonly="" placeholder="Enter Your Full Name"/> 
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input class="form-control" type="email" name="email" value="{{Auth::user()->email}}" readonly="" placeholder="Enter Your Email"/> 
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" type="file" name="file" required placeholder="Enter Password"/> 
            </div>
             
            <div class="form-group">
                <input class="btn btn-primary btn-block" type="submit" value="Submit"/>
            </div>
        </form>

    </div>

</div>

@else

<div class="row">
    <div class="col-sm-12">
        <div class="panel border-top-purple-300 border-bottom-purple-300">
            <div class="panel-heading">
                <h6 class="panel-title">Referral link</h6>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input id="replicationlink" type="text" readonly="true" class="selectall copyfrom form-control" spellcheck="false" value="{{url('/'.Auth::user()->username)}}" />
                    <span class="input-group-addon copylink">
                        <button class="btn btn-link btn-copy"  style="margin: 0 auto;padding: 0px;font-size: 12px;" data-clipboard-target="#replicationlink">
                        <i class="fa fa-copy"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="panel-footer"><a class="heading-elements-toggle"><i class="icon-more"></i></a>
            <div class="">
                <div class="text-semibold text-center">Share</div>
                <hr class="mb-5 mt-5" />
                <div class="panel-body text-center">
                    <button class="btn btn-info btn-labeled btn-xs btn-modal"
                    data-toggle="modal"
                    data-target="#fsModal">
                    <b><i class="icon-share2"></i></b>
                    Share your referral link to 100+ Social Pages!
                    </button>
                    <div id="fsModal" class="sharemodal modal animated bounceIn"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h5 class="modal-title"> Share your referral link across the web!!</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="share_target social_links" data-title="Cloudmlm was created solely out of the passion to raise everyone without exception" data-url="{{url('/')}}" data-img="{{ url('img/cache/original',$logo) }}" data-desc="A group envisions a world where all people can enjoy a life free of barriers to their full participation in the society. Where everyone can realize their potential and actualize their dreams." data-rurl="{{url('/')}}" data-via="cloudmlmsoft" data-hashtags="MLM,Software"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
</div>
<div class="row">
<div class="col-lg-7">
<div class="panel panel-flat">
    <div class="panel-heading">
        <h6 class="panel-title">
        {{trans('dashboard.users_join')}}
        </h6>
        <div class="heading-elements">
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-plus3"></i></a>
                    </li>
                    <li class="text-left">
                        <div class="text-semibold">Weekly Joining</div>
                        <div class="text-muted"></div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#" class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-watch2"></i></a>
                    </li>
                    <li class="text-left">
                        <div class="text-semibold">Montly Joining</div>
                        <div class="text-muted"></div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#" class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-people"></i></a>
                    </li>
                    <li class="text-left">
                        <div class="text-semibold">Yearly Joining</div>
                        <div class="text-muted">  </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr/>
    <div class="chart-container">
        <div class="chart has-fixed-height" id="joinings_graph" style="height:350px">
        </div>
    </div>
</div>
</div>
<div class="col-md-5">
    
    <div class="panel panel-body border-top-danger">
        <div class="panel-heading">
            <h6 class="panel-title text-semibold">Recent activities</h6>
        </div>
        @foreach($activities->chunk(10) as $chunk)
        <div class="col-sm-12">
            <ul class="list-feed media-list">
                @foreach($chunk as $activity)
                
                
                
                <li class="media">
                    <div class="media-body">
                        <a href="{{url('admin/userprofiles/')}}/{{$activity->username}}" target="_blank">{{$activity->name}}</a> {{$activity->description}}
                    </div>
                    <div class="media-right">
                        <ul class="icons-list icons-list-extended text-nowrap">
                            <li>
                                <a href="#"><i class="icon-bubble-dots4"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon-circle-right2"></i></a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endforeach
                
            </ul>
            
        </div>
        @endforeach
    </div>
</div>

</div> 

@endif
@endsection