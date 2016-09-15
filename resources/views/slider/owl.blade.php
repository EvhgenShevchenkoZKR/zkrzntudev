@extends('app')


@section('headerstyles')

@endsection



@section('content')
    <a href="#" id="try" data-link="{{ url('/quest') }}" data-token="{{ csrf_token() }}">Try</a>

@endsection



@section('footerscripts')
    <script>
        $("#try").click(function(e){
            e.preventDefault();
            //add it to your data
            var data = {
                _token:$(this).data('token'),
                testdata: 'I am the greatest one'
            };


            $.ajax({
                url: "ajax-menus-reorder",
                type:"POST",
                data: data,
                success:function(data){
                    console.log(data.data);
                },
                error:function(){
                    alert("error!!!!");
                }
            }); //end of ajax
        });

//
//        $.get('/menus-reorder-ajax', function(){
//            console.log('response');
//        });
    </script>
@endsection