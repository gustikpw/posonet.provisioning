<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    
    <title><?php echo $title; ?> | Login</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/inspinia271/img/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/inspinia271/img/favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/inspinia271/img/favicon/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?php echo base_url('assets/inspinia271/img/favicon/site.webmanifest') ?>">
    <link href="<?php echo base_url('assets/inspinia271/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/inspinia271/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">


    <link href="<?php echo base_url('assets/inspinia271/css/animate.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/inspinia271/css/style.css') ?>" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <!-- <h2 class="font-bold">Welcome to POSO TV App</h2> -->
                <br>
                <img src="<?= base_url('assets/posonet/img/poso_net_fit.png') ?>" class="m-t-lg m-r-lg" height="80px" width="auto" alt="Logo POSO Net">

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" action="<?php echo site_url('login/login?_rdr=' . urlencode($this->input->get('_rdr'))) ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                    </form>
                    <p class="m-t">
                        <small><span><?php if (!isset($_SESSION['errors'])) {
                                            echo "Inspinia we app framework base on Bootstrap 3 &copy; 2014";
                                        } else {
                                            echo $_SESSION['errors'];
                                        } ?></span></small>
                    </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright PT. POSO MEDIA VISION - POSO NET
            </div>
            <div class="col-md-6 text-right">
                <small>© 2020-<?php echo date('Y') ?></small>
            </div>
        </div>
    </div>
</body>

</html>