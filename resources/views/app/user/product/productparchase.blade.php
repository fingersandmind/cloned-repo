
@extends('app.user.layouts.default') {{-- Web site Title --}} @section('title') {{{ $title }}} :: @parent @stop {{-- Content --}} @section('styles') @parent
<style type="text/css">

</style>
@endsection @section('main')
<!-- Basic datatable -->
<h1>Product Purchase</h1>


<div class="row">
  
  <div class="col-sm-9 ">
    

<div class="shopping-cart">
  <div class="well">
   
      <div class="row" >
@foreach($product_datas as $key => $items) 
    
          
            <div class="col-sm-3">

              <div class="well">
                <div class="product-image">
                  <img src="{{url('/assets/uploads/'.$items->image)}}" style="width: 100px;">
                </div>
                <div class="product-details">
                  <div class="product-title" style="color:black;font-size: 20px;" align="center"> {{$items->productname}}</div>
                </div>
                <br>
                <div class="product-quantity" style="color:black" align="center">Code : {{$items->categoryname}}</div>
                <div align="center">
                  <button type="button" class="fa fa-shopping-cart btn btn-info" data-toggle="modal" data-target="#myModals{{$items->id}}">ADD TO CART</button>
                </div>
              </div> 
            </div> 
        
            

            <div class="modal fade" id="myModals{{$items->id}}" role="dialog">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="modal-body">
                      <input name="requestid" type="hidden" value="{{$items->id}}">
                      <div class="well" style="width:70px;"><img src="{{url('/assets/uploads/'.$items->image)}}" style="width:40px;"></div>
                      <h7 class="modal-title"  style="color:black" align="left">{{$items->productname}}</h7>
                      <h8 class="modal-title" style="color:black">X</h8>
                      <h8 class="modal-title" style="color:black">{{$items->quantity}} {{$items->category}}</h8>
                      <div class="col-sm-8" align="left" style="color:black;margin-top: 20px;">Sub Total : {{$items->amount}} </div>
                      <div class="col-sm-12" style="color:black;" align="left">Quantity :  {{$items->quantity}} </div>
                      <div class="col-sm-8" style="color:black;" align="left">Amount Payable :  {{$items->amount}} </div>
                      <div style="color:black;margin-top: 80px;"> <!-- <a href="{{url('user/productparchase/')}}"> <button class="btn btn-alert fa fa-shopping-cart btn btn-alert" type="button">{{trans('View Cart')}}</button></a> --><button class="btn btn-info" style="color:black;" onclick="openmodal({{ $items }} )">{{trans('checkout')}}</button></div>

                      <div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" type="button">{{trans('all.close')}}</button></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
                        
      @endforeach


 </div>
</div>
</div>


  </div>

  <div class="col-sm-3">

      <div class="panel">
        <ul class="list-group">

          @foreach($categories as $citem)
              <li class="list-group-item"><a href="{{url('user/productparchase?filter='.$citem->id)}}" class="btn">{{$citem->name}}</a></li> 
          @endforeach
            </ul>

      </div>


    
  </div>

