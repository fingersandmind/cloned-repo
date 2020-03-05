@extends('layouts.auth')
@section('content')


 

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Please wait processing your request 
                    </h3>
                    
                </div>
                <div class="panel-body">
                    
                    <div class="form-group">
                        
                        
                                        

                    <p>
                      Your registration is processing now , once it is finshed you will be redirected to the preivew and then you can login , 

                    </p>
                </div>
            </div>
            
            <span> <img class="ajax-loader" src="{{ url('img/cache/original/ajax-loader.gif')}}"> <span class="loader-text">waiting to finish processing </span></span>
                 
        </div>
    </div>
</div>



@endsection

@section('topscripts')
@parent

@endsection

@section('scripts')
@parent
 
 <script type="text/javascript">
     setInterval(function(){
            $.get("{{url('ajax/get-bitaps-status/'.$setting->id,$setting->username)}}", function( data ) { 
                 if(data['status'] == 'finished'){
                        window.location.href = '/register/preview/'+data['id'];
                 }
                 if(data['status'] == 'complete'){
                            $(".ajax-loader").attr("src","{{ url('img/cache/original/ajax-processing.gif')}}");
                            $(".loader-text").html(" Payment received processing your request");

                 }
            });
     }, 4000);

 </script>
  
@endsection
