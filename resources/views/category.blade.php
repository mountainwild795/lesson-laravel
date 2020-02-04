@extends('master')

@section('title', 'category')
    
@section('content')
<div class="weui_cells_title">Please Select Book Category</div>
<div class="weui_cells weui_cells_split">
  <div class="weui_cells weui_cell_select">
    <div class="weui_cell_bd weui_cell_primary">
      <select name="category" class="weui_select">
        @foreach ($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<div class="weui_cells weui_cells_access">
  {{-- <a href="javascript:;" class="weui_cell">
      <div class="weui_cell_bd weui_cell_primary">
          <p>cell standard</p>
      </div>
      <div class="weui_cell_ft">说明文字</div>
  </a> --}}
</div>
    
@endsection

@section('my-js')
    <script>
       _getCategory();
      $('.weui_select').change(function(event){
        _getCategory();
      });
     
      function _getCategory() {
          var parent_id = $('.weui_select option:selected').val();
          // alert(parent_id);
          $.ajax({
          type: "GET",
          url: 'http://localhost/book/public/service/category/parent_id/' + parent_id,
          dataType: 'json',
          cache: false,
          // data: {username:username, password: password, validate_code: validate_code, _token: "{{csrf_token()}}"},
          success: function(data) {
            console.log('获取类别数据：');
            console.log(data);
            if(data == null) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html('服务端错误');
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return;
            }
            if(data.status != 0) {
              $('.bk_toptips').show();
              $('.bk_toptips span').html(data.message);
              setTimeout(function() {$('.bk_toptips').hide();}, 2000);
              return;
            }

            // console.log(data);
            $('.weui_cells_access').html('');
            for(var i=0; i<data.categories.length; i++){
              var next = 'http://localhost/book/public/product/category_id/' + data.categories[i].category_no;
              console.log(next);
              var node = ' <a href="' + next + '" class="weui_cell">' +
                          ' <div class="weui_cell_bd weui_cell_primary">' +
                            '<p>'+ data.categories[i].name +'</p>' +
                          '  </div>' +
                          '  <div class="weui_cell_ft">说明文字</div>' +
                        ' </a>';
                
                $('.weui_cells_access').append(node);
              // console.log(data.categories[i].name);
            }
          },
          error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
          }
        });

        }
    </script>
@endsection