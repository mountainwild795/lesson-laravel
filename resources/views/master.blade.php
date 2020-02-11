<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  {{-- <link rel="stylesheet" href="{{asset('css/weui.css')}}">
  <link rel="stylesheet" href="{{asset('css/book.css')}}"> --}}
  {{-- <link rel="stylesheet" href="/css/book.css"> --}}
  <link rel="stylesheet" href="{{asset('build/book.min.css')}}">
</head>
<body>

  <div style="text-align:center" class="bk_title_bar">
    <img style="float: left" class="bk_back" src="{{asset('images/back.png')}}" alt="back" onclick="history.go(-1)">
    <p style="display: inline-block; text-align: center; height: 50px; line-height: 50px" class="bk_title_content"></p>
    <img style="float: right" class="bk_menu" src="{{asset('images/menu.png')}}" alt="menu" onclick="onMenuClick()" >
  </div>

  <div class="page">
      @yield('content')
  </div>
  

 <!-- tooltips -->
<div class="bk_toptips"><span></span></div>

{{-- <div id="global_menu" onclick="onMenuClick();">
  <div></div>
</div> --}}

<!--BEGIN actionSheet-->
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">Main page</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">Book Category</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">Cart</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">My Order</div>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>
</body>
{{-- <script src="/js/jquery-1.11.2.min.js"></script> --}}
{{-- <script src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('js/book.js')}}"></script> --}}
<script src="{{asset('build/book.min.js')}}"></script>

@yield('my-js')
</html>