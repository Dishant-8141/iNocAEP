<?php

date_default_timezone_set("UTC");
session_start();
if(!empty($_GET)){
    if(isset($_GET['type'])){
        //=============Get access token================
        if ($_GET['type'] == 'get_token'){
            if(!empty($_POST)){
                if(isset($_POST['client_id']) && isset($_POST['client_secret']) && isset($_POST['jwt_token'])){
                    $post = [
                        'client_id' => $_POST['client_id'],
                        'client_secret' => $_POST['client_secret'],
                        'jwt_token' => $_POST['jwt_token']
                    ];
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://ims-na1.adobelogin.com/ims/exchange/jwt");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                    // Receive server response ...
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = curl_exec($ch);
                    if(!$server_output){
                        $error = array(
                            'status'=> false,
                            'code'=> 400,
                            'message'=> 'Something went wrong on server side, Connection Failure.',
                        );
                        echo json_encode($error);
                        exit;
                    }
                    
                    curl_close ($ch);

                    $data = json_decode($server_output);
                    
                    if(!isset($data->error) && !isset($data->errorMessage) && !isset($data->error_code) && !isset($data->errorDetails) && !isset($data->errors)){
                        $success = array(
                            'status'=> true,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($success);
                        exit;
                    }else{
                        $error = array(
                            'status'=> false,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($error);
                        exit;
                    }
                
                } else {
                    $error = array(
                        'status'=> FALSE,
                        'code'=> 200,
                        'message'=> 'Client id, Client secret or jwt token is missing.'
                    );
                    echo json_encode($error);
                    exit;
                }
            } else {
                $error = array(
                    'status'=> FALSE,
                    'code'=> 200,
                    'message'=> 'Client id or Client secret or Jwt token missing.'
                );
                echo json_encode($error);
                exit;
            }
        }
    
        //=============Get flow=====================
        if ($_GET['type'] == 'get_flow') {
            $headers = getallheaders();
            $req_headers = headersParameter($headers);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://platform.adobe.io/data/foundation/flowservice/flows');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $req_headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result){
                $error = array(
                    'status'=> false,
                    'code'=> 400,
                    'message'=> 'Something went wrong on server side, Connection Failure.',
                );
                echo json_encode($error);
                exit;
            }
            curl_close($curl);
            $result_data = json_decode($result);
            
            if(isset($result_data->items)){
                // $_SESSION['flows'] = json_encode($result_data);
                // echo $_SESSION['flows'];exit;
                file_put_contents("../log_content/flow_content.txt", json_encode($result_data));
                
                $success = array(
                    'status'=> true,
                    'code'=> 200,
                    'data'=> $result_data
                );
                echo json_encode($success);
                exit;
            }else{
                $error = array(
                    'status'=> false,
                    'code'=> 200,
                    'data'=> $result_data,
                );
                echo json_encode($error);
                exit;
            }
        }

        //=============Create flow=================
        if ($_GET['type'] == 'create_flow'){
            $body_data = file_get_contents('php://input');
            if(isset($body_data)){
                $headers = getallheaders();
                $req_headers = headersParameter($headers);
                // var_dump($body_data);exit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://platform.adobe.io/data/foundation/flowservice/flows');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $req_headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);

                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec($ch);
                if(!$server_output){
                    $error = array(
                        'status'=> false,
                        'code'=> 400,
                        'message'=> 'Something went wrong on server side, Connection Failure.',
                    );
                    echo json_encode($error);
                    exit;
                }
                    
                    curl_close ($ch);

                    $data = json_decode($server_output);
                    
                    if(!isset($data->error) && !isset($data->errorMessage) && !isset($data->error_code) && !isset($data->errorDetails) && !isset($data->errors)){
                        $success = array(
                            'status'=> true,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($success);
                        exit;
                    }else{
                        $error = array(
                            'status'=> false,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($error);
                        exit;
                    }
                
                
            } else {
                $error = array(
                    'status'=> FALSE,
                    'code'=> 200,
                    'message'=> 'All data is required for create flow.'
                );
                echo json_encode($error);
                exit;
            }
        }
        
        //==============Get particular flow=============
        if ($_GET['type'] == 'get_particular_flow'){
            if(!empty($_POST)){
                if(isset($_POST['flow_id'])){
                    $url = 'https://platform.adobe.io/data/foundation/flowservice/flows/'.$_POST['flow_id'];
                    $headers = getallheaders();
                    $req_headers = headersParameter($headers);
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $req_headers);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    // EXECUTE:
                    $result = curl_exec($curl);
                    if(!$result){
                        $error = array(
                            'status'=> false,
                            'code'=> 400,
                            'message'=> 'Something went wrong on server side, Connection Failure.',
                        );
                        echo json_encode($error);
                        exit;
                    }
                    curl_close($curl);
                    $result_data = json_decode($result);
            
                    if(isset($result_data->items)){
                        $success = array(
                            'status'=> true,
                            'code'=> 200,
                            'data'=> $result_data
                        );
                        echo json_encode($success);
                        exit;
                    }else{
                        $error = array(
                            'status'=> false,
                            'code'=> 200,
                            'data'=> $result_data,
                        );
                        echo json_encode($error);
                        exit;
                    }
                
                } else {
                    $error = array(
                        'status'=> FALSE,
                        'code'=> 200,
                        'message'=> 'Flow id is missing.'
                    );
                    echo json_encode($error);
                    exit;
                }
            } else {
                $error = array(
                    'status'=> FALSE,
                    'code'=> 200,
                    'message'=> 'Flow id is missing.'
                );
                echo json_encode($error);
                exit;
            }
        }

        //===============Update particular flow=========
        if ($_GET['type'] == 'update_flow'){
            $body_data = file_get_contents('php://input');
            $data = json_decode($body_data);
            if(isset($body_data)){
                if(isset($data[0]->flow_id) && $data[0]->flow_id != null){
                    $url = 'https://platform.adobe.io/data/foundation/flowservice/flows/'.$data[0]->flow_id;
                }else{
                    $error = array(
                        'status'=> FALSE,
                        'code'=> 200,
                        'message'=> 'Flow id is required.'
                    );
                    echo json_encode($error);
                    exit;
                }
                
                $headers = getallheaders();
                $req_headers = headersParameter($headers);
                // print_r($req_headers);exit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $req_headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);

                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec($ch);
                 
                if(!$server_output){
                    $error = array(
                        'status'=> false,
                        'code'=> 400,
                        'message'=> 'Something went wrong on server side, Connection Failure.',
                    );
                    echo json_encode($error);
                    exit;
                }
                    
                curl_close ($ch);

                $data = json_decode($server_output);
                
                if(!isset($data->error) && !isset($data->errorMessage) && !isset($data->error_code) && !isset($data->errorDetails) && !isset($data->errors)){
                    $success = array(
                        'status'=> true,
                        'code'=> 200,
                        'data'=> $data,
                    );
                    echo json_encode($success);
                    exit;
                }else{
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'data'=> $data,
                    );
                    echo json_encode($error);
                    exit;
                }
            } else {
                $error = array(
                    'status'=> FALSE,
                    'code'=> 200,
                    'message'=> 'Data required for update flow.'
                );
                echo json_encode($error);
                exit;
            }
        }

        //===============Delete particular flow==========
        if($_GET['type'] == 'delete_flow'){
            if(!empty($_POST)){
                if(isset($_POST['flow_id'])){
                    $url = 'https://platform.adobe.io/data/foundation/flowservice/flows/'.$_POST['flow_id'];
                    $headers = getallheaders();
                    $req_headers = headersParameter($headers);
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $req_headers);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    // EXECUTE:
                    $result = curl_exec($curl);
                    // echo $result;exit;
                    if(!$result){
                        $error = array(
                            'status'=> false,
                            'code'=> 400,
                            'message'=> 'Something went wrong on server side, Connection Failure.',
                        );
                        echo json_encode($error);
                        exit;
                    }
                    curl_close($curl);
                    $data = json_decode($result);
            
                    if(!isset($data->error) && !isset($data->errorMessage) && !isset($data->error_code) && !isset($data->errorDetails) && !isset($data->errors)){
                        $success = array(
                            'status'=> true,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($success);
                        exit;
                    }else{
                        $error = array(
                            'status'=> false,
                            'code'=> 200,
                            'data'=> $data,
                        );
                        echo json_encode($error);
                        exit;
                    }
                
                } else {
                    $error = array(
                        'status'=> FALSE,
                        'code'=> 200,
                        'message'=> 'Flow id is missing.'
                    );
                    echo json_encode($error);
                    exit;
                }
            } else {
                $error = array(
                    'status'=> FALSE,
                    'code'=> 200,
                    'message'=> 'Flow id is missing.'
                );
                echo json_encode($error);
                exit;
            }
        }

        //===============Pie chart for get flow============
        if ($_GET['type'] == 'flowservice_piechart') {
            if (!empty($_POST)) {
                if(!isset($_POST['status_type'])){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Select at least one status',
                    );
                    echo json_encode($error);
                    exit;
                }
                if($_POST['status_type'] != 'last_dataflow_run' && $_POST['status_type'] != 'flow' && $_POST['status_type'] != 'error'){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Invalid status',
                    );
                    echo json_encode($error);
                    exit;
                }
                $status_type = $_POST['status_type'];
                $from_date = (isset($_POST['from_date'])) ? date('Y-m-d H:i:s', strtotime($_POST['from_date'])) : null;
                $to_date = (isset($_POST['to_date'])) ? date('Y-m-d H:i:s', strtotime($_POST['to_date'])) : null;

                $result_data = file_get_contents("../log_content/flow_content.txt");
                $result_data = file_get_contents("flow.json");
                // print_r($result_data);exit;
                if(!isset($result_data)){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Data not found.',
                    );
                    echo json_encode($error);
                    exit;
                }
                
                $result_data = json_decode($result_data);
                $from_date = ($from_date != null) ? strtotime($from_date) : null;
                $to_date = ($to_date != null) ? strtotime($to_date) : null;
                if(isset($result_data->items)){
                    if (count($result_data->items) > 0) {
                        $items = $result_data->items;
                        if($status_type == 'flow'){
                            $flow_status_array = array();
                            $count_flow_status_array = array();
                            $count = 0;
                            foreach ($items as $item) {
                                $mil = $item->createdAt;
                                $seconds = $mil / 1000;
                                $created_date = date("Y-m-d H:i:s", (int) $seconds);
                                $created_date = strtotime($created_date);
                                $check = false;
                                if(isset($item->state)){
                                    if ($from_date != null && $to_date != null){
                                        if ($created_date >= $from_date && $created_date <= $to_date) {
                                            $check = true;
                                        }

                                    }else if ($from_date != null || $to_date != null){
                                        if($from_date != null){
                                            if ($created_date >= $from_date){
                                                $check = true;
                                            }
                                        }else{
                                            if($created_date <= $to_date){
                                                $check = true;
                                            }
                                        }
                                        
                                    }else{
                                        $check = true;
                                    }
                                }
                                
                                if ($check == true) {
                                    if (in_array($item->state, $flow_status_array)){
                                        $count_flow_status_array[$item->state]++;
                                    }else{
                                        array_push($flow_status_array, $item->state);
                                        $count_flow_status_array[$item->state] = 1;
                                    }
                                    $count++;
                                }
                            }

                            if(count($flow_status_array) > 0){
                                $data[0][0] = 'Flow status';
                                $data[0][1] = 'Percentage';

                                $j = 1;
                                foreach ($flow_status_array as $flow) {
                                    $data[$j][0] = $flow;
                                    $per = 100 * $count_flow_status_array[$flow] / count($result_data->items);
                                    $data[$j][1] = (float)$per;
                                    $j++; 
                                }
                                // array_push($data, array("success", 78));
                                $final = array(
                                    'status'=> true,
                                    'code'=> 200,
                                    'data'=> $data
                                );
                                echo(json_encode($final));
                                exit;
                            } else {
                                $error = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Items is not found.',
                                );
                                echo json_encode($error);
                                exit;
                            }

                        } else if ($status_type == 'last_dataflow_run') {
                            $last_flow_run_status = array();
                            $count_last_flow_run = array();
                            $i = 0;
                            $a = 0;
                            foreach ($items as $item) {
                                if(isset($item->lastRunDetails) && $item->lastRunDetails != null){
                                    $mil = $item->lastRunDetails->completedAtUTC;
                                    $seconds = $mil / 1000;
                                    $completed_utc = date("Y-m-d H:i:s", (int) $seconds);
                                    $completed_utc = strtotime($completed_utc);
                                    $check = false;
                                    if ($from_date != null && $to_date != null){
                                        if ($completed_utc >= $from_date && $completed_utc <= $to_date) {
                                            $check = true;
                                        }
                                    }else if ($from_date != null || $to_date != null){
                                        if($from_date != null){
                                            if ($completed_utc >= $from_date){
                                                $check = true;
                                            }
                                        }else{
                                            if($completed_utc <= $to_date){
                                                $check = true;
                                            }
                                        }
                                    }else{
                                        $check = true;
                                    }

                                    if($check == true){
                                        if(isset($item->lastRunDetails->state)){
                                            if (in_array($item->lastRunDetails->state, $last_flow_run_status)){
                                                $count_last_flow_run[$item->lastRunDetails->state]++;
                                            }else{
                                                array_push($last_flow_run_status, $item->lastRunDetails->state);
                                                $count_last_flow_run[$item->lastRunDetails->state] = 1;
                                            }
                                            $i++;
                                        }
                                    }
                                }else{
                                    if (in_array('No runs', $last_flow_run_status)){
                                        $count_last_flow_run['No runs']++;
                                    }else{
                                        array_push($last_flow_run_status, 'No runs');
                                        $count_last_flow_run['No runs'] = 1;
                                    }
                                    $i++;
                                }
                            }
                            
                            if(count($last_flow_run_status) > 0){
                                $data[0][0] = 'Last flow run status';
                                $data[0][1] = 'Percentage';

                                $j = 1;
                                foreach ($last_flow_run_status as $last) {
                                    $data[$j][0] = $last;
                                    $per = 100 * $count_last_flow_run[$last] / $i;
                                    $data[$j][1] = (float)$per;
                                    $j++; 
                                }

                                $final = array(
                                    'status'=> true,
                                    'code'=> 200,
                                    'data'=> $data
                                );
                                echo(json_encode($final));
                                exit;
                            } else {
                                $error = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Items is not found.',
                                );
                                echo json_encode($error);
                                exit;
                            }
                            
                        } else if ($status_type == 'error') {
                            $last_error_status = array();
                            $count_error = array();
                            $i = 0;
                            foreach ($items as $item) {
                                $mil = $item->createdAt;
                                $seconds = $mil / 1000;
                                $created_date = date("Y-m-d H:i:s", (int) $seconds);
                                $created_date = strtotime($created_date);
                                $check = false;
                                if(isset($item->options) && $item->options != null){
                                    if ($from_date != null && $to_date != null){
                                        if ($created_date >= $from_date && $created_date <= $to_date) {
                                            $check = true;
                                        }

                                    }else if ($from_date != null || $to_date != null){
                                        if($from_date != null){
                                            if ($created_date >= $from_date){
                                                $check = true;
                                            }
                                        }else{
                                            if($created_date <= $to_date){
                                                $check = true;
                                            }
                                        }
                                        
                                    }else{
                                        $check = true;
                                    }

                                    if($check == true){
                                        if(isset($item->options->errorDiagnosticsEnabled)){
                                            $error_con = ($item->options->errorDiagnosticsEnabled == true) ? "True" : "False";
                                            if (in_array($error_con, $last_error_status)){
                                                $count_error[$error_con]++;
                                            }else{
                                                array_push($last_error_status, $error_con);
                                                $count_error[$error_con] = 1;
                                            }
                                            $i++;
                                        }else{
                                            if (in_array("False", $last_error_status)){
                                                $count_error["False"]++;
                                            }else{
                                                array_push($last_error_status, "False");
                                                $count_error["False"] = 1;
                                            }
                                            $i++;
                                        }
                                    }
                                }
                            }
                            
                            if(count($last_error_status) > 0){
                                $data[0][0] = 'Error status';
                                $data[0][1] = 'Percentage';

                                $j = 1;
                                foreach ($last_error_status as $flow) {
                                    $data[$j][0] = $flow;
                                    $per = 100 * $count_error[$flow] / $i;
                                    $data[$j][1] = (float)$per;
                                    $j++; 
                                }
                                // array_push($data, array("success", 78));
                                $final = array(
                                    'status'=> true,
                                    'code'=> 200,
                                    'data'=> $data
                                );
                                echo(json_encode($final));
                                exit;
                            } else {
                                $error = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Items is not found.',
                                );
                                echo json_encode($error);
                                exit;
                            }

                        }
                    }else{
                        $error = array(
                            'status'=> false,
                            'code'=> 200,
                            'message'=> 'Items is not found.',
                        );
                        echo json_encode($error);
                        exit;
                    }
                    // $success = array(
                    //     'status'=> true,
                    //     'code'=> 200,
                    //     'data'=> $result_data
                    // );
                    // echo json_encode($success);
                    // exit;
                }else{
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Something went wrong on server side',
                        'data'=> $result_data,
                    );
                    echo json_encode($error);
                    exit;
                }
            }
            else{
                $error = array(
                    'status'=> false,
                    'code'=> 200,
                    'message'=> 'Select at least one status',
                );
                echo json_encode($error);
                exit;
            }
        }

        //===============List Connections============
        if ($_GET['type'] == 'get_connections') {
            $headers = getallheaders();
            $req_headers = headersParameter($headers);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://platform.adobe.io/data/foundation/flowservice/connections');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $req_headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result){
                $error = array(
                    'status'=> false,
                    'code'=> 400,
                    'message'=> 'Something went wrong on server side, Connection Failure.',
                );
                echo json_encode($error);
                exit;
            }
            curl_close($curl);
            $result_data = json_decode($result);
            
            if(isset($result_data->items)){
                file_put_contents("../log_content/connection_content.txt", json_encode($result_data));
                
                $success = array(
                    'status'=> true,
                    'code'=> 200,
                    'data'=> $result_data
                );
                echo json_encode($success);
                exit;
            }else{
                $error = array(
                    'status'=> false,
                    'code'=> 200,
                    'data'=> $result_data,
                );
                echo json_encode($error);
                exit;
            }
        }

        //===============Pie chart for get connection list============
        if ($_GET['type'] == 'connection_piechart') {
            if (!empty($_POST)) {
                if(!isset($_POST['status_type'])){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Select at least one status',
                    );
                    echo json_encode($error);
                    exit;
                }
                if($_POST['status_type'] != 'destination' && $_POST['status_type'] != 'state'){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Invalid status',
                    );
                    echo json_encode($error);
                    exit;
                }
                $status_type = $_POST['status_type'];
                $from_date = (isset($_POST['from_date'])) ? date('Y-m-d H:i:s', strtotime($_POST['from_date'])) : null;
                $to_date = (isset($_POST['to_date'])) ? date('Y-m-d H:i:s', strtotime($_POST['to_date'])) : null;

                $result_data = file_get_contents("../log_content/connection_content.txt");
                // print_r($result_data);exit;
                if(!isset($result_data)){
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Data not found.',
                    );
                    echo json_encode($error);
                    exit;
                }
                
                $result_data = json_decode($result_data);
                $from_date = ($from_date != null) ? strtotime($from_date) : null;
                $to_date = ($to_date != null) ? strtotime($to_date) : null;
                if(isset($result_data->items)){
                    if (count($result_data->items) > 0) {
                        $items = $result_data->items;
                        if($status_type == 'state'){
                            $state_array = array();
                            $count_state_array = array();
                            $count = 0;
                            foreach ($items as $item) {
                                $mil = $item->createdAt;
                                $seconds = $mil / 1000;
                                $created_date = date("Y-m-d H:i:s", (int) $seconds);
                                $created_date = strtotime($created_date);
                                $check = false;
                                if(isset($item->state)){
                                    if ($from_date != null && $to_date != null){
                                        if ($created_date >= $from_date && $created_date <= $to_date) {
                                            $check = true;
                                        }

                                    }else if ($from_date != null || $to_date != null){
                                        if($from_date != null){
                                            if ($created_date >= $from_date){
                                                $check = true;
                                            }
                                        }else{
                                            if($created_date <= $to_date){
                                                $check = true;
                                            }
                                        }
                                        
                                    }else{
                                        $check = true;
                                    }
                                }
                                
                                if ($check == true) {
                                    if (in_array($item->state, $state_array)){
                                        $count_state_array[$item->state]++;
                                    }else{
                                        array_push($state_array, $item->state);
                                        $count_state_array[$item->state] = 1;
                                    }
                                    $count++;
                                }
                            }

                            if(count($state_array) > 0){
                                $data[0][0] = 'State';
                                $data[0][1] = 'Percentage';

                                $j = 1;
                                foreach ($state_array as $state) {
                                    $data[$j][0] = $state;
                                    $per = 100 * $count_state_array[$state] / count($result_data->items);
                                    $data[$j][1] = (float)$per;
                                    $j++; 
                                }
                                // array_push($data, array("success", 78));
                                $final = array(
                                    'status'=> true,
                                    'code'=> 200, 
                                    'data'=> $data
                                );
                                echo(json_encode($final));
                                exit;
                            } else {
                                $error = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Items is not found.',
                                );
                                echo json_encode($error);
                                exit;
                            }

                        } else if ($status_type == 'destination') {
                        }
                    }
                    
                }else{
                    $error = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Something went wrong on server side',
                        'data'=> $result_data,
                    );
                    echo json_encode($error);
                    exit;
                }
            }
            else{
                $error = array(
                    'status'=> false,
                    'code'=> 200,
                    'message'=> 'Select at least one status',
                );
                echo json_encode($error);
                exit;
            }
        }
    }else{
        $error = array(
            'status'=> FALSE,
            'code'=> 400,
            'message'=> 'Invalid URL.'
        );
        echo json_encode($error);
        exit;
    }
}else{
    $error = array(
        'status'=> FALSE,
        'code'=> 400,
        'message'=> 'Invalid URL.'
    );

    echo json_encode($error);
    exit;
}

function headersParameter($headers){
    if(!isset($headers['Authorization'])){
        $error = array(
            'status'=> false,
            'code'=> 400,
            'message'=> 'Authorization token is required.',
        );
        echo json_encode($error);
        exit;
    }
    if(!isset($headers['x-api-key'])){
        $error = array(
            'status'=> false,
            'code'=> 400,
            'message'=> 'x-api-key is required.',
        );
        echo json_encode($error);
        exit;
    }
    if(!isset($headers['x-gw-ims-org-id'])){
        $error = array(
            'status'=> false,
            'code'=> 400,
            'message'=> 'x-gw-ims-org-id is required.',
        );
        echo json_encode($error);
        exit;
    }
    $req_headers = array(
        'Authorization: '.$headers['Authorization'],
        'x-api-key: '.$headers['x-api-key'],
        'x-gw-ims-org-id: '.$headers['x-gw-ims-org-id'],
        'Content-Type: application/json'
    );

    return $req_headers;
}
?>