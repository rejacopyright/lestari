@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container pt-3" id="banner-list">
  <div class="row el-element-overlay">
    <?php foreach ($banner as $bn): ?>
      <div class="col-lg-4 col-6 item mb-3">
        <div class="card radius-5 shadow-xs border border-2 border-secondary dash p-1" onclick="banner({{$bn->banner_id}})">
          <div class="d-flex align-items-center oh pointer">
            <img class="w-100" src="{{url('public')}}/images/banner/{{$bn->image}}?{{time()}}">
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="row mt-1">
    <div class="col-12 text-right">{{$banner->links()}}</div>
  </div>
</div>
@endsection
@section('js')
<!-- PAGINATION -->
<script type="text/javascript">
  $(document).on('click', '#banner-list li.page-item:not(".disabled")', function(e) {
    e.preventDefault();
    var url = $(this).find("a:first").attr("href");
    window.history.replaceState({},"",url);
    $.get(url, function(data){
      var html = $($.parseHTML(data));
      var item = html.find("#banner-list").html();
      $("#banner-list").html(item);
    });
  });
</script>
@endsection
