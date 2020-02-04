@extends('master')

{{-- @section('title', $product->name) --}}
    
@section('title')
    {{$product->name}}
@endsection

@section('content')
<div class="page">


  <div class="weui_cells_title">
    <span class="bk_title">{{$product->name}}</span>
    <span class="bk_price" style="float:right">${{$product->price}}</span>
  </div>
  <div class="weui_cells">
    <div class="weui_cell">
      <p class="bk_summary">{{$product->summary}}</p>
    </div>
  </div>

  <div class="weui_cells_title">detail introduction</div>
  <div class="weui_cells">
    <div class="weui_cell">
      <p>
        {!! $pdt_content->content !!}
      </p>
    </div>
  </div>
  <div class="bk_fix_bottom">
      <div class="bk_half_area">
        <button class="weui_btn weui_btn_primary" onclick="_addCart()">Add To Cart </button>
      </div>
      <div class="bk_half_area">
      <button class="weui_btn weui_btn_default">Checkout(<span id="cart_num" class="m3_price"></span>)</button>
      </div>
  </div>
</div>


  {{-- <div class="weui_cells weui_cells_access">
     @foreach ($products as $product)
         <a class="weui_cell" href="javascript:;" >
            <div class="weui_cell_hd"><img class="bk_preview" src="{{asset($product->preview)}}" alt="book"></div>
            <div style="margin-left:20px" class="weui_cell_bd weui_cell_primary">
              <div style="margin-bottom: 10px">
                  <span class="bk_title">{{$product->name}}</span>
                  <span class="bk_price" style="float:right">${{$product->price}}</span>
              </div>
              <p class="bk_summary">{{$product->summary}}</p>
           </div>
         </a>
     @endforeach
  </div> --}}
@endsection

@section('my-js')
    
@endsection
