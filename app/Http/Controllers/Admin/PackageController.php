<?php

namespace App\Http\Controllers\Admin;

use App\DirectSposnor;
use App\Http\Controllers\Admin\AdminController;
 use App\Incentives;
use App\Packages;
use App\Settings;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Response;

class PackageController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $matrix1  = Packages::where('matrix',1)->get();
        $matrix2  = Packages::where('matrix',2)->get();
        $title     = trans('packages.plan_settings');
        $sub_title = trans('packages.plan_settings');
        $base      = trans('packages.settings');
        $method    = trans('packages.plan_settings');
        
        return view('app.admin.packages.index', compact('title', 'matrix1','matrix2', 'user', 'sub_title', 'base', 'method'));
    }

    public function update(Request $request)
    {
        $package = Packages::find($request->pk);

        $variable = $request->name;

        $package->$variable = $request->value;

        if ($package->save()) {
            return Response::json(array('status' => 1));
        } else {
            return Response::json(array('status' => 0));
        }

    }

    public function incentives()
    {

        $item      = Settings::find(1);
        $title     = trans('packages.incentives_management');
        $sub_title = trans('packages.incentives_management');
        $base      = trans('packages.settings');
        $method    = trans('packages.incentives_management');
       
        $settings  = Incentives::join('packages', 'packages.id', '=', 'incentives.package')
            ->select('incentives.*', 'packages.package')
            ->get();
 
        return view('app.admin.packages.bonus', compact('title', 'user', 'sub_title', 'base', 'method', 'item', 'settings'));
    }

    public function updateleadership(Request $request)
    {
        $package = Incentives::find($request->pk);

        $variable = $request->name;

        $package->$variable = $request->value;

        if ($package->save()) {
            return Response::json(array('status' => 1));
        } else {
            return Response::json(array('status' => 0));
        }

    }

    public function updategroupsales(Request $request)
    {
        $package = MatchingBonus::find($request->pk);

        $variable = $request->name;

        $package->$variable = $request->value;

        if ($package->save()) {
            return Response::json(array('status' => 1));
        } else {
            return Response::json(array('status' => 0));
        }

    }

    public function updatereferbonus(Request $request)
    {
        $package = DirectSposnor::find($request->pk);

        $variable = $request->name;

        $package->$variable = $request->value;

        if ($package->save()) {
            return Response::json(array('status' => 1));
        } else {
            return Response::json(array('status' => 0));
        }

    }

}
