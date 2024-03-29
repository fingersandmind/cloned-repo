@extends('app.admin.layouts.default')


@section('title') {{{ $title }}} :: @parent @stop


@section('styles')

<link href="{{ asset('assets/globals/plugins/x-editables/css/bootstrap-editable.css') }}" rel="stylesheet"/>

<link href="{{ asset('assets/admin/css/plugins/bootstrap-wysihtml5-0.0.3.css') }}" rel="stylesheet"/>


@endsection


@section('main')



<div class="panel panel-flat" >

                        <div class="panel-heading">


                            <h4 class="panel-title">Payout Notification Settings</h4>
<div class="heading-elements">
                            <button id="enable" class="btn btn-primary">{{ trans('settings.enable_edit_mode') }}</button>
</div>



                            

                        </div>
                            <div class="panel-body"> 
                                <form id="settings">
                                <legend>Payout Notification Settings</legend>
                                @foreach($settings as $rank)
                                  <div class="col-sm-12">
                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                              <label  class="form-label" for="point_value">Mail Status:</label>   
                                            </div>
                                            <div class="col-sm-8">
                                              <a class="settings form-control" data-pk="{{$rank->id}}" data-type='select' 
                                            data-url='{{url("admin/payoutnotification")}}'  id="mail_status" data-title='select Status' data-name="mail_status">{{$rank->mail_status}}</a>
                                            
                                            </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-4">
                                            <label  class="form-label" for="point_value">{{trans('ticket_config.subject')}}:</label>    
                                          </div>
                                          <div class="col-sm-8">
                                            <a class="settings form-control" data-pk="{{$rank->id}}"  data-url='{{url("admin/payoutnotification")}}' data-type='text' id="subject" data-title='Enter subject' data-name="subject">{{$rank->subject}}
                                            </a>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-4">
                                            <label  class="form-label" for="point_value">Mail Content:</label>
                                          </div>
                                          <div class="col-sm-8" >
                                            <div class="settings form-control" data-url='{{url("admin/payoutnotification")}}' data-pk="{{$rank->id}}" data-type='wysihtml5' id="note" data-title='Enter content' data-name="mail_content" style="min-height:200px;min-width:50px">{!! $rank->mail_content !!}</div> 
                                          </div>
                                      </div>
                                </div>
                           </div>  
                          </form>
                         

                         @endforeach

                      </div>
</div>
            

@endsection

@section('scripts') @parent

      <script src="{{ asset('assets/admin/js/plugins/dataTables/jquery.colorbox.js') }}"></script>



       <script src="{{ asset('assets/admin/js/tag-it.min.js')}}"></script> 



      <script src="{{ asset('assets/admin/js/wysihtml5-0.3.0.js') }}"></script>



      <script src="{{ asset('assets/admin/js/bootstrap-wysihtml5.js') }}"></script>



      <script src="{{ asset('assets/admin/js/email-compose.demo.min.js') }}"></script>

      <script src="{{ asset('assets/admin/js/payoutnotification-editable.js') }}"></script>

       <script src="{{ asset('assets/globals/plugins/x-editables/js/bootstrap-editable.min.js') }}"></script>

        <script src="{{ asset('assets/globals/plugins/x-editables/js/bootstrap-editable.js') }}"></script>


         <script src="{{ asset('assets/admin/js/wysihtml5-0.3.0.min.js')}}"></script> 


         <script src="{{ asset('assets/admin/js/bootstrap-wysihtml5-0.0.3.min.js')}}"></script>  


        <script src="{{ asset('assets/admin/js/wysihtml5-0.0.3.js')}}"></script>  

        <script src="{{ asset('assets/admin/js/demo-mock.js')}}"></script>

        <script src="{{ asset('assets/admin/js/demo.js')}}"></script>

   <script>

        $(document).ready(function() {

            App.init();    

            EmailCompose.init();       

        });


    </script>

    @endsection 
    @section('scripts') @parent
     <script>
        $(document).ready(function() {
            App.init();           
        });
       

        
    </script>
    @endsection