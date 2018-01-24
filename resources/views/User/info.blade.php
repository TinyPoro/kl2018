@extends('templates.home')

@section('title')
    Tìm kiếm từ khóa
@endsection

@section('content')
    <div class="container">
        <h2>Nhập từ khóa vào ô tìm kiếm:</h2>
        <hr>
        <form>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">City</label>
                    <input type="text" class="form-control" id="validationDefault03" placeholder="City" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">State</label>
                    <input type="text" class="form-control" id="validationDefault04" placeholder="State" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Zip</label>
                    <input type="text" class="form-control" id="validationDefault05" placeholder="Zip" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
        </form>
    </div>
    <style>

    </style>
@endsection

@section('after-script')
    <script>
        function formstop() {
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            var keyword = $(this).siblings('#keyword').find('input').val();

            $.ajax({
                method: 'POST',
                url: "find_keyword",
                data: {keyword:keyword},
                success: function(result){
                    // $('form').after("<div id='list_url'></div>");
                    $('input').prop('disabled', true);
                    $('#submit').remove();

                    data = "<ul class=\"list-group\">";

                    result.forEach(function(article){
                        data += "<li class=\"list-group-item\"><a href=\"{{route('articles_info')}}/" + article['id'] + "\">" + article['url'] + "</a></li>";
                    });

                    data += "</ul>";

                    $('#list_url').html(data);

                    $('#chart').show();
                }
            });
        });


    </script>
@endsection