<?php
include('../config.php');
date_default_timezone_set("UTC");
session_start();

if(isset($_SESSION)){
    if (!empty($_SESSION)) {
        if ($_SESSION['logged_in'] == true && isset($_SESSION['user'])) {
            if (!empty($_SESSION['user'])) {
                if (isset($_GET['type'])) {
                    
                    //==========Create Project==========
                    if($_GET['type'] == 'create_project') {
                        if(!empty($_POST)){
                            // print_r($_POST);
                            $user_id = $_SESSION['user']['id'];
                            $name = (isset($_POST['name'])) ? $_POST['name'] : validationMsg('Project name is required');
                            $c_secret = (isset($_POST['c_secret'])) ? md5($_POST['c_secret']) : validationMsg('Client secret is required');
                            $c_id = (isset($_POST['c_id'])) ? md5($_POST['c_id']) : validationMsg('Client id is required');
                            $org_id = (isset($_POST['org_id'])) ? md5($_POST['org_id']) : validationMsg('Org id is required');
                            $jwt_token = (isset($_POST['jwt_token'])) ? md5($_POST['jwt_token']) : validationMsg('Jwt token is required');
                            $default = $_POST['is_active'];

                            $query_1 = "SELECT * from project where `user_id` = '".$user_id."' AND api_key = '".$c_id."'";
                            $check_c_id = checkExists($conn, $query_1, 'API key is already exists');
                            
                            $query_2 = "SELECT * from project where `user_id` = '".$user_id."' AND client_secret = '".$c_secret."'";
                            $check_c_secret = checkExists($conn, $query_2, 'Client secret is already exists');
                            
                            $query_3 = "SELECT * from project where `user_id` = '".$user_id."' AND org_id = '".$org_id."'";
                            $check_org_id = checkExists($conn, $query_3, 'Org id is already exists');
                            
                            $query_4 = "SELECT * from project where `user_id` = '".$user_id."' AND jwt_token = '".$jwt_token."'";
                            $check_jwt = checkExists($conn, $query_4, 'JWT token is already exists');

                            if($check_c_id == true && $check_c_secret == true && $check_org_id == true && $check_jwt == true){
                                $sql = "INSERT INTO project(`user_id`, `name`, `api_key`, `client_secret`, `org_id`, `jwt_token`, `is_active`)
                                        VALUES ('$user_id', '$name', '$c_id', '$c_secret', '$org_id', '$jwt_token', '$default')";
                                    
                                $res2 = mysqli_query($conn, $sql);

                                
                                if($default == 1){
                                    $sel = "SELECT * FROM project where `user_id` = '$user_id'";
                                    $res_Sel = mysqli_query($conn, $sel);
                                    if(mysqli_num_rows($res_Sel) > 1){
                                        $update_query = "UPDATE `project` SET `is_active` = '0' WHERE `user_id` = '$user_id' AND api_key <> '$c_id'";
                                        $up_result = mysqli_query($conn, $update_query);
                                    }
                                }
                                if($res2 == true){
                                    $done = array(
                                        'status'=> true,
                                        'code'=> 200,
                                        'message'=> 'Project created successfully.'
                                    );

                                    echo json_encode($done);
                                    exit;
                                }else{
                                    $err = array(
                                        'status'=> false,
                                        'code'=> 200,
                                        'message'=> 'Something went wrong to create project.'
                                    );

                                    echo json_encode($err);
                                    exit;
                                }
                            }
                        }else{
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Data aer missing.'
                            );
                            echo json_encode($err);
                            exit;
                        }
                    }

                    //===========Get Project List=======
                    if($_GET['type'] == 'get_project'){
                        $user_id = $_SESSION['user']['id'];
                        $query = "SELECT * from project where `user_id` = '$user_id' AND `deleted_at` = '0'";
                        // echo $query;exit;
                        $data = [];
                        if($result = mysqli_query($conn, $query)){
                            if(mysqli_num_rows($result) > 0){
                                $i = 0;
                                while($row = mysqli_fetch_array($result)){
                                    $data[$i]['id'] = $row['id'];
                                    $data[$i]['name'] = $row['name'];
                                    $data[$i]['c_id'] = $row['api_key'];
                                    $data[$i]['c_secret'] = $row['client_secret'];
                                    $data[$i]['org_id'] = $row['org_id'];
                                    $data[$i]['jwt_token'] = $row['jwt_token'];
                                    $data[$i]['is_active'] = $row['is_active'];
                                    $i++;
                                }
                            }
                        }
                        
                        if (!empty($data)) {
                            $done = array(
                                'status'=> true,
                                'code'=> 200,
                                'data'=> $data
                            );
                            echo json_encode($done);
                            exit;
                        }else {
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Data is not available.' 
                            );

                            echo json_encode($err);
                            exit;
                        }
                    }

                    //================Make default ==========
                    if($_GET['type'] == 'make_default'){
                        $user_id = $_SESSION['user']['id'];
                        if(!empty($_POST)){
                            $id = (isset($_POST['id'])) ? $_POST['id'] : validationMsg('Data is not found.');
                            $query = "SELECT * from project where `user_id` = '$user_id' AND `deleted_at` = '0' AND id = '$id'";
                            $result = mysqli_query($conn, $query);
                            $data = mysqli_fetch_assoc($result);
                            if(isset($data) && $data != null){
                                $update_query = "UPDATE `project` SET `is_active` = '1' WHERE `user_id` = '$user_id' AND id = '$id'";
                                $up_result = mysqli_query($conn, $update_query);
                                
                                $update_all_data = "UPDATE `project` SET `is_active` = '0' WHERE `user_id` = '$user_id' AND id <> '$id'";
                                $all_result = mysqli_query($conn, $update_all_data);

                                $success = array(
                                    'status'=> true,
                                    'code'=> 200,
                                    'message'=> 'Project make default successfully.'
                                );

                                echo json_encode($success);
                                exit;
                            }else{
                                $err = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Data is not available.'
                                );
    
                                echo json_encode($err);
                                exit;
                            }
                        
                        }else{
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Data is missing.'
                            );

                            echo json_encode($err);
                            exit;
                        }
                    }

                    //===========Get Project=======
                    if($_GET['type'] == 'retrive_project'){
                        if(!empty($_POST)){
                            $user_id = $_SESSION['user']['id'];
                            $id = (isset($_POST['id'])) ? $_POST['id'] : validationMsg('Data is not found.');
                            $query = "SELECT * from project where `user_id` = '$user_id' AND `deleted_at` = '0' AND `id` = '$id'";
                            // echo $query;exit;
                            $data = [];
                            if($result = mysqli_query($conn, $query)){
                                if(mysqli_num_rows($result) > 0){
                                    $i = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        $data[$i]['id'] = $row['id'];
                                        $data[$i]['name'] = $row['name'];
                                        $data[$i]['c_id'] = md5($row['api_key']);
                                        $data[$i]['c_secret'] = md5($row['client_secret']);
                                        $data[$i]['org_id'] = md5($row['org_id']);
                                        $data[$i]['jwt_token'] = md5($row['jwt_token']);
                                        $data[$i]['is_active'] = (int)$row['is_active'];
                                        $i++;
                                    }
                                }
                            }
                            
                            if (!empty($data)) {
                                $done = array(
                                    'status'=> true,
                                    'code'=> 200,
                                    'data'=> $data
                                );
                                echo json_encode($done);
                                exit;
                            }else {
                                $err = array(
                                    'status'=> false,
                                    'code'=> 200,
                                    'message'=> 'Data is not available.' 
                                );

                                echo json_encode($err);
                                exit;
                            }
                        }else{
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Data is missing.'
                            );
                            echo json_encode($err);
                            exit;
                        }
                    }


                }else{
                    $err = array(
                        'status'=> false,
                        'code'=> 404,
                        'message'=> 'Page not found.'
                    );
                    echo json_encode($err);
                    exit;
                }
            }else{
                logoutMsg();
                exit;
            }
        }else{
            logoutMsg();
            exit;
        }
    }else{
        logoutMsg();
        exit;
    }
}else{
    logoutMsg();
    exit;
}

function logoutMsg(){
    session_destroy();
    $err = array(
        'status'=> false,
        'code'=> 400,
        'message'=> 'user is logout.'
    );
    echo json_encode($err);
    exit;
}

function validationMsg($msg){
    $err = array(
        'status'=> false,
        'code'=> 200,
        'message'=> $msg
    );
    echo json_encode($err);
    exit;
}

function checkExists($conn, $query, $msg){
    $res1 = mysqli_query($conn, $query);
    $check = mysqli_fetch_assoc($res1);
    if(isset($check) && $check != null){
        $err = array(
            'status'=> false,
            'code'=> 200,
            'message'=> $msg
        );
        echo json_encode($err);
        exit;
    }else{
        return true;
    }
}

?>