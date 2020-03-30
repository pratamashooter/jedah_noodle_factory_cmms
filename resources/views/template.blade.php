<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jedah Noodle Factory</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="shortcut icon" href=""/>
    <style type="text/css">
      [list]::-webkit-calendar-picker-indicator {
        display: none;
      }
      .timeline-vertical .my-activity-log:before {
        background-color: #dc3545;
      }
      .chat-card{
        bottom: 20px;
        right: 75px;
      }
      .chat-btn{
        position: fixed;
        bottom: 30px;
        right: 25px;
        text-align: center;
        line-height: 50px;
        font-size: 22px;
        -webkit-transition: width 0.7s, height 0.7s, -webkit-transform 0.7s; /* Safari */
        transition: width 0.7s, height 0.7s, transform 0.5s;
      }

      .chat-btn:active{
        -webkit-transform: rotate(-360deg);
        transform: rotate(-360deg);
      }
    </style>
    @yield('css')
  </head>
  <body class="header-fixed">
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="{{ url('/dashboard') }}">
          <img class="logo" src="{{ asset('assets/images/machinery.svg') }}" style="width: 50px; margin-left: 15px;" alt="">
          <img class="logo-mini" src="{{ asset('assets/images/machinery.svg') }}" style="width: 20px;" alt="">
        </a>
      </div>
      <div class="t-header-content-wrapper">
        <div class="t-header-content">
          <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
            <i class="mdi mdi-menu"></i>
          </button>
          <form method="POST" id="searchForm" class="t-header-search-box">
            @csrf
            <div class="input-group">
              <input type="text" class="form-control search_pages" name="name_pages" id="inlineFormInputGroup" placeholder="Search" autocomplete="off" list="data-search">
              <button class="btn btn-primary" type="submit" data-toggle="modal" data-target="#searchModal"><i class="mdi mdi-arrow-right-thick"></i></button>
            </div>
          </form>
          <ul class="nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-bell-outline mdi-1x"></i>
                <div class="notif-management">
                  
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">Notifications</h6>
                  <p class="dropdown-title-text">Notifications today</p>
                </div>
                <div class="dropdown-body" id="notif-nav">
                  
                </div>
                <div class="dropdown-footer">
                  <a href="#" role="button" data-toggle="modal" data-target="#notifModal">View All</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="messageDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-message-outline mdi-1x"></i>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="messageDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">Messages</h6>
                  <p class="dropdown-title-text">You have new messages</p>
                </div>
                <div class="dropdown-body" id="message-nav">

                </div>
                <div class="dropdown-footer">
                  <a href="#" role="button" data-toggle="modal" data-target="#messageModal">View All</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" role="button" href="#" id="messageDropdown" data-toggle="modal" data-target="#ExitModal">
                <i class="mdi mdi-logout-variant mdi-1x"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="page-body">
      <div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" src="{{ asset('picture/'.auth()->user()->avatar) }}" alt="profile image">
          </div>
          <div class="info-wrapper">
            <a href="{{ url('/setting_profile') }}" class="btn btn-primary btn-xs text-center mdi mdi-settings border-0" style="margin-top:-10%; position: relative; background-color: #21D4FD;
            background-image: linear-gradient(19deg, #21D4FD 0%, #696ffb 100%);"></a>
            <p class="user-name" style="font-size: 16px; margin-top: 0;">{{ auth()->user()->name }}</p>
            <h6 class="display-income">{{ auth()->user()->role }}</h6>
          </div>
        </div>
        @yield('nav')
      </div>
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="notifModalLabel">Notifications Today</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <ul class="list-group" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;" id="list-notification">
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="head-modal">
                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="close mr-3" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="col-md-12 mt-2 ml-4">
                        <h5>
                          Messaging
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row showcase_row_area mt-3" align="center">
                      <div class="col-md-12 showcase_content_area pr-4 pl-4">
                        <input type="search" placeholder="Search Message" class="form-control" id="search" name="search" autocomplete="off" value="">
                      </div>
                    </div>
                  </div>
                  <form method="POST" class="send-message-form">
                    <div class="grid" style="margin-top: -20px;">
                      <div class="grid-body">
                        <div class="vertical-timeline-wrapper">
                          <div class="timeline-vertical dashboard-timeline" style="flex-direction: column-reverse; display: flex; overflow-x: hidden;" id="message-list">
                            
                          </div>
                        </div>
                      </div>
                      @csrf
                      <div class="form-group row showcase_row_area mt-3" align="center">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 showcase_content_area">
                          <input type="text" name="id_user" value="{{ auth()->user()->id }}" hidden="">
                          <input type="text" name="avatar" value="{{ auth()->user()->avatar }}" hidden="">
                          <input type="text" name="name" value="{{ auth()->user()->name }}" hidden="">
                          <textarea placeholder="Type Message" class="form-control" id="message" cols="3" rows="3" name="message" autocomplete="off"></textarea>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <button class="btn btn-success has-icon btn-block mt-4" type="submit">
                            <i class="mdi mdi-send mdi-1x"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="ExitModal" tabindex="-1" role="dialog" aria-labelledby="ExitModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12 col-md-12">
                      <button type="button" class="close mr-3" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="col-lg-12 col-md-12 mt-2 text-center">
                      <img src="{{ asset('icons/undraw_QA_engineers_dg5p.svg') }}" style="width: 200px;">
                    </div>
                    <div class="col-lg-12 col-md-12 mt-3 text-center">
                      <h5>You sure want to logout?</h5>
                      <p>Click logout to continue and cancel to return</p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <a href="{{ url('/logout') }}" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="searchModalLabel"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <ul class="list-group" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;" id="list-search">
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <a href="#" role="button" class="chat-btn btn-rounded btn social-icon-btn btn-primary" style="z-index: 1000;" data-toggle="modal" data-target="#messageModal"><i class="mdi mdi-comment-text-outline"></i></a>
          @yield('content')
        </div>
      </div>
    </div>
<script src="{{ asset('assets/vendors/js/core.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/charts/chartjs.addon.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<script src="{{ asset('js/sweetAlert.js') }}"></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/pushnotif.js') }}"></script>
<script type="text/javascript">
if (window.webshims) {
    webshims.setOptions('forms', {
        customDatalist: true
    });
    webshims.polyfill('forms');
}

$('#searchForm').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/search_page') }}",
    method: "POST",
    data: request,
    contentType: false,
    processData: false,
    success:function(response){
      var length = response.length;
      var lenthLoop = length - 1;
      var searchResultText = 'About ' + length + ' results';
      var searchResultList = '';
      $('#searchModalLabel').html(searchResultText);
      for(var i = 0; i <= lenthLoop; i++){
        searchResultList += '<a href="'+ response[i].page_url +'" class="url_search_load"><div class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1 year" style="color: #696ffb;">'+ response[i].page_name +'</h5></div><p class="mb-1">localhost:8000/'+ response[i].page_url +'</p></div></a>';
      }
      $('#list-search').html(searchResultList);
    }
  });
});

