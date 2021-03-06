@extends('templates.home')

@section('title')
    Xác thực người dùng mới
@endsection

@section('content')
    <div class="container">
        <h2>Danh sách người dùng chờ xác nhận:</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col" ></th>
            </tr>
            </thead>
            <tbody id="list_user">

            @foreach($users as $user)
                <tr id="{{$user->id}}">
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td id="{{$user->id}}">
                        <a href="#" id="accept"><i class="fa fa-check"></i></a>
                        <a href="#" id="deny"><i class="fa fa-close"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <style>
        #accept{
            color: tomato;
        }
        #accept:hover{
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

            $.ajax({
                method: 'POST',
                url: type+"/"+id,
                data: [],
                success: function(result){
                    $('tr#'+result).remove();
                }
            });
        });
    </script>
@endsection