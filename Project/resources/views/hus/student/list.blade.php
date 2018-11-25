@extends('master')
<link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" />
@section('content')
TQT
<table class="table table-striped">
    <thead>
    <tr>
        <th>Thuộc tính</th>
        <th>Giá trị</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><input type="text" class="form-control" placeholder="Thuộc tính"></td>
        <td><input type="text" class="form-control" placeholder="Giá trị"></td>
        <td>
            <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
            <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></button>
        </td>
    </tr>
    </tbody>
</table>
@endsection
@section('body_scripts_bottom')
<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
@endsection