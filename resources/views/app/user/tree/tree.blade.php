@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop 

@section('meta_keywords')@parent  <meta name="root-id" content="{{$root}}"/>@endsection
@section('styles') @parent @endsection {{-- Content --}} @section('main')
<div class="panel panel-flat border-top-success">
    <div class="panel-heading">
        <h6 class="panel-title">{{trans('tree.sponsor_genealogy')}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="row mb-10">
            
        </div> 
        
        <div class="overflow"> 
                      <div id="jstree-ajax" class="jstree jstree-4 jstree-default" role="tree"> 

             
        </div>
    </div>
</div>
@endsection
 