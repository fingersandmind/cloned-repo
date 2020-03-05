@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
 
@endsection @section('main')


 

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details  
                    </h3>
                    
                </div>
                <div class="panel-body">
                    
                    <div class="row">
                         <div class="text-center">
                            <img src="{{ url('img/cache/original/t_3855625.png')}}">
                        </div>                         
                    </div>                     

                    <p>
                      We are waiting the payment responce ,  You will redirect automatically once you we are finished.

                    </p>
                </div>
            </div>
            
            <span> <img class="ajax-loader" src="{{ url('img/cache/original/ajax-loader.gif')}}"> <span class="loader-text">Checking for your payment</span></span>
                 
        </div>
    </div>
</div>

@stop

{{-- Scripts --}}
@section('scripts')
    @parent

 <script type="text/javascript">
     setInterval(function(){
            $.get("{{url('ajax/get-bitaps-status/'.$setting->id,$setting->username)}}", function( data ) { 
                 if(data['status'] == 'finished'){
                        window.location.href = '/user/creditfund';
                 }
                 if(data['status'] == 'complete'){
                            $(".ajax-loader").attr("src","{{ url('img/cache/original/ajax-processing.gif')}}");
                            $(".loader-text").html(" Payment received processing your request");

                 }
            });
     }, 4000);

 </script>
 
@stop



 