</div>

 <div id="myModal" class="modal fade" role="dialog">
 <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 style="color:black;" class="modal-title">
                                                    {{trans('Checkout')}}
                                                </h4>
                                            </div>
                                            <div class="modal-body">     

                                                           <div class="panel-body">
    <form action="{{url('user/product/productparchase')}}" class="smart-wizard form-horizontal" method="post"  enctype="multipart/form-data" >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <input name="requestid" type="hidden" value="{{$items->id}}">
        <table class="table-responsive">
          <tr>
            <td>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="username" >
             {{trans('Username')}}: <span class="symbol required"></span>
            </label>
            <div class="col-sm-8">
                <input type="text" id="username" name="username" placeholder="username"  value="{{Auth::user()->username}}" class="form-control" readonly="readonly" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="address" >
             {{trans('Address')}}: <span class="symbol required"></span>
            </label>
            <div class="col-sm-8">
                <input type="text" id="address" name="address" placeholder="Address"  class="form-control" required value="{{$profile[0]['address1']}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="country" >
                 {{trans('Country')}}: <span class="symbol required"></span>
            </label>
                <div class="col-sm-8">
                <input type="text" id="countrys" name="country" placeholder="Country"  class="form-control" required value="{{ $country }} ">
            </div>           
        </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="state" >
                 {{trans('State')}}: <span class="symbol required"></span>
            </label>
                <div class="col-sm-8">
                <input type="text" id="state21" name="state" placeholder="State"  class="form-control" required value="{{$profile[0]['state']}}">
            </div>           
        </div>
         <div class="form-group">
            <label class="col-sm-4 control-label" for="city" >
                 {{trans('City')}}: <span class="symbol required"></span>
            </label>
                <div class="col-sm-8">
                <input type="text" id="city" name="city" placeholder="City"  class="form-control" required value="{{$profile[0]['city']}}">
            </div>           
        </div>
         <div class="form-group">
            <label class="col-sm-4 control-label" for="zipcode" >
                 {{trans('Zip Code')}}: <span class="symbol required"></span>
            </label>
                <div class="col-sm-8">
                <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code"  class="form-control" required value="{{$profile[0]['zip']}}">
            </div>           
        </div>
</div>
</td>
<td>




  <div class="alert alert-info" style="margin-left: 100px;width:400px;">
    <label class="col-sm-4 control-label" for="" align="left" style="color:black;width:150px;">
                 {{trans('Product Name')}} : <span class="symbol required"></span>
    </label> 
    <div align="right" class="col-sm-20" style="color:black;">
      <input style="width:100px;" name="productname" class="form-control" readonly value=""> 
  </div>
  <br>
    <label class="col-sm-4 control-label" for="" align="left" style="color:black;width:150px;">
                 {{trans('Quantity')}} : <span class="symbol required"></span>
    </label>   
    <div align="right" class="col-sm-20" style="color:black;">
      <input style="width:100px;" name="quantity" id="quantity" class="form-control" min="1"  value="1"> 
  </div>
  <br>
  <label class="col-sm-4 control-label" for="" align="left" style="color:black;width:150px;">
                 {{trans('Price')}} : <span class="symbol required"></span>
  </label>   
  <div align="right" class="col-sm-20" style="color:black;">
    <input style="width:100px;" name="pv" class="form-control" readonly value=""> 
    <input style="width:100px;" name="amount" class="form-control" type="hidden" value=""> 
  </div>
  <br>
 
  <br> 
 
</div>



  <div class="alert alert-info" style="margin-left: 100px;width:400px;">

     <div class="row">
          <label class="col-sm-4 control-label" for="" align="left" style="color:black;width:150px;">
                  Upload payment slip  <span class="symbol required"></span>
            </label>   
   <div align="right" class="col-sm-20" style="color:black;">
     <input style="width:100px;" name="paymentslip" class="form-control" readonly value="{{$items->productname}}" type="file"> 
    </div>       
     </div>

     <div class="row">
        <label class="col-sm-4 control-label" for="" align="left" style="color:black;width:150px;">
                  Commetns  <span class="symbol required"></span>
            </label>   
   <div align="right" class="col-sm-20" style="color:black;">
      <textarea name="comments" class="form-control"></textarea>
    </div> 
     </div>
<br>
   
 
</div>

<button class="btn btn-success" style="color:white;background-color: darkblue;margin-left: 200px;" name="submit" type="submit">{{trans('checkout')}}
  </button>
                                                        <!-- </input> -->
  </input>
</form>
    </div>
                                           
      </div>
           </div>
        </div>
      </div>
       </td>
   
         </tr>
  </table>          
@stop
@section('scripts') @parent
<script>
   $('#quantity').on('change',function(e){
  
    $('input[name="pv"]').val($( this ).val() * $('input[name="amount"]').val());

 
});

   function openmodal(data){

    $('input[name="productname"]').val(data.productname);
    $('input[name="pv"]').val(data.amount);
    $('input[name="amount"]').val(data.amount);

    $("#myModal").modal("show");
   }


 </script>
@endsection

 
 
