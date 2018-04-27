@extends('templates.home')

@section('title')
    Tìm kiếm từ khóa
@endsection

@section('content')
    <div class="container">
        <h2 style="width:80% !important;float:left;">Từ khóa:</h2>

        <span>
            <input type="button" id="print" class="btn btn-success" value="Print this page" onClick="window.print()">
        </span>
        <hr>
        <form id="input" onSubmit="return formstop();">
            <div id="keyword" class="form-group">
                <input type="text" class="form-control" id="keyword" placeholder="Nhập từ khóa bạn quan tâm">
            </div>
            <button id="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <div id='list_url' style="width: 100%; max-height: 300px; overflow: auto"></div>
        <button id="chart" class="btn btn-primary" style="display: none">Next</button>
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
                    $('input#keyword').prop('disabled', true);
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

        $('#chart').click(function(){
            var keyword = $('#input').find('input').val();

            var action = $(this).attr('id');
            if(action=='chart'){
                $.ajax({
                    method: 'POST',
                    url: "chart",
                    data: {keyword:keyword},
                    success: function(result){
                        // $('#list_url').remove();
                        $('#list_url').after("<div id='date_chart' style=\"height: 300px; width: 100%;\"></div>");
                        $('#list_url').after("<div id='host_chart' style=\"height: 300px; width: 100%;\"></div>");

                        var host_chart = new CanvasJS.Chart("host_chart", {
                            title:{
                                text: "Thống kê số lượng bài báo theo các trang báo"
                            },
                            data: [
                                {
                                    type: "doughnut",
                                    dataPoints: result['host']
                                }
                            ]
                        });
                        host_chart.render();

                        var date_chart = new CanvasJS.Chart("date_chart", {
                            title:{
                                text: "Thống kê số lượng bài báo theo các thời gian"
                            },
                            data: [
                                {
                                    type: "column",
                                    dataPoints: result['date']
                                }
                            ]
                        });
                        date_chart.render();

                        $('#chart').attr('id', 'classify');
                    }
                });
            }

            if(action == "classify"){
                $.ajax({
                    method: 'POST',
                    url: "classify",
                    data: {keyword:keyword},
                    success: function(result){
                        $('#date_chart').after("<div class='classify'></div>");



                        data = "</br>" +
                            "<h2>Đánh giá chủ đề:</h2>\n" +
                            "                    <hr>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bài báo tích cực: </strong></label> <span>"+result['articles']['positive']+"</span> </div>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bài báo tiêu cực: </strong></label> <span>"+result['articles']['negative']+"</span> </div>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bài báo không liên quan: </strong></label> <span>"+result['articles']['none']+"</span> </div>\n" +
                            "                    <hr>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bình luận tích cực: </strong></label> <span>"+result['comments']['positive']+"</span> </div>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bình luận tiêu cực: </strong></label> <span>"+result['comments']['negative']+"</span> </div>\n" +
                            "                    <div class=\"form-group\"> <label><strong>Số bình luận không liên quan: </strong></label> <span>"+result['comments']['none']+"</span> </div>";

                        $('div.classify').html(data);
                        $('#classify').remove();
                    }
                });
            }

        });
    </script>
@endsection