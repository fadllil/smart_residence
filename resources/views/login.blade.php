<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset("assets/img/basic/favicon.ico")}}" type="image/x-icon">
    <title>Smart Residence</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/app.css")}}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }
        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>
<body>
<!-- Pre loader -->
<div id="loader" class="loader">
    <div class="plane-container">
        <div class="l-s-2 blink">LOADING</div>
    </div>
</div>

<div id="app" class="paper-loading">
    <div class="btn-fixed-top-left">
        <a href="documentations.html"
           class="btn-fab  btn-primary shadow1">
            <i class="icon icon-clipboard-list"></i>
        </a>
    </div>
<main>
    <div id="primary" class="blue4 p-t-b-100 height-full responsive-phone">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="assets/img/icon/icon-plane.png" alt="">
                </div>
                <div class="col-lg-6 p-t-100">
                    <div class="text-white">
                        <h1>Selamat Datang</h1>
                        <p class="s-18 p-t-b-20 font-weight-lighter">Silahkan masukkan email dan password
                        anda</p>
                    </div>
                    @if($message = Session::get('warning'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Warning!</strong> {{$message}}
                        </div>
                    @endif
                    <form method="POST" action="{{route('doLogin')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                    <input name="email" type="text" class="form-control form-control-lg no-b"
                                           placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                    <input name="password" type="password" class="form-control form-control-lg no-b"
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-success btn-lg btn-block" value="Login">
                                <p class="forget-pass text-white">Have you forgot your username or password ?</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #primary -->
</main>
<!-- Login modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog width-400" role="document">
        <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                            class="paper-nav-toggle active"><i></i></a>
            <div
                    class="modal-body no-p">
                <div class="text-center p-40 p-b-0">
                    <img src="assets/img/dummy/u4.png" alt="">
                    <h3>Welcome Back</h3>
                    <p class="p-t-b-20">Hey Soldier welcome back signin now there is lot of new stuff waiting
                        for you</p>
                </div>
                <div class="light p-40 b-t-b">
                    <form action="dashboard2.html">
                        <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                            <input type="text" class="form-control form-control-lg"
                                   placeholder="Email Address">
                        </div>
                        <div class="form-group has-icon"><i class="icon-user-secret"></i>
                            <input type="text" class="form-control form-control-lg"
                                   placeholder="Password">
                        </div>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Log In">
                        <small class="forget-pass">Have you forgot your username or password ?</small>
                    </form>
                </div>
                <div class="p-40"><a href="#" class="btn btn-lg btn-block btn-social facebook">
                    <i class="icon-facebook"></i> Login with Facebook
                </a>
                    <a href="#" class="btn btn-lg btn-block btn-social twitter">

                        <i class="icon-twitter"></i> Login with Twitter

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SignUp modal -->
<div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                            class="paper-nav-toggle active"><i></i></a>
            <div
                    class="modal-body no-p">
                <div class="row">
                    <div class="col-lg-5 grid">
                        <div class="p-40">
                            <h5 class="p-t-40">Sign Up Using Social Account</h5>
                            <p class="p-t-b-20">Hey Soldier welcome back signin now there is lot of new stuff waiting
                                for you</p> <a href="#" class="btn btn-lg btn-block btn-social facebook">
                            <i class="icon-facebook"></i> Login with Facebook
                        </a>
                            <a href="#" class="btn btn-lg btn-block btn-social twitter">

                                <i class="icon-twitter"></i> Login with Twitter

                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="light p-t-b-40">
                            <div class="p-40">
                                <h5 class="p-b-20">Create New User Account</h5>
                                <form action="dashboard2.html ">
                                    <div class="form-group has-icon"><i class="icon-user-circle"></i>
                                        <input type="text" class="form-control form-control-lg"
                                               placeholder="Your Name">
                                    </div>
                                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                        <input type="text" class="form-control form-control-lg"
                                               placeholder="Email Address">
                                    </div>
                                    <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                        <input type="text" class="form-control form-control-lg"
                                               placeholder="Password">
                                    </div>
                                    <div class="form-group has-icon"><i class="icon-repeat"></i>
                                        <input type="text" class="form-control form-control-lg"
                                               placeholder="Confirm Password">
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Sign Up Now">
                                    <p class="forget-pass">A verification email wil be sent to you</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<!--End Page page_wrrapper -->
<script src="{{asset("assets/js/app.js")}}"></script>

</body>
</html>
