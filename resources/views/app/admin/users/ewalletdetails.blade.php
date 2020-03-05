@extends('app.admin.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">   Ewallet details </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>


     @include('app.admin.users.userinfo')

     
      <div class="panel-body">
      
    <div class="table-responsive">
    <table  class="table  ">
         <thead class="">
            <tr  >
                <th>
                    {{trans('users.username')}}
                </th>
                <th>
                    {{trans('users.amount')}}
                </th>
                <th>
                    {{trans('users.status')}}
                </th>
                <th>
                    {{trans('users.date')}}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ewallet as $refs)

            <tr class="">
                <td>
                    {{$refs->username}}
                </td>
                <td>
                    {{$refs->amount}}
                </td>
                <td>
                    {{$refs->status}}
                </td>
                <td>
                    {{$refs->created_at}}
                </td>
            </tr>
            @endforeach
        </tbody>
       
    </table>
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



 