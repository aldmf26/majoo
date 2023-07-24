<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <title>{{ $title }}</title>
  </head>
  <style>
      .login-page, .register-page {
        -ms-flex-align: center;
        align-items: center;
        background: #e9ecef;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        height: 100vh;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .login-box, .register-box {
        width: 360px;
    }
    .login-logo, .register-logo {
        font-size: 2.1rem;
        font-weight: 300;
        margin-bottom: 0.9rem;
        text-align: center;
    }
  </style>
  <body class="login-page" style="min-height: 398.078px;">
    <div class="login-box">
      <div class="login-logo">
      </div>
      <!-- /.login-logo -->
      <div class="card" style="border-radius: 25px;">
        <div class="card-body login-card-body" style="border-radius: 25px;">
           
          <center><img src="{{ asset('assets') }}{{ $img }}" class="brand-image" style="opacity: .8" width="100px;"></center>
        
          <!-- <p class="login-box-msg">Sign in to start your session</p> -->
          @if (Session::get('error'))
              <p style="color: red; font-style: italic;" class="text-center">Username / password salah!</p>
          @endif
          <form action="{{ route('login') }}" method="post">
            @csrf
            <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
            <div class="input-group mb-3">
              <input type="text" class="form-control" autofocus name="username" placeholder="Username" style="border-radius: 25px 0px 0px 25px; border-color: rgb(0, 183, 181); --darkreader-inline-border-top:#00c8c6; --darkreader-inline-border-right:#00c8c6; --darkreader-inline-border-bottom:#00c8c6; --darkreader-inline-border-left:#00c8c6;" value="" data-darkreader-inline-border-top="" data-darkreader-inline-border-right="" data-darkreader-inline-border-bottom="" data-darkreader-inline-border-left="">
              <div class="input-group-append">
                <div class="input-group-text" style="background: rgb(0, 183, 181); --darkreader-inline-bgimage: initial; --darkreader-inline-bgcolor:#009291;" data-darkreader-inline-bgimage="" data-darkreader-inline-bgcolor="">
                  <span class="fas fa-user text-light"></span>
                </div>
              </div>
            </div>
                    <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password" style="border-radius: 25px 0px 0px 25px; border-color: rgb(0, 183, 181); --darkreader-inline-border-top:#00c8c6; --darkreader-inline-border-right:#00c8c6; --darkreader-inline-border-bottom:#00c8c6; --darkreader-inline-border-left:#00c8c6;" data-darkreader-inline-border-top="" data-darkreader-inline-border-right="" data-darkreader-inline-border-bottom="" data-darkreader-inline-border-left="">
              
              <div class="input-group-append">
                <div class="input-group-text" style="background: rgb(0, 183, 181); --darkreader-inline-bgimage: initial; --darkreader-inline-bgcolor:#009291;" data-darkreader-inline-bgimage="" data-darkreader-inline-bgcolor="">
                  <span class="fas fa-lock text-light"></span>
                </div>
              </div>
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
                <button type="submit" class="btn btn-block text-light" style="background: rgb(0, 183, 181); border-radius: 25px; --darkreader-inline-bgimage: initial; --darkreader-inline-bgcolor:#009291;" data-darkreader-inline-bgimage="" data-darkreader-inline-bgcolor="">Sign In</button>
              </div>
    
            </div>
          </form>
    
          <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="{{ route('welcome') }}" class="btn btn-block text-light" style="background: rgb(0, 183, 181); border-radius: 25px; --darkreader-inline-bgimage: initial; --darkreader-inline-bgcolor:#009291;" data-darkreader-inline-bgimage="" data-darkreader-inline-bgcolor="">
              <i class="fas fa-arrow-circle-left mr-2"></i> Kembali ke menu
            </a>
            <!-- <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a> -->
          </div>
          <!-- /.social-auth-links -->
    
          <!-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p> -->
          <!-- <a href="https://localhost/majoo/Auth/registration" class="text-center">Register</a> -->
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>