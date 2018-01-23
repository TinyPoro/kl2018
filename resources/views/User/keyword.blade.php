@extends('templates.home')

@section('title')
    Tìm kiếm từ khóa
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
            <button id="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <div id='list_url' style="width: 500px; max-height: 300px; overflow: auto"></div>
        <div id='chart'></div>
        <button id="next" class="btn btn-primary" style="display: none">Next</button>
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

        $('button').click(function(){
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


                    $('#next').show();

                    // $('form').after("<div id='chart'></div>");
                }
            });
        });

        $('#next').click(function(){
            var chart = new CanvasJS.Chart("chart", {
                title:{
                    text: "My First Chart in CanvasJS"
                },
                data: [
                    {
                        // Change type to "doughnut", "line", "splineArea", etc.
                        type: "doughnut",
                        dataPoints: [
                            { label: "apple",  y: 10  },
                            { label: "orange", y: 15  },
                            { label: "banana", y: 25  },
                            { label: "mango",  y: 30  },
                            { label: "grape",  y: 28  }
                        ]
                    }
                ]
            });
            chart.render();
        });
    </script>
@endsection