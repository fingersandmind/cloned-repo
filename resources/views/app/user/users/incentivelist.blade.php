@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Incentives</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table class="table table-striped">
         @if(count($incentives)>0)
                            <thead>
                                <tr>
                                    <th>
                                       Stage
                                    </th>
                                    <th>
                                        Level
                                    </th>
                                    <th>
                                       Incentive
                                    </th>
                                    <th>
                                       Status
                                    </th>
                                  
                                    <th>
                                        {{trans('ewallet.date')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incentives as $key=> $report)
                             <tr>
                                    <td>
                                     {{$report->package}}  
                                    </td>
                                    <td>
                                      {{$report->level}} 
                                    </td>
                                    <td>
                                      {{$report->incentive}}
                                    </td>
                                    <td>
                                      {{$report->status}}
                                    </td>
                                  
                                    <td>
                                       {{$report->created_at}}
                                    </td>
                               </tr>
                            @endforeach
                        </tbody>
                        @else
                        <tr class="">
                            <td>
                              No data found
                            </td>
                        </tr>
                        @endif
                    </table>
                    </div>
                  
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript ">
   

</script>
@stop