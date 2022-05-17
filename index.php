<?php
        session_start();
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // print_r($_SESSION);exit;

        if(isset($_SESSION)){
                if (!empty($_SESSION)) {
                        if ($_SESSION['logged_in'] == true || isset($_SESSION['user'])) {
                                echo "<script> location.href='$actual_link"."dashboard/'; </script>";
                                exit;
                        } else {
                                echo "<script> location.href='$actual_link"."login/'; </script>";
                                exit;
                        }
                } else {
                        echo "<script> location.href='$actual_link"."login/'; </script>";
                        exit;
                }
        } else {
                echo "<script> location.href='$actual_link"."login/'; </script>";
                exit;
        }

?>