<?php

namespace App\Http\Controllers;

use App\Http\CustomResponse;
use App\SongLocation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MusicController extends Controller
{
    //

    public function addSongWithLocation(Request $request)
    {
        try {

            $allInputs = Input::all();
            $userId = trim($request->input('user_id'));
            $title = trim($request->input('title'));
            $path = trim($request->input('path'));
            $lat = trim($request->input('lat'));
            $lng = trim($request->input('lng'));

            $validation = Validator::make($allInputs, [
                'user_id' => 'required',
                'title' => 'required',
                'path' => 'required',
                'lat' => 'required',
                'lng' => 'required'
            ]);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }

            $data = array(
                'user_id' => $userId,
                'title' => $title,
                'path' => $path,
                'lat' => $lat,
                'lng' => $lng);

            $song = SongLocation::create($data);
            if ($song) {
                return (new CustomResponse)->successResponse($song, 'Song added on lacation successfully!');
            } else {
                return (new CustomResponse)->failResponse('Song not added, please contact Admin!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }

    public function getUserSongList(Request $request){
        try {

            $allInputs = Input::all();
            $userId = trim($request->input('user_id'));

            $validation = Validator::make($allInputs, [
                'user_id' => 'required']);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }

            $userSongList = SongLocation::where("user_id", '=', $userId)->get();

            if (count($userSongList) > 0) {
                return (new CustomResponse)->successResponse($userSongList, 'User Song List!');
            } else {
                return (new CustomResponse)->failResponse('No Song Found!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }
}
