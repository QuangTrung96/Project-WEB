@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
</style>
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class="row">
    <div class="col-md-12">
      <div>
        <a href="{{ route('student.index') }}" class="btn btn-primary">Danh sách sinh viên</a>
      </div>
      <br />
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="{{ route('student.update', ['id' => $student->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-group {{ $errors->has('student_code') ? 'has-error' : '' }}">
              <label for="student_code">Mã sinh viên</label>
              <input type="text" class="form-control" id="student_code" name="student_code" placeholder="Mã sinh viên"
                value="{{ $student->student_code }}">
              <span class="help-block">{{ $errors->first('student_code') }}</span>
            </div>

            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
              <label for="last_name">Họ đệm</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Họ đệm"
                value="{{ $student->last_name }}">
              <span class="help-block">{{ $errors->first('last_name') }}</span>
            </div>

            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
              <label for="first_name">Tên</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Tên"
                value="{{ $student->first_name }}">
              <span class="help-block">{{ $errors->first('first_name') }}</span>
            </div>

            <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
              <label for="birthday">Ngày sinh</label>
              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh"
                value="{{ $student->birthday }}">
              <span class="help-block">{{ $errors->first('birthday') }}</span>
            </div>
            
            <div class="form-group">
              <label for="gender">Giới tính</label>
              <select name="gender" id="gender" class="form-control">
                <option value="1" {{ $student->gender === 1 ? 'selected' : '' }}>Nam</option>
                <option value="2" {{ $student->gender === 2 ? 'selected' : '' }}>Nữ</option>
              </select>
            </div>
            
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
              <label for="address">Địa chỉ</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ"
                value="{{ $student->address }}">
              <span class="help-block">{{ $errors->first('address') }}</span>
            </div>
            
            <div class="form-group" id="qt-app">
              <qt-attributes></qt-attributes>
            </div>
            <button type="submit" class="btn btn-success">Sửa sinh viên</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('body_scripts_bottom')
  <script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
  <script type="text/javascript" src="{{ asset('public/js/vue.js') }}"></script>
  <script type="text/x-template" id="qt-attributes-template">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Thuộc tính</th>
          <th>Giá trị</th>
        </tr>
      </thead>
      <br />
      <tbody>
        <tr v-for="(item, key) in attributes">
            <td><input type="text" :name="'attributes['+ key +'][name]'" v-model="item.name" class="form-control" placeholder="Thuộc tính"></td>
            <td><input type="text" :name="'attributes['+ key +'][value]'" v-model="item.value" class="form-control" placeholder="Giá trị"></td>
            <td>
              <button type="button" v-if="key != 0" v-on:click="deleteAttribute(item)" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
              <button type="button" v-if="key == (attributes.length - 1)" v-on:click="addAttribute" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></button>
            </td>
        </tr>
      </tbody>
    </table>
  </script>
  <script type="text/javascript">
    Vue.component('qt-attributes', {
      template: '#qt-attributes-template',
      data: function () {
        var attributes = null;
        @if($student->attributes)
          attributes = {!! $student->attributes !!};
        @endif
        if (attributes == null || attributes.length == 0) {
          attributes = [
            {name: '', value: ''}
          ];
        }
        return {
          attributes: attributes
        };
      },
      methods: {
        addAttribute: function () {
          this.attributes.push({name: '', value: ''});
          console.log(this.attributes);
        },
        deleteAttribute: function (item) {
          this.attributes.splice(this.attributes.indexOf(item) ,1);
        }
      }
    });
    new Vue({
      el: '#qt-app'
    });
  </script>
@endsection