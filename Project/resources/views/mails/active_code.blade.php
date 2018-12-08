<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <style type="text/css">
      .container {
        width: 100%;
        color: #222;
        height: auto;
        background-color: #eeeeee;
        font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
      }

      .panel {
        width: 580px;
        height: 420px;
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
          <p>
            Chào bạn <strong>{{ $full_name }}</strong>,
          </p>
          <p>
            Bạn vừa gửi yêu cầu, lấy lại mật khẩu cho chúng tôi.
          </p>
          <p>
            Để thay đổi mật khẩu, vui lòng nhấp chọn vào lên kết bên dưới.
          </p>
          <ul>
            <li>
              <a href="{{ route('active_reset_get', [$username, urlencode($code)]) }}">Nhấn chuột vào đây để xác nhân.</a>
            </li>
          </ul>
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