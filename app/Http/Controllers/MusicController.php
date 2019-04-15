<?php

namespace App\Http\Controllers;

use App\Http\CustomResponse;
use App\SongLocation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            $track = $request->file('track');

            $validation = Validator::make($allInputs, [
                'user_id' => 'required',
                'title' => 'required',
                'lat' => 'required',
                'lng' => 'required'
            ]);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }
            
            $destinationPath = 'images/users_images/';
            
            if ($track != '') {

                $extension = $track->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $success[0] = $track->move($destinationPath, $fileName);
                $fileuploadedpath = url($destinationPath . "/" . $fileName);
                $path = $fileuploadedpath;
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

            $userSongList = SongLocation::get();

            if (count($userSongList)>0) {
                return (new CustomResponse)->successResponse($userSongList, 'User Song List!');
            } else {
                return (new CustomResponse)->failResponse('No Song Found!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }
    
    public function isTrackAvailable(Request $request){
        try {

            $allInputs = Input::all();
            //$trackId = trim($request->input('track_id'));
            $lat = trim($request->input('lat'));
            $long = trim($request->input('long'));

            $validation = Validator::make($allInputs, [
                //'track_id' => 'required',
                'lat' => 'required',
                'long' => 'required'
                ]);

            if ($validation->fails()) {
                return (new CustomResponse())->validatemessage($validation->errors()->first());
            }

            $queryvalue = "(SELECT * , (6371 * acos(cos(radians($lat)) * cos(radians(lat))* cos( radians(lng) - radians($long) )+ sin (radians($lat) )* sin(radians(lat)))) AS distance FROM song_locations HAVING distance < 0.2 ORDER BY distance ASC Limit 1)";
            $trackLocation = DB::select(DB::raw($queryvalue));

            if (count($trackLocation)>0) {
                return (new CustomResponse)->successResponse($trackLocation, 'Track Found!');
            } else {
                return (new CustomResponse)->failResponse('No Track Found!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            return (new CustomResponse())->failResponse('Fail!' . $ex);
        }
    }
}
