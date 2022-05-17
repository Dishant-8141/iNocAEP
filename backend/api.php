<?php
    include('../config.php');
    session_start();

    if (isset($_GET)) {
        if(isset($_GET['type'])){

            $type = $_GET['type'];

            //============Register User============
            if($type == 'register'){
                if(!empty($_POST)){
                    $first_name = $_POST["first_name"];
                    $last_name = $_POST["last_name"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $password = md5($_POST["password"]);
                    
                    $unique_key = uniqid();

                    $query = "SELECT * from user where email = '".$email."' OR contact_no = '".$phone."'";
                    $res1 = mysqli_query($conn, $query);
                    $check = mysqli_fetch_assoc($res1);

                    if($check != NULL){
                        if($email == $check['email']){
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Email is already exists.'
                            );
                    
                            echo json_encode($err);
                            exit;
                        }
                        if($phone == $check['contact_no']){
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Phone number is already exists.'
                            );
                    
                            echo json_encode($err);
                            exit;
                        }
                    }

                    $sql = "INSERT INTO user(first_name, last_name, email, contact_no, `user_id`, `password`)
                            VALUES ('$first_name', '$last_name', '$email', '$phone', '$unique_key', '$password')";
                        
                    $res2 = mysqli_query($conn, $sql);

                    if($res2 == true){
                        $done = array(
                            'status'=> true,
                            'code'=> 200,
                            'message'=> '<p> User registration successfully now login with this user id <b>'.$unique_key.'</b></p>'
                        );
                
                        echo json_encode($done);
                        exit;
                    }else{
                        $err = array(
                            'status'=> false,
                            'code'=> 200,
                            'message'=> 'Something went wrong in insert data.'
                        );
                
                        echo json_encode($err);
                        exit;
                    }
                }else{
                    $err = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Data are missing.'
                    );
            
                    echo json_encode($err);
                    exit;
                }
            }

            //============Login User============
            if($type == 'login'){
                if (!empty($_POST)) {
                    $user_id = $_POST['user_id'];
                    $password = md5($_POST['password']);

                    $query = "SELECT * from user where email = '".$user_id."' OR  user_id = '".$user_id."'";
                    $res1 = mysqli_query($conn, $query);
                    $check = mysqli_fetch_assoc($res1);

                    if($check != NULL){
                        if($password == $check['password']){
                            $_SESSION['logged_in'] = true;
                            $_SESSION['user']['id'] = $check['id'];
                            $_SESSION['user']['name'] = $check['first_name'].' '.$check['last_name'];
                            $_SESSION['user']['email'] = $check['email'];
                            $_SESSION['user']['user_id'] = $check['user_id'];

                            $done = array(
                                'status'=> true,
                                'code'=> 200,
                                'message'=> 'You have successfully logged in.'
                            );

                            echo json_encode($done);
                            exit;

                        } else {
                            $err = array(
                                'status'=> false,
                                'code'=> 200,
                                'message'=> 'Password invalid.'
                            );
                    
                            echo json_encode($err);
                            exit;
                        }
                    } else {
                        $err = array(
                            'status'=> false,
                            'code'=> 200,
                            'message'=> 'Invalid credentials.'
                        );
                
                        echo json_encode($err);
                        exit;
                    }
                
                }else{
                    $err = array(
                        'status'=> false,
                        'code'=> 200,
                        'message'=> 'Data are missing.'
                    );
            
                    echo json_encode($err);
                    exit;
                }
            }

        }else{
            $err = array(
                'status'=> false,
                'code'=> 400,
                'message'=> 'Invalid type in URL.'
            );
    
            echo json_encode($err);
            exit;
        }
    }else{
        $err = array(
            'status'=> false,
            'code'=> 400,
            'message'=> 'Invalid url.'
        );

        echo json_encode($err);
        exit;
    }

?>