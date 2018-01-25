@extends('templates.home')

@section('title')
    Thông tin cá nhân
@endsection

@section('content')
    <div class="container">
        <h2>{{$user->name}}</h2>
        <hr>
        <form id="info" method="post" action="{{route('update_info')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email" class="col-sm-2 col-form-label"><strong>Email:</strong></label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email của bạn" value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 col-form-label"><strong>Password:</strong></label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu của bạn" value="{{$user->password}}">
                </div>
            </div>

            <div class="form-row">
                <div style="width: 0.8rem;"></div>
                <div class="col-md-4 mb-3">
                    <label for="department"><strong>Phòng ban:</strong></label>
                    <select name="department" class="form-control" id="department">
                        <option selected>{{$user->department}}</option>
                        <option>Kỹ thuật</option>
                        <option>Kinh doanh</option>
                        <option>Nhân sự</option>
                        <option>Hành chính</option>
                        <option>Kế toán</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="position"><strong>Vị trí:</strong></label>
                    <select name="position" class="form-control" id="position">
                        <option selected>{{$user->position}}</option>
                        <option>Trưởng phòng</option>
                        <option>Phó phòng</option>
                        <option>Nhân viên</option>
                        <option>Thực tập</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="col-sm-2 col-form-label"><strong>Địa chỉ:</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" value="{{$user->address}}" placeholder="Địa chỉ của bạn">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-form-label"><strong>Loại tài khoản: </strong></label>
                <span class="col-sm-7"> <input type="text" readonly class="form-control-plaintext" id="address" value="{{$user->getTypeTextAttribute()}}"></span>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-form-label"><strong>Ngày dừng hoạt động: </strong></label>
                @if($user->deleted_at)
                    <span class="col-sm-7"><input type="text" readonly class="form-control-plaintext" id="address" value="{{$user->deleted_at}}"></span>
                    @else <span class="col-sm-7"><input type="text" readonly class="form-control-plaintext" id="address" value="Vẫn hoạt động"></span>
                @endif
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    <style>

    </style>
@endsection

@section('after-script')
    <script>


    </script>
@endsection