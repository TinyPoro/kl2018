@extends('templates.home')

@section('title')
    Thông tin bài báo
@endsection

@section('content')
    <div class="container">
        <h2>Thông tin chi tiết:</h2>
        <hr>
        <div class="form-group">
            <label><strong>Trang báo: </strong></label>
            <span>{{$article->host}}</span>
        </div>
        <div class="form-group">
            <label><strong>Đường dẫn: </strong></label>
            <span>{{$article->url}}</span>
        </div>
        <div class="form-group">
            <label><strong>Tiêu đề: </strong></label>
            <span>{{$article->title}}</span>
        </div>
        <div class="form-group">
            <label><strong>Nội dung: </strong></label>
            <span>{{$article->content}}</span>
        </div>
        <div class="form-group">
            <label><strong>Tóm tắt: </strong></label>
            <span>{{$article->summary}}</span>
        </div>
        <div class="form-group">
            <label><strong>Ngày đăng:  </strong></label>
            <div>{{$article->date}}</div>
        </div>
        <div class="form-group">
            <label><strong>Phân loại: </strong></label>
            <span>{{$article->getTypeTextAttribute()}}</span>
        </div>

        <br/>
        <br/>

        <h2>Các bình luận:</h2>
        <hr>
        @foreach($comments as $comment)
            <div class="form-group">
                <label><strong>{{$comment->user_name}}:  </strong></label>
                <div>{{$comment->content}}</div>
            </div>
        @endforeach
    </div>
    <style>

    </style>
@endsection

@section('after-script')

@endsection