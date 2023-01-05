<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/output.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>dist/output.css" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body>
    <div class="w-screen h-screen flex flex-col justify-center items-center lg:grid lg:grid-cols-2">
        <!-- <img src="<?php echo base_url() ?>assets/img/undraw_visionary_technology_re_jfp7.svg" class="hidden lg:block w-auto transform mx-auto" style="" /> -->
        <div id="lottie">
            <lottie-player src="<?= base_url() ?>assets/img/attendence.json" mode="bounce" background="transparent" speed="1" style="width: 350px; height: 350px;" class="hidden lg:block w-auto transform mx-auto" loop autoplay></lottie-player>
        </div>
        <form class="flex flex-col justify-center items-center w-1/2" style=" margin: auto;" method="post" action="<?= base_url() ?>Auth/dashboard">
            <img title="Company Logo" width="100px" src="<?php echo base_url() ?>assets/img/man-crop.gif" />
            <h5 class="my-4 font-display text-center">Attendance System</h5>
            <?= $this->session->flashdata('message'); ?>
            <!-- <h2 class="font-display font-semibold text-center text-2xl"> Hi, Welcome Back!</h2> -->
            <div class="relative form-group">
                <i class="fa fa-user absolute" style="font-size: 14px; line-height: 28px; margin-left: 10px;"></i>
                <input value="" name="username" type="text" placeholder="username" style="border-radius: 15px;" class="pl-8 border-b-2 font-display focus:outline-none capitalize text-lg" />
            </div>
            <small class="text-danger"><?= form_error('username') ?></small>
            <div class="relative" style="margin-top: 4px;">
                <i class="fa fa-lock absolute" style="font-size: 14px; line-height: 28px; margin-left: 10px;"></i>
                <input name="password" type="password" placeholder="password" class="pl-8 mt-1 border-b-2 font-display focus:outline-none capitalize text-lg" style="border-radius: 15px;" />
            </div>
            <div class="relative" style="margin-top: 4px;">
                <!-- <button type="submit" class="mt-4 px-10 py-1 bg-blue-600 rounded-full font-bold text-white transform hover:translate-y-1 transition-all duration-500">Login</button> -->
                <a href="<?php echo base_url() ?>auth" class="mt-4 px-10 py-1 bg-blue-600 rounded-full font-bold text-white transform hover:translate-y-1 transition-all duration-500">Login</a>
            </div>
            <small class="text-danger"><?= form_error('password') ?></small>

        </form>

        <div class="text-center" style="justify-content:center; width:100vw; display:flex; flex-direction: column;">
            <span>© 2023, Company Name</span>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<!--   Core JS Files   -->
<script src="<?= base_url() ?>assets/js/jquery.3.2.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $("#lottie").css("margin-left", "150px");
    })
</script>

</html>