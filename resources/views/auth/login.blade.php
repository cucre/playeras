<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Control de venta de playeras</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/css/default/app.min.css" rel="stylesheet" />
    <link href="assets/css/default/theme/blue.min.css" rel="stylesheet" id="theme-css-link">
    <!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show">
        <span class="spinner"></span>
    </div>
    <!-- end #page-loader -->
    
    <!-- begin login-cover -->
    <div class="login-cover">
        <div class="login-cover-image" style="background-image: url(/assets/img/login-bg/login-bg-17.jpg)" data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    <!-- end login-cover -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> Venta de <b>Playeras </b>
                    <small>Control de ventas</small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{ url('/login') }}" method="post" class="margin-bottom-0">
                    @csrf
                    <div class="form-group m-b-20">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="Correo electrónico" required/>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Contraseña" required/>
                    </div>
                    {{-- <div class="checkbox checkbox-css m-b-20">
                        <input type="checkbox" id="remember_checkbox" /> 
                        <label for="remember_checkbox">
                            Remember Me
                        </label>
                    </div> --}}
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Entrar</button>
                    </div>
                    {!! $errors->first('email', '<br><div class="alert alert-danger text-center">:message</div>') !!}
                    <div class="m-t-20 text-center">
                        ¿No recuerdas tu contraseña? <br>Haz click <a href="javascript:;">aquí</a> para recuperarla.
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
        
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/theme/default.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    
</body>
</html>