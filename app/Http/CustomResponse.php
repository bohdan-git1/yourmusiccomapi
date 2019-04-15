<?php


namespace App\Http;


use App\BlockUser;
use App\Chat;
use App\ChatMessage;
use App\ChatRoom;
use App\ChatUser;
use App\User;
use App\UserRole;
use Illuminate\Support\Facades\Response;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Pawlox\VideoThumbnail\VideoThumbnail;

class CustomResponse
{
    /*Success Response*/

    public function tokenRegistration($data, $message , $TokenRegistration)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data,
            'tokenID' => $TokenRegistration,
        );
        return $response;
    }
    public function DifferenceTime($differenceInSeconds, $timeFirst , $timeSecond)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => "0",
            'time' => $differenceInSeconds,
            'timeFirst' => $timeFirst,
            'timeSecond' => $timeSecond
        );
        return $response;
    }

    public function tokenResponse($data, $message , $ids)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data,
            'tokenID' => $ids,
        );
        return $response;
    }


    public function successResponse($data, $message)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data
        );
        return json_encode($response);
    }

    public function successResponseApi($data, $message)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data
        );
        return $response;
    }

    public function successShopifyResponseApi($data, $message,$customerId)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data,
            'customerId'=>$customerId
        );
        return $response;
    }
    public function successShopifyResApi($data, $message)
    {
        $response = array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => $data,
//            'customerId'=>$customerId
        );
        return $response;
    }

    public function saveresponse($message)
    {
        return \Response::json(array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            'data' => (object)[]
        ));
    }

    public function saveresponseApi($message)
    {
        return \Response::json(array(
            'Exception' => "",
            'status' => 200,
            'error' => false,
            'message' => $message,
            ));
    }

    public function failResponse($message)
    {
        $response = array(
            'Exception' => "",
            'status' => 400,
            'error' => true,
            'message' => $message,
           
        );
        return $response;
    }

    public function fileUpload($userImage, $savePath = 'images')
    {

        $destinationPath = $savePath;
        $extension = $userImage->getClientOriginalExtension();

        $fileName = rand(11111, 99999) . '.' . $extension;

        $success = $userImage->move($destinationPath, $fileName);
        
        $imagpath = $destinationPath . "/" . $fileName;
        return $imagpath;

    }

    public function querryexception($exception)
    {
        return \Response::json(array(
            'Exception' => $exception,
            'status' => 400,
            'error' => true,
            'message' => "Failed ! Query Exception",

        ));
    }

    public function validatemessage($message = "Please fill all the fields")
    {
        return \Response::json(array(
            'Exception' => "",
            'status' => 400,
            'error' => true,
            'message' => $message,
        ));
    }

    public function phoneExist($message, $status, $data)
    {
        return \Response::json(array(
            'Exception' => "",
            'status' => 200,
            'phone_exist' => $status,
            'error' => false,
            'message' => $message,
            'data' => $data
        ));
    }

    public function verifyPassword($message, $status, $data)
    {
        return \Response::json(array(
            'Exception' => "",
            'status' => 200,
            'verify_password' => $status,
            'error' => false,
            'message' => $message,
            'data' => $data
        ));
    }

    public function timeoutApiResponse()
    {
            return \Response::json(array(
                'Exception' => "",
                'status' => 200,
                'error' => true,
                'message' => "1",
                'displaymessage' => "Job assigned"
            ));
    }

}