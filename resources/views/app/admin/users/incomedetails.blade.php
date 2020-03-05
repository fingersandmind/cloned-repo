@extends('app.admin.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">   Income details </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>

      @include('app.admin.users.userinfo')
      <div class="panel-body">
         <table class="table">
            <thead>
                <th>No</th>
                <th>From</th>
                <th>Payment type</th>
                <th>Amount</th>
                <th>date</th>
            </thead>

            <tbody>
                @foreach($income as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value->username }}</td>
                    <td>{{  str_replace('_',' ',$value->payment_type) }}</td>
                    <td>{{ $value->payable_amount }}</td>
                    <td>{{ $value->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
             
         </table>

         {!!  $income->render() !!}
       


    </div>
</div>

          
        
                  
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
 <script type="text/javascript ">
   

</script>
@stop



 