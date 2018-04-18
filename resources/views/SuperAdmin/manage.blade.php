@extends('templates.home')

@section('title')
    Quán lý nhân sự
@endsection

@section('content')
    <div class="container">
        <form class="form-inline" id="manage" method="get" action="{{route('manage')}}">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group row">
                    <label for="name" class="col-sm-1 col-form-label"><strong>Tên:</strong></label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Tên của bạn"">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="department"><strong>Phòng ban:</strong></label>
                    <select name="department" class="form-control" id="department">
                        <option selected></option>
                        <option>Kỹ thuật</option>
                        <option>Kinh doanh</option>
                        <option>Nhân sự</option>
                        <option>Hành chính</option>
                        <option>Kế toán</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="position"><strong>Vị trí:</strong></label>
                    <select name="position" class="form-control" id="position">
                        <option selected></option>
                        <option>Trưởng phòng</option>
                        <option>Phó phòng</option>
                        <option>Nhân viên</option>
                        <option>Thực tập</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label for="address"><strong>Địa chỉ:</strong></label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="address" id="address"  placeholder="Địa chỉ của bạn">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="type"><strong>Loại tài khoản: </strong></label>
                    <select name="type" class="form-control" id="type">
                        <option selected></option>
                        <option>Người dùng thường</option>
                        <option>Admin</option>
                        <option>Super Admin</option>
                    </select>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </div>
        </form>

        <h2>Danh sách nhân viên:</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Phòng ban</th>
                <th scope="col">Vị trí</th>
                <th scope="col">Địa chí</th>
                <th scope="col">Loại tài khoản</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="list_user">

            @foreach($users as $user)
                <tr id="{{$user->id}}">
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->department}}</td>
                    <td>{{$user->position}}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        <select class="form-control" id="type_update">
                            <option selected>{{$user->getTypeTextAttribute()}}</option>
                            <option>Người dùng thường</option>
                            <option>Admin</option>
                            <option>Super Admin</option>
                        </select>
                    </td>
                    <td id="{{$user->id}}">
                        <a href="#" id="update"><i class="fa fa-check"></i></a>
                        <a href="#" id="delete"><i class="fa fa-close"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <style>
        #update{
            color: tomato;
        }
        #update:hover{
            color: red;
        }
    </style>
@endsection

@section('after-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#list_user a').click(function(){
            var type = $(this).attr('id');
            var id = $(this).parent().attr('id');
            var data = $('#type_update').val();

            $.ajax({
                method: 'POST',
                url: type+"/"+id,
                data: {type:data},
                success: function(result){
                    $('tr#'+result).remove();
                }
            });
        });
    </script>
@endsection