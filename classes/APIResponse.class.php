<?php
namespace Kus;

class ApiResponse{
 
    public function json($status = null, $code = 200,$data=null)
    {        
        // set the actual code
        http_response_code($code);
        // treat this as json
        header('Content-Type: application/json');
        // return the encoded json
        $resData = [];
        $resData['status'] = $status;
        if($data){$resData['data'] = $data; }
        echo json_encode($resData);
    }

}