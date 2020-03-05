@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
 
@endsection @section('main')


  

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details  
                    </h3>
                    
                </div>
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label for="cardNumber">BTC {{$package_amount}} </label>
                        <div class="input-group">
                            <input type="text" class="form-control selectall copyfrom form-control" readonly="" id="cardNumber" value="{{$payment_details->address}}"
                                required autofocus />
                            <span class="input-group-addon"  data-clipboard-target="#replicationlink"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                    <div class="row">
                         <div class="text-center">
                            <img src="https://bitaps.com/api/qrcode/png/{{$payment_details->address}}">
                        </div>                         
                    </div>                     

                    <p>
                       make your payment of    <b>BTC {{$package_amount}} </b> to the above wallet , when your payment processed then system will redirect you automatically,

                    </p>
                </div>
            </div>
            
            <span> <img class="ajax-loader" src="{{ url('img/cache/original/ajax-loader.gif')}}"> <span class="loader-text">waiting for your payment</span></span>
                 
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



 