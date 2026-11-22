@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1 class="mb-0"><i class="bi bi-basket3-fill"></i> <b>SBK</b>MART</h1>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan masuk untuk memulai</p>

      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        <div class="mb-3">
          <input type="text" name="username" value="{{ old('username') }}"
                 class="form-control @error('username') is-invalid @enderror" placeholder="Username" autofocus>
          @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <input type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror" placeholder="Password">
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
      </form>
    </div>
  </div>
</div>
@endsection
