<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jedah Noodle Factory</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.addons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
  </head>
  <body>
    <div class="authentication-theme auth-style_1">
      <div class="row">
        <div class="col-12 logo-section" align="center">
          <img src="{{ asset('assets/images/machinery.svg') }}" style="width: 100px;" alt="logo" />
        </div>
      </div>
      <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
          <div class="grid shadow">
            <div class="grid-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group" align="center" style="font-size: 25px; margin-top: -20px;">
                      Welcome
                  </div>
                </div>
                @if ($message = Session::get('false'))
                <div class="col-12 text-center mb-4">
                  <div class="btn btn-outline-primary" style="color: #696ffb; background-color: #fff;">
                    {{ $message }}
                  </div>
                </div>
                @endif
              </div>
              <div class="row">
                <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                  <form action="{{ url('/account_login') }}" method="POST">
                    @csrf
                    <div class="form-group input-rounded">
                      <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off" />
                    </div>
                    <div class="form-group input-rounded">
                      <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off"/>
                    </div>
                    <div class="form-inline">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" class="form-check-input" />Remember me <i class="input-frame"></i>
                        </label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> Login </button>
                  </form>
                  <!-- <div class="signup-link">
                    <p>Don't have an account yet?</p>
                    <a href="#">Sign Up</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('assets/vendors/js/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
  </body>
</html>