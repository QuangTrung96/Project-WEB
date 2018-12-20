<style>
    .table-log {
        border-spacing: 0;
        border-collapse: collapse;
        width: 100% !important
    }

    .table-log th {
        background: url("{{ env('APP_URL') }}/public/img/bg_box_head.jpg") repeat-x scroll 0 0 transparent;
        border-left: 1px solid #ffffff;
        border-right: 1px solid #ffffff;
        color: #dacdcd;
        font-size: 10px;
        font-weight: bold;
        padding: 3px;
        text-shadow: 0 1px #242424;
    }

    .table-log td, .table-log th {
        padding: 5px;
    }

    .dialog-content {
        max-height: 1000px;
        overflow-y: auto;
    }
</style>
<div class="dialog-content">
    <div class="h_title">{{$title}}</div>
    <table class="table-log">
        <thead>
        <tr>
            <th>MSV</th>
            <th>Họ và tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Môn học</th>
            <th>Điểm thi</th>
            <th>Thông tin thêm</th>
        </tr>
        </thead>
        <tbody>
           @foreach ($detail as $detail)
           <tr>
               @php
                 $as = json_decode($detail->attributes, true);
               @endphp
               <td>{{ $detail->student_code }}</td>
               <td>{{ $detail->last_name . ' ' . $detail->first_name }}</td>
               <td>{{ date("d-m-Y", strtotime($detail->birthday)) }}</td>
               @if ($detail->gender === 1)
                 <td>Nam</td>
               @else
                 <td>Nữ</td>
               @endif
               <td>{{ $detail->address }}</td>
               @php
                if ($detail->subject_name != '') {
                  echo '<td>' . $detail->subject_name . '</td>';
                } else {
                  echo '<td> ... </td>';
                }

                if ($detail->point != '') {
                  echo '<td>' . $detail->point . '</td>';
                } else {
                  echo '<td> ... </td>';
                }
               @endphp
               <td>
                 @if (count($as) > 0)
                   @foreach ($as as $a)
                     <span style="color: #3395F7">{{ $a['name'] }}</span>: <span>{{ $a['value'] }}</span><br />
                   @endforeach
                 @endif
               </td>
           </tr>
           @endforeach
        </tbody>
    </table>
    <div class="entry clear" style="padding: 5px 0; text-align: right; margin-top: 20px;">
        <button class="cancel" type="button" id="btn_cancel">Close</button>
    </div>
</div>