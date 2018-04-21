@extends('templates.home')

@section('title')
    Tìm kiếm từ khóa
@endsection

@section('content')
    <div class="container">
        <h2>Tóm tắt:</h2>
        <hr>

        <div class="row">
            <div class="col-md-5">
                <textarea id="content">

                </textarea>
            </div>
            <div class="col-md-2" style="text-align:center;">
                <button class="btn btn-success" id="summary">Tóm tắt</button>
            </div>
            <div class="col-md-5">
                <textarea id="result">

                </textarea>
            </div>
        </div>
    </div>
    <style>
        textarea{
            width: 400px;
            height: 500px;
            overflow: auto;
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

        $('#summary').click(function(){
            var content = $('#content').val();
            console.log(content);
            $.ajax({
                method: 'POST',
                url: "summary",
                data: {content:content},
                success: function(result){
                    console.log(result);
                    $('#result').val(result);
                }
            });
        });
    </script>
@endsection