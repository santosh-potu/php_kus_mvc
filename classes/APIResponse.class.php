<?php
namespace Kus;

class APIResponse{
 
    public function json($code = 200, $message = null, $data=null)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($code);
        // treat this as json
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
            );
        // ok, validation error, or failure
        header('Status: '.$status[$code]);
        // return the encoded json
        $resData = [];
        $resData['status'] = $code;
        if($message){$resData['message'] = $message; }
        if($data){$resData['data'] = $data; }
        echo json_encode($resData);
    }

    public function setErrorCode($error_msg=NULL, $status_code=NULL,$msg_code=NULL) {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($status_code);
        // treat this as json
        header('Content-Type: application/json');
        $error = array(); 
        $error['status'] = "error";
        $error['message'] = $error_msg;
        $error['msg_code'] = $msg_code;
        echo json_encode($error);
    }
}