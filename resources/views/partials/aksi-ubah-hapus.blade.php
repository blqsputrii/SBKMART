<a href="{{ route($rute . '.edit', $id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Ubah</a>
<form action="{{ route($rute . '.destroy', $id) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Hapus {{ $nama }}?')">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
</form>
