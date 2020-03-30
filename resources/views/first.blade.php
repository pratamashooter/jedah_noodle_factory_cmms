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
    @if($user->count() == 0)
    <div class="authentication-theme auth-style_1">
      <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
          <div class="grid shadow">
            <p class="grid-header">First Account (ADMIN)</p>
            <div class="grid-body">
              <div class="item-wrapper">
                <form method="POST" action="{{ url('/create_first') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row showcase_row_area" style="margin-top: -20px;">
                    <div class="col-md-2 showcase_text_area">
                      <label for="name">Name</label>
                    </div>
                    <div class="col-md-10 showcase_content_area">
                      <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 showcase_text_area">
                      <label for="role">Role</label>
                    </div>
                    <div class="col-md-10 showcase_content_area">
                      <input type="text" class="form-control" id="role" placeholder="" value="admin" readonly="" name="role" required="">
                    </div>
                  </div>
                  <div class="row showcase_row_area mb-3">
                    <div class="col-md-2 showcase_text_area">
                      <label>Image</label>
                    </div>
                    <div class="col-md-10 showcase_content_area">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="avatar" name="avatar">
                        <label class="custom-file-label" for="avatar" id="file_name">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area mt-4">
                    <div class="col-md-2 showcase_text_area">
                      <label for="username">Username</label>
                    </div>
                    <div class="col-md-10 showcase_content_area">
                      <input type="text" class="form-control" id="username" placeholder="Enter you username" name="username" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_row_area">
                    <div class="col-md-2 showcase_text_area">
                      <label for="password">Password</label>
                    </div>
                    <div class="col-md-10 showcase_content_area">
                      <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required="">
                    </div>
                  </div>
                  <div class="form-group row showcase_content_area">
                    <div class="col-md-12 showcase_content_area">
                      <button type="submit" class="btn btn-sm btn-primary btn-block">CREATE</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="error_page error_2">
      <div class="container inner-wrapper">
        <h1 class="display-1 error-heading">Hello!</h1>
        <h2 class="error-code">You must login first</h2>
        <a href="{{ url('/login') }}" class="btn btn-outline-primary" style="width: 150px;">Login</a>
      </div>
    </div>
    @endif
    <script src="{{ asset('assets/vendors/js/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.addons.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $('input[type="file"]').change(function(e){
              var fileName = e.target.files[0].name;
              $('#file_name').html(fileName);
          });
      });
    </script>
  </body>
</html>