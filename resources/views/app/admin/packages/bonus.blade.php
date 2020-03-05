@extends('app.admin.layouts.default')


{{-- Web site Title --}}
@section('title') {{{ $title }}} :: @parent @stop


{{-- Content --}}
@section('main')




<div class="panel panel-flat" >
                        <div class="panel-heading">
                            
                            <h4 class="panel-title">{{trans('packages.incentives_management')}}</h4> 

                            

                             <div class="heading-elements"> 
  <button id="leadership" type="submit" class="btn btn-primary">{{trans('packages.enable_edit_mode')}}</button> 
</div>


                        </div>
                        <div class="panel-body"> 
                          <form id="leadership-form">  


                          <table class="table table-striped">
                            <thead> 
                                                               
                                <th>{{trans('packages.package')}}</th>                                 
                                <th>{{trans('packages.level_1')}}</th>                                 
                                <th>{{trans('packages.level_2')}}</th>                                 
                                <th>{{trans('packages.level_3')}}</th>                                 
                                <th>{{trans('packages.level_4')}}</th>                                 
                                <th>{{trans('packages.level_5')}}</th>                                 
                            </thead>
                            <tbody>
                                @foreach($settings as $item)

                                <tr>
                                    <td>  {{$item->package}}  </td>

                                    <td> <a class="leadership" id="amount{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter level 1" data-name="level_1">
                                                
                                             {{$item->level_1}}  </a> </td>

                                    <td><a class="leadership" id="pv{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter level 2" data-name="level_2">
                                                
                                           {{$item->level_2}} </a> </td>
                                   <td><a class="leadership" id="pv{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter level 3" data-name="level_3">
                                                
                                           {{$item->level_3}} </a></td>
                                  
                                   <td><a class="leadership" id="pv{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter level 4" data-name="level_4">
                                                
                                           {{$item->level_4}} </a></td>

                                    <td><a class="leadership" id="pv{{$item->id}}" data-type='text' data-pk="{{$item->id}}" data-title="Enter level 5" data-name="level_5">
                                                
                                           {{$item->level_5}} </a></td>


                                </tr> 
                                @endforeach                                
                            </tbody>
                         </table>                                               
                    </form>
                    
                        
                        
                       
                </div>
            </div>




           
@endsection
