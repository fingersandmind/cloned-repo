@extends('app.admin.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">
</style>
@endsection @section('main')
<!-- Basic datatable -->
<div class="panel panel-flat">
    <div class="panel-heading">


        <div class="row">
          <div class="col-sm-4">
              <h5 class="panel-title">Sales History </h5>            
          </div>
          <div class="col-sm-4">
            <a href="{{url('admin/product/saleshistory?filter=approved')}}" class="btn btn-info"> Approved </a> <a href="{{url('admin/product/saleshistory?filter=rejected')}}" class="btn btn-danger"> Rejected</a>            
          </div>          
        </div>

        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table class="table datatable-basic table-striped table-hover" id="" >
                      
       
        <thead class="">
            <tr >
                
                 <th>
                  {{trans('Username')}}
                 </th>
                <th>
                    {{trans('Address')}}
                </th>
                <th>
                  {{trans('Product Name')}}
                </th>
                <th>
                    {{trans('Quantity')}}
                </th>
                <th>
                   {{trans('comments')}}
                </th>
                <th>
                   {{trans('File')}}
                </th>
                <th>
                   {{trans('Request Amount')}}
                </th>
                <th>
                  {{trans('Date')}}
                </th>
                
            </tr>
        </thead>
        @foreach($purchasedata as $datas)
        <tbody>
         
           
            <tr class="">
              <td>
                {{$datas->username}}
              </td>
                <td>
               {{$datas->address}}
               <br> 
               Country : {{$datas->country}}
               
               State : {{$datas->state}} 
               <br>
               Zipcode : {{$datas->zipcode}}
                </td>
                <td>
                   {{$datas->productname}}
                </td>
                <td>
                   {{$datas->quantity}}
                </td>
                <td>
                   {{$datas->comments}}
                </td> 
                <td>
                   <a target="blank" class="btn btn-info" href="{{url('img/cache/original',$datas->file)}}"> View file </a>
                </td>
       
                <td>
                 {{$datas->amount}}
                </td>
                <td>
                  {{$datas->created_at}}
                </td>
              
                  
            </tr>
              
        </tbody>
         @endforeach
      
    </table>
</div>
@endsection