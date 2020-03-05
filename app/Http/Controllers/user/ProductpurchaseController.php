<?php

namespace App\Http\Controllers\user;

use App\Product;
use App\ProductPurchase;
use App\Http\Controllers\Admin\AdminController;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Response;
use Session;
use Validator;
use Redirect;

class ProductpurchaseController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $settings = ProductPurchase::all();

        $title     = trans('Product Purchase');
        $sub_title = trans('Product Purchase');
        $base      = trans('Product Purchase');
        $method    = trans('Product Purchase'); 

        $product_datas = Product::all();

        return view('app.user.product.productparchase', compact('title', 'settings', 'product_datas', 'sub_title', 'base', 'method'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        dd($request->all()) ;
        $validator = Validator::make($request->all(), [
            'user_id'       => ''
            'name'          => 'required',
            'address'   => 'required',
            'country'        => 'required',
            'state'              => 'required',
            'city'              => 'required',
            'zipcode'              => 'required',
            'image'               => '',
            'productname'         => '',
            'pv'                  => '',
            'quantity'            => '',
         ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {

            ProductPurchas::create([
                'user_id'       => Auth::user()->id,
                'name'          => $request->name,
                'address'   => $request->address,
                'country'         => $request->country,
                'state'         => $request->state,
                'city'         => $request->city,
                'zipcode'         => $request->zipcode,
                'image'         => '',
                'productname'         => '',
                'pv'         => '',
                'quantity'         => '',
                'amount'         => '',
            ]);
            Session::flash('flash_notification', array('level' => 'success', 'message' => 'Product Purchase succesfully'));
            return redirect()->back();
        }
    }


}
