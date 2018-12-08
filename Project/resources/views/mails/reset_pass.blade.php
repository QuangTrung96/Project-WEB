<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <style type="text/css">
      .container {
        width: 100%;
        height: auto;
        background-color: #eeeeee;
        font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
      }

      .panel {
        width: 580px;
        height: 475px;
        margin: 0 auto;
        background-color: #ffffff;
      }

      .panel-header {
        background-color: #309da9;
      }

      .panel-header {
        height: 110px;
        padding-top: 5px;
        padding-left: 45px;
        padding-bottom: 10px;
      }

      .panel-header img {
        float: left;
      }

      .panel-header span {
        float: left;
        font-size: 25px;
        margin-top: 40px;
        text-align: center;
        margin-left: 180px;
        color: rgb(255,255,255);
      }

      .panel-wapper {
        padding-top: 20px;
        padding-left: 10px;
      }

      #hr {
        margin-top: 40px;
        border-top-width:1px;
        border-top-style:dashed;
        border-top-color:rgb(221,221,221);
      }

      #contact {
        display: block;
        text-align: center;
        margin-block-end: 1em;
        margin-inline-end: 0px;
        margin-block-start: 1em;
        margin-inline-start: 0px;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="panel">
        <div class="panel-header">
          <img src="{{ $message->embed(public_path() . '/bluesky/img/header/logo.png') }}" />
          <span>Thay đổi mật khẩu!</span>
        </div>
        <div class="panel-wapper">
          <p style="color: black">
            Chào bạn <strong>{{ $full_name }}</strong>,
          </p>
          <p>
            Cám ơn bạn đã thực hiện yêu cầu xác nhận lấy lại mật khẩu, sau đây là mậy khẩu mới của bạn.
          </p>
          Mật khẩu: <b style="color: red">{{ $password }}</b>
          <p><a href="{{ route('index') }}" target='_blank'>Nhấp chuột, để quay trở lại trang web.</a></p>
          <strong>(Ps: Vui lòng, đặt lại mật khẩu ngay trong lần đăng nhập đầu tiên.)</strong>
          <p>Trân trọng.</p>
          <p id="hr">&nbsp;</p>
          <p id="contact">
            Mọi thắc mắc xin vui lòng liên hệ: admin@hus.edu.vn
          </p>
        </div>
      </div>
    </div>
  </body>
</html>