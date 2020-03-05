<?php

namespace App\Http\Controllers\user;


use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\DocumentUpload;


use Auth;
use DB;
use Input;
use Redirect;
use Session;

use App\Helpers\Thumbnail;


use App\Http\Controllers\user\UserAdminController;
use Response;


class DocumentController extends UserAdminController
{

     public function download()
     {

        $title = trans('download.document_download');
        $sub_title =  trans('download.document_download');
        $method  =  trans('download.document_download');
        $downloads = DocumentUpload::paginate(10);
        return view('app.user.documents.documentsupload',compact('title','downloads','sub_title','method')); 
    }
    public function getDownload(Request $request){
        $name=$request->name;
        $file= public_path(). "/assets/uploads/".$request->name;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file, $request->name, $headers);
    }  
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
