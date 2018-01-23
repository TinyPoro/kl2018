@extends('templates.home')

@section('title')
    Tìm kiếm từ khóa
@endsection

@section('content')
    <div class="container">
        <h2>Nhập từ khóa vào ô tìm kiếm:</h2>
        <hr>
        <form>
            <div id="keyword" class="form-group">
                <label for="keyword">Từ khóa:</label>
                <input type="text" class="form-control" id="keyword" placeholder="Nhập từ khóa bạn quan tâm">
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
    <style>

    </style>
@endsection

@section('after-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('button').click(function(){
            var keyword = $(this).siblings('#keyword').find('input').val();


            $.ajax({
                method: 'POST',
                url: "findkeyword",
                data: '{keyword:' + keyword + '}',
                success: function(result){
                    alert(result);
                    // $('tr#'+result).remove();
                }
            });
        });
    </script>
@endsection