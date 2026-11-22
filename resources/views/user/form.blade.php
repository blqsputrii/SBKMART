@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Pengguna')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('user.update', $data->id) : route('user.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username', $data->username ?? '') }}" class="form-control @error('username') is-invalid @enderror">
        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Password {{ $data ? '(kosongkan jika tidak diganti)' : '' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="idrole" class="form-select @error('idrole') is-invalid @enderror">
          <option value="">-- pilih role --</option>
          @foreach ($roles as $r)
            <option value="{{ $r->{'Kode Role'} }}" @selected(old('idrole', $data->idrole ?? '') == $r->{'Kode Role'})>{{ $r->{'Nama Role'} }}</option>
          @endforeach
        </select>
        @error('idrole') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
