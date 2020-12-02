<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="shortcut icon" sizes="16x16" href="{{asset('assets/portal-side/img/favicon.png')}}">
        <link rel="shortcut icon" sizes="196x196" href="{{asset('assets/portal-side/img/favicon.png')}}">

        <!-- Vendor styles -->
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/material-design-iconic-font.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/animate.min.css')}}">

        <!-- App styles -->
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/app.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/portal-side/css/custom.css')}}">
      
        <script type="text/javascript">
            var base_url    = "{{asset('')}}";
            var favicon    = "";
        </script>
    </head>

    <body data-ma-theme="green">
        <div class="form_error">
            <?php //echo validation_errors(); ?>
        </div>
        <div class="login">
            <?php
            //$success = $this->session->flashdata('success');
           // $error = $this->session->flashdata('error');
            ?>
            <!-- Login -->
            <div class="login__block active" id="l-login">
                <div class="login__block__header">
                    <i class="zmdi zmdi-account-circle"></i>
                    Hi there! Please Sign in
                </div>
                    
                <div class="login__block__body">
                    @if ($errors->has('loginerror'))
                        <div class="alert alert-icon alert-danger border-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ $errors->first('loginerror') }}
                        </div>
                    @endif
                    <form method="post" id="login_form" action="{{ route('login') }}">  
                        {{ csrf_field() }}
                        <div class="form-group form-group--centered ">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                        </div>
                            
                        <div class="form-group form-group--centered">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                             @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>            
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">Login <i class="zmdi zmdi-long-arrow-right"></i></button>
                        </div>
                        <div class="form-group form-group--float form-group--centered">
                            <a data-ma-action="login-switch" data-ma-target="#l-forget-password" href="#" style="color: #4e69b1;">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div> 
            <!-- Forgot Password -->
            <div class="login__block" id="l-forget-password">
                <div class="login__block__header palette-Purple bg">
                    <i class="zmdi zmdi-account-circle"></i>
                    Forgot Password?
                </div>
                    
                <div class="login__block__body">
                    <p class="mt-4">Lorem ipsum dolor fringilla enim feugiat commodo sed ac lacus.</p>
                    <form method="post" id="forget_form" action="{{asset('user/forgot_password')}}"> 
                        <div class="form-group form-group--centered">
                            <label>Email Address</label>
                            <input type="text" id="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <button  type="submit" class="btn btn-success waves-effect btn-lg">Reset Password</button>
                        </div>
                            
                        <div class="form-group form-group--float form-group--centered">
                            <a data-ma-action="login-switch" data-ma-target="#l-login" href="#" style="color: #4e69b1;">Click here to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <!-- Vendors -->
        <script src="{{asset('assets/portal-side/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/tether.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/waves.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/app.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/portal-side/js/manifest.json')}}"></script>
      
    </body>
</html>