@if ($message = Session::get('search_failed'))
Swal.fire({
  icon: 'question',
  text: '{{ $message }}',
  showConfirmButton: false,
  timer: 1500
})
@endif

$(document).ready(function(){
    setInterval(function() {
        loadNavMessage();
        loadListMessage();
    }, 15000);
});

$('.chat-btn').on('click', function(){
  loadListMessage();
});

$(".element").sort(function (a, b) {
    return new Date($(".year", a).data("date")) - new Date($(".year", b).data("date"));
}).appendTo(".element");

$(document).ready(function(){
  $('#search').on('keyup', function(){
    var searchTerm = $(this).val().toLowerCase();
    $(".activity-log").each(function(){
      var lineStr = $(this).text().toLowerCase();
      if(lineStr.indexOf(searchTerm) == -1){
        $(this).hide();
      }else{
        $(this).show();
      }
    });
  });
});

function loadNavMessage(){
  $.ajax({
    url: "{{ url('/message_nav') }}",
    success:function(data){
      $('#message-nav').html(data);
    }
  });
}

loadNavMessage();

function loadNavNotif(){
  $.ajax({
    url: "{{ url('/notif_nav') }}",
    success:function(data){
      $('#notif-nav').html(data);
    }
  });
}

loadNavNotif();

function loadListMessage(){
  $.ajax({
    url: "{{ url('/message_list') }}",
    success:function(data){
      $('#message-list').html(data);
    }
  });
}

loadListMessage();

function loadListNotif(){
  $.ajax({
    url: "{{ url('/notif_list') }}",
    success:function(data){
      $('#list-notification').html(data);
    }
  });
}

loadListNotif();

function countNotif(){
  $.ajax({
    url: "{{ url('/notif_count') }}",
    success:function(data){
      if(data != 0){
        var notification = '<span class="notification-indicator notification-indicator-primary notification-indicator-ripple" id="notification-notification"></span>';
        $('.notif-management').html(notification);
      }else{
        $('.notif-management').html('');
      }
    }
  });
}

countNotif();

$('.send-message-form').submit(function(e){
  e.preventDefault();
  var request = new FormData(this);
  $.ajax({
    url: "{{ url('/send_message') }}",
    method: "POST",
    data: request,
    contentType: false,
    cache: false,
    processData: false,
    success:function(data){
      if(data == "success"){
        $('#message').val('');
        loadListMessage();
      }
    }
  });
});

$('.sample-btn').click(function(){
  Push.create("Hello world!",{
    body: "This is example of Push.js Tutorial",
    icon: "{{ asset('assets/images/machinery.svg') }}",
    onClick: function () {
        window.focus();
        this.close();
    }
  });
});

</script>
    @yield('javascript')
  </body>
</html>