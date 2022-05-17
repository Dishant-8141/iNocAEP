<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            
            session_start();
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $logged_in = false;

            if(isset($_SESSION)){
                if (!empty($_SESSION)) {
                    if ($_SESSION['logged_in'] == true && isset($_SESSION['user'])) {
                        $logged_in = true;
                    }
                }
            }

            if ($logged_in == true) {
                header("location: ../dashboard/");
                exit;
            }

        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>iNocAEP | Sign up </title>

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
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>iNoc</b>AEP</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <form class="form-horizontal" role="form" id="registerForm" action="#" method="POST">
                        <div class="input-group mb-3">
                            <div class = "col-6">
                                <input type="text" id="firstName" placeholder="First Name" name="firstName" class="form-control" autofocus>
                            </div>
                            <div class = "col-6">
                                <input type="text" id="lastName" placeholder="Last Name" name="lastName" class="form-control" autofocus>
                            </div>
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="input-group mb-3">
                            <div class = "col-12">
                                <input type="email" id="email" placeholder="Enter email" class="form-control" name= "email">
                            </div>
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="input-group mb-3">
                            <div class = "col-12">
                                <input type="phoneNumber" id="phoneNumber" placeholder="Enter phone number" name="phoneNumber" class="form-control">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class = "col-12">
                            <input type="password" id="password" placeholder="Enter password" name="password" class="form-control">
                            </div>
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="input-group mb-3">
                            <div class = "col-12">
                                <input type="password" id="c_password" placeholder="Retype password" name="confirmPassword" class="form-control">
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
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div> -->
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block register-button">Register</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <!-- <div class="social-auth-links text-center">
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Sign up using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i>
                            Sign up using Google+
                        </a>
                    </div> -->

                    <a href="../login/" class="text-center">I already have a membership</a>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
        <!-- /.register-box -->

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

                $(".register-button").removeAttr('disabled');

                var url = window.location.href;
                url = url.slice(0, url.lastIndexOf('/'));
                url = url.slice(0, url.lastIndexOf('/'));
                // alert(url);

                $("#registerForm").validate({
                    // Define validation rules
                    rules: {
                        firstName: {
                            required: true
                        },
                        lastName: {
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
                        confirmPassword: {
                            required: true,
                            minlength: 6,
                            // maxlength: 10,
                            equalTo : "#password"
                        },
                        phoneNumber: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            number: true
                        },
                    },
                    messages: {
                        firstName: {
                            required: "First name is required."
                        },
                        lastName: {
                            required: "Last name is required."
                        },
                        email: {
                            required: "Email is required.",
                            email: "Email is invalid."
                        },
                        phoneNumber: {
                            required: "Phone number is required.",
                            minlength: "Phone number must be min 10 characters long.",
                            maxlength: "Phone number must not be more than 10 characters long.",
                            number: "Enter only digits."
                        },
                        password: {
                            required: "Password is required.",
                            minlength: "Password must be min 6 characters long.",
                            // maxlength: "Password must not be more than 10 characters long",
                        },
                        confirmPassword: {
                            required: "Confirm password is required.",
                            minlength: "Confirm password must be min 6 characters long.",
                            // maxlength: "Confirm password must not be more than 10 characters long",
                            equalTo: "Password and confirm password is not match."
                        },
                    },
                    submitHandler: function (form) {
                        // form.submit();
                        $(".register-button").attr('disabled', 'disabled');

                        var data = {
                            "first_name": $('#firstName').val(),
                            "last_name": $('#lastName').val(),
                            "email": $('#email').val(),
                            "phone": $('#phoneNumber').val(),
                            "password": $('#password').val()
                        };

                        $.ajax({
                            url: url+'/backend/api.php?type=register',
                            type: "POST",
                            headers: {
                                "accept": "application/json",
                                "Access-Control-Allow-Origin": "*"
                            },
                            data: data,
                            success: function (response) {
                                $(".register-button").removeAttr('disabled');
                                var res = JSON.parse(response);
                                if(res.status == true){
                                    toastr.success(res.message)
                                }else{
                                    toastr.error(res.message)
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $(".register-button").removeAttr('disabled');
                                toastr.error('Something went wrong on server side');
                            }

                        })
                    }
                });
            })
    </script>
    </body>
</html>
