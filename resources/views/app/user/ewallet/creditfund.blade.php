@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">{{trans('ewallet.credit_fund')}}</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
      <div class="panel-body">
        <div class="col-sm-6">
            <form action="{{url('user/creditfund')}}" class="smart-wizard form-horizontal" method="post"  >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
             
           
            <div class="form-group">
                <label class="col-sm-4 control-label" for="amount">
                    {{trans('wallet.amount')}} : <span class="symbol required"></span>
                </label>
                <div class="col-sm-8">
                    <input type="text" id="amount" name="amount" class="form-control" required="" >
                </div>
            </div>

              <div class="form-group">
                <label class="col-sm-4 control-label" for="amount">
                    payment method : <span class="symbol required"></span>
                </label>
                <div class="col-sm-8">
                    <label class="radio-inline"><input type="radio" name="payment" value="bitcoin" checked>Bitcoin</label>
                    <label class="radio-inline"><input type="radio" name="payment" value="paypal">Paypal</label>
                    <label class="radio-inline"><input type="radio" name="payment" value="ipaygh">Ipaygh</label>

                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-4 control-label" for="amount">
                </label>
                <div class="col-sm-8">
                     <button class="btn btn-info" tabindex="4" name="add_amount" id="add_amount" type="submit" value="Add Amount"> {{trans('wallet.add_amount')}}</button >              
                </div>
            </div>
   
        </form>
        </div>
       


    </div>
</div>
                  
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript ">
   

</script>
@stop



 