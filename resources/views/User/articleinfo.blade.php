@extends('templates.home')

@section('title')
    Thông tin bài báo
@endsection

@section('content')
    <div class="container">
        <h2>Nhập từ khóa vào ô tìm kiếm:</h2>
        <hr>
        <form onSubmit="return formstop();">
            <div id="keyword" class="form-group">
                <label for="keyword">Từ khóa:</label>
                <input type="text" class="form-control" id="keyword" placeholder="Nhập từ khóa bạn quan tâm">
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>

        <div id='list_url' style="width: 500px; max-height: 300px; overflow: auto"></div>
    </div>
    <style>

    </style>
@endsection

@section('after-script')

@endsection