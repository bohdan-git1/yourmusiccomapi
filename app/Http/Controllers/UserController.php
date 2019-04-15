<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\CustomResponse;
use App\User;
use Illuminate\Support\Facades\DB;
use Hash;

class UserController extends Controller
{
//


    public function login(Request $request)
    {

        try {

            $allInputs = $request->all();
            $email = $request->input('username');
            $password = $request->input('password');

            $validation = Validator::make($allInputs, [
                'username' => 'required',
                'password' => 'required'
            ]);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            } else {

                $checkRecord = User::where("email", '=', $email)->first();
                if ($checkRecord) {
                    $checkPassword = Hash::check($password, $checkRecord->password);

                    if ($checkPassword) {
                        return (new CustomResponse)->successResponse($checkRecord, 'User logged in successfully!');
                    } else {
                        return (new CustomResponse)->failResponse('Password does not match!');
                    }
                } else {
                    return (new CustomResponse)->failResponse('User does not exist!');
                }
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->querryexception($ex);
        }
        //return $response;
    }

    public function signup(Request $request)
    {

        try {

            DB::beginTransaction();
            $allInputs = $request->all();
            $email = $request->input('username');
            $password = $request->input('password');
            $phoneNo = $request->input('mobile_no');
            $name = $request->input('name');

            $validation = Validator::make($allInputs, [
                'username' => 'required',
                'password' => 'required',
                'mobile_no' => 'required',
                'name' => 'required'
            ]);

            if ($validation->fails()) {
                DB::commit();
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            } else {

                $checkRecord = User::where("email", '=', $email)->get();
                if (count($checkRecord) == 0) {
                    $data = array(
                        'email' => $email,
                        'mobile_no' => $phoneNo,
                        'password' => bcrypt($password),
                        'name' => $name);

                    $user = User::create($data);

                    DB::commit();
                    if ($user) {
                        return (new CustomResponse)->successResponse($user, 'User created successfully!');
                    } else {
                        return (new CustomResponse)->failResponse('User not created, please contact Admin!');
                    }
                } else {
                    DB::commit();
                    return (new CustomResponse)->failResponse('User already exist!');
                }
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->querryexception($ex);
        }
        //return $response;
    }

    public function updateUserImage(Request $request)
    {
        try {

            $allInputs = Input::all();
            $id = trim($request->input('id'));
            $image = $request->file('image');
            $validation = Validator::make($allInputs, [
                'id' => 'required',
                'image' => 'required'
            ]);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }

            $destinationPath = 'images/users_images/';

            $fileuploadedpath = '';

            if ($image != '') {

                $extension = $image->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $success[0] = $image->move($destinationPath, $fileName);
                $fileuploadedpath = url($destinationPath . "/" . $fileName);

            }

            $result = User::where('id','=', $id)->update(['image' => $fileuploadedpath]);

            if ($result) {
                return (new CustomResponse)->successResponse("", 'Image updated successfully!');
            } else {
                return (new CustomResponse)->failResponse('Image cannot be uploaded right now, Please try again later!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }

    public function updateUserInfo(Request $request)
    {
        try {

            $allInputs = Input::all();
            $id = trim($request->input('user_id'));
            $name = $request->input('name');
            $validation = Validator::make($allInputs, [
                'user_id' => 'required',
                'name' => 'required'
            ]);

           // dd($allInputs);
            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }

            $result = User::where('id', $id)->update(['name' => $name]);

            if ($result) {
                return (new CustomResponse)->successResponse("", 'User info updated successfully!');
            } else {
                return (new CustomResponse)->failResponse('info cannot be updated right now, Please try again later!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }

}
