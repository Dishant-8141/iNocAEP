<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        
            session_start();
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $logged_in = false;
            // print_r($_SESSION);exit;
            if(isset($_SESSION)){
                if (!empty($_SESSION)) {
                    if ($_SESSION['logged_in'] == true && isset($_SESSION['user'])) {
                        $logged_in = true;
                    }
                }
            }

            if ($logged_in == true) {
                // echo "<script> location.href='$actual_link"."dashboard/'; </script>";
                header("location: ../dashboard/");
                exit;
            }

        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INocAEP | Sign in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
        <style>
            .error {
                color: red;
                font-weight: 400;
                display: block;
                padding: 6px 0;
                font-size: 14px;
            }
            .form-control.error {
                border-color: red;
                padding: .375rem .75rem;
            }  

        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>iNoc</b>AEP</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form method="post" role="form" id="loginForm" action="#">
                        <div class="input-group mb-3">
                            <div class="col-12">
                                <input type="text" id="userId" placeholder="Enter user id or email" name="userId" class="form-control" autofocus>
                            </div>    
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div> -->
                        </div>
            
                        <div class="input-group mb-3">
                            <div class="col-12">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div> -->
                        </div>
                
                        <div class="row">
                            <!-- <div class="col-8">
                                <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                                </div>
                            </div> -->
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block login-button">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <!-- <div class="social-auth-links text-center mt-2 mb-3">
                        <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                        </a>
                    </div> -->
                    <!-- /.social-auth-links -->

                    <!-- <p class="mb-1">
                        <a href="forgot-password.html">I forgot my password</a>
                    </p> -->
                    <p class="mt-1">
                        <a href="../register/" class="text-center">Register a new membership</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
        <!-- jQuery -->
        <script src="../assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Toastr -->
        <script src="../assets/plugins/toastr/toastr.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../assets/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../assets/dist/js/demo.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
        
        <script type="text/javascript">
        
            $(document).ready(function(){

                $(".login-button").removeAttr('disabled');

                var url = window.location.href;
                url = url.slice(0, url.lastIndexOf('/'));
                url = url.slice(0, url.lastIndexOf('/'));
            
                $("#loginForm").validate({
                    // Define validation rules
                    rules: {
                        userId: {
                            required: true
                        },                   
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6,
                            // maxlength: 10,
                        },
                    },
                    messages: {
                        userId: {
                            required: "User id or email is required."
                        },
                        password: {
                            required: "Password is required",
                            minlength: "Password must be min 6 characters long",
                            // maxlength: "Password must not be more than 10 characters long",
                        },
                    },
                    submitHandler: function (form) {
                        // form.submit();
                        $(".login-button").attr('disabled', 'disabled');

                        var data = {
                            "user_id": $('#userId').val(),
                            "password": $('#password').val()
                        };

                        $.ajax({
                            url: url+'/backend/api.php?type=login',
                            type: "POST",
                            headers: {
                                "accept": "application/json",
                                "Access-Control-Allow-Origin": "*"
                            },
                            data: data,
                            success: function (response) {
                                $(".login-button").removeAttr('disabled');
                                var res = JSON.parse(response);
                                if(res.status == true){
                                    toastr.success(res.message);
                                    window.location.href = url; 
                                }else{
                                    toastr.error(res.message);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $(".login-button").removeAttr('disabled');
                                toastr.error('Something went wrong on server side');
                            }
                        })
                    }
                });
            })
        </script>
    </body>
</html>
