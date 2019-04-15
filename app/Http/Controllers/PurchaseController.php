<?php

namespace App\Http\Controllers;

use App\Http\CustomResponse;
use App\SongPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PurchaseController extends Controller
{
    //

    public function getSongPackages()
    {
        try {

            $songPackages = SongPackage::all();

            if (count($songPackages) > 0) {
                return (new CustomResponse)->successResponse($songPackages, 'Song package List!');
            } else {
                return (new CustomResponse)->failResponse('No package Found!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }


    public function doPurchasePackage(Request $request){

        try {
            $user_id = $request->input('user_id');
            $package_id = $request->input('package_id');

            $rules = array('user_id' => 'required', 'package_id' => 'required');
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return (new CustomResponse)->failResponse('Validation fails!');
            } else {
                $result = DB::table('purchased_packages')->insert([
                    'user_id' => $user_id,
                    'package_id' => $package_id,
                    'status' => 1,
                ]);

                if ($result) {
                    $data = array('user_id' => $user_id, 'package_id' => $package_id);
                    return (new CustomResponse)->successResponse($data, 'Successfully inserted package!');
                } else {
                    return (new CustomResponse)->failResponse('Failed to insert data!');
                }
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }
}
