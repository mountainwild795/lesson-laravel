@extends('master')

@section('title', 'product')
    
@section('content')
  {{-- <div class="weui_cells_title">图标，说明，跳转的列表项</div> --}}
  <div class="weui_cells weui_cells_access">
     @foreach ($products as $product)
      <a class="weui_cell" href="http://localhost/book/public/product/{{$product->id}}">
         {{-- <a class="weui_cell" href="http://localhost/book/public/product/{{$product->id}}"> --}}
            <div class="weui_cell_hd"><img class="bk_preview" src="{{asset($product->preview)}}" alt="book"></div>
            <div style="margin-left:20px" class="weui_cell_bd weui_cell_primary">
              <div style="margin-bottom: 10px">
                  <span class="bk_title">{{$product->name}}</span>
                  <span class="bk_price" style="float:right">${{$product->price}}</span>
              </div>
              <p class="bk_summary">{{$product->summary}}</p>
           </div>

          {{-- <div class="weui_cell_ft">说明文字</div> --}}
         </a>
     @endforeach
  </div>
@endsection

@section('my-js')
    
@endsection
