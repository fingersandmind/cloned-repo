@extends('app.admin.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">   User Account </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
      <div class="panel-body">
        <div class="col-sm-6">
            <form action="{{url('admin/useraccounts')}}" class="smart-wizard form-horizontal" method="post"  >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
             
           
            <div class="form-group">
                <label class="col-sm-4 control-label" for="amount">
                     Username : <span class="symbol required"></span>
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="key-word" name="key-word" placeholder="Search Member">
                    <input type="hidden" id="key_user_hidden" name="key_user_hidden" >
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-4 control-label" for="amount">
                </label>
                <div class="col-sm-8">
                     <button class="btn btn-info" tabindex="4" name="Search" id="Search" type="submit" value="Search">  Search </button >              
                </div>
            </div>
   
        </form>
        </div>
       


    </div>
</div>

          
                                
 @if($request->has('key_user_hidden'))
         @include('app.admin.users.userinfo')
 @endif
                  
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript ">
   

</script>
@stop



 