@extends('app.admin.layouts.default')


{{-- Web site Title --}}
@section('title') {{{ $title }}} :: @parent @stop


@section('styles')

@endsection

{{-- Content --}}
@section('main')

<div class="panel panel-flat" >
    <div class="panel-heading">
        <h4 class="panel-title">{{ trans('packages.plan_settings') }} </h4> 
        <div class="heading-elements"> 
          <button id="enable-package-edit" type="submit" class="btn btn-primary">{{trans('packages.enable_edit_mode')}}</button> 
      </div>
  </div>

  <div class="panel-body"> 
    <form id="settings">  
        <table class="table table-striped">
            <thead> 
                <th>{{ trans('packages.spot_plan_name') }} </th>
                <th>{{ trans('packages.fee') }}</th>
               <!--  <th>{{ trans('packages.level_1') }}</th>
                <th>{{ trans('packages.level_2') }}</th>
                <th>{{ trans('packages.level_3') }} </th>                                
                <th>{{ trans('packages.level_4') }} </th>                                
                <th>{{ trans('packages.level_5') }} </th>                                
                <th>{{ trans('packages.board') }} </th>     -->                            
            </thead>
            <tbody>
                                @foreach($matrix1 as $item)

                                <tr>
                                    <td>  <a class="settings" id="package{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter  Spot plan name " data-name="package">
                                                
                                              {{$item->package}}  </a> </td>

                                    <td> <a class="settings" id="amount{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="amount">
                                                
                                             {{$item->amount}}  </a> </td>

                                    <!--  <td> <a class="settings" id="level_1{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="level_1">
                                                
                                             {{$item->level_1}}  </a> </td>

                                     <td> <a class="settings" id="level_2{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="level_2">
                                                
                                             {{$item->level_2}}  </a> </td>

                                     <td> <a class="settings" id="level_3{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="level_3">
                                                
                                             {{$item->level_3}}  </a> </td>

                                     <td> <a class="settings" id="level_4{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="level_4">
                                                
                                             {{$item->level_4}}  </a> </td>

                                     <td> <a class="settings" id="level_5{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="level_5">
                                                
                                             {{$item->level_5}}  </a> </td>

                                     <td> <a class="settings" id="board{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter amount" data-name="board">
                                                
                                             {{$item->board}}  </a> </td> -->

                                    

                                           
                                </tr> 


                                @endforeach
                                
                            </tbody>


                          </table>                           
                       
                    
                    </form>

                   
                        
                        
                       
                </div>
            </div>


 
@endsection

