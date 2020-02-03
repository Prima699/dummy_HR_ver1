@extends('layouts.app', [
    'namePage' => Breadcrumbs::render('dashboard'),
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'dashboard', 
    'backgroundImage' => asset('public/'.'now') . "/img/bg14.jpg",
])

@section('content')
  <section id="banner" data-video="images/banner">
          <div class="inner">
            <header>
              <h1>This is DIGITAS</h1>
              <p>Aplikasi Kepegawaian</p>
            </header>
            <a href="#main" class="button big alt scrolly">Login</a>
          </div>

  </section>
@endsection

@push('js')
  
@endpush