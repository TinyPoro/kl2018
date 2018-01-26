@extends('templates.home')

@section('title')
    Quán lý nhân sự
@endsection

@section('content')
    <div class="container">
        <form class="form-inline" id="manage" method="get" action="{{route('diary')}}">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group row">
                    <label for="id" class="col-sm-5 col-form-label"><strong>Id người dùng:</strong></label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="id" id="id" placeholder="Id của bạn">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-5 col-form-label"><strong>Tên người dùng:</strong></label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Tên của bạn">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="date" class="col-sm-5 col-form-label"><strong>Ngày tháng:</strong></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="date" id="date">
                    </div>
                </div>

                <div class="form-group row col-6">
                    <label for="activity" class="col-sm-4 col-form-label"><strong>Hoạt động:</strong></label>
                    <select name="activity" class="form-control" id="activity">
                        <option selected></option>
                        <option>Đăng nhập</option>
                        <option>Tóm tắt đơn văn bản</option>
                        <option>Tóm tắt đa văn bản</option>
                        <option>Cập nhật thông tin người dùng</option>
                        <option>Cập nhật loại tài khoản</option>
                        <option>Xóa tài khoản</option>
                        <option>Xác thực tài khoản</option>
                        <option>Tìm kiếm từ khóa</option>
                        <option>Thay đổi url crawl</option>
                        <option>Thay đổi cài đặt chu kỳ</option>
                    </select>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </div>
        </form>

        <h2>Danh sách hoạt động:</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Hoạt động</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Ảnh hưởng</th>
            </tr>
            </thead>
            <tbody id="list_user">

            @foreach($activities as $activity)
                <tr id="{{$activity->id}}">
                    <th scope="row">{{$activity->user_id}}</th>
                    <td>{{$activity->user->email}}</td>
                    <td>{{$activity->user->name}}</td>
                    <td>{{$activity->getActivityTextAttribute()}}</td>
                    <td>{{$activity->datetime}}</td>
                    <td>{{$activity->content}}</td>
                    <td>{{$activity->database_impact}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('after-script')
    <script>
        $('input[name="date"]').daterangepicker();
    </script>


@endsection