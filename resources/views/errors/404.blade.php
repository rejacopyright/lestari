@extends('layouts.user')
@section('css')
@endsection
@section('content')
<div class="container">
  <!-- WHATSAPP -->
  <div class="position-fixed r-1 b-1 pointer z-999">
    <a href="https://api.whatsapp.com/send?phone=62{{ltrim(App\setting::first()->whatsapp, '0')}}" target="_blank" class="btn square-50 radius-50" bg="#4bc25a" data-tippy-placement="left" title="Ask Something"><i class="icon-brand-whatsapp text-white font-24 lh-13"></i></a>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <section id="not-found" class="center py-4 m-0">
        <h2>404 <i class="icon-line-awesome-question-circle"></i></h2>
        <p>We're sorry, but the page you were looking for doesn't exist</p>
      </section>
    </div>
  </div>
</div>
@endsection
@section('js')
@endsection
