@extends('layouts.admin')
@section('content')
<div class="glass-panel p-5">
    <h3 class="fw-bold text-slate-800 mb-4">Kelola Semua Formulir</h3>
    <table class="table table-hover">
        <thead><tr><th>No</th><th>Judul</th><th>Buku</th><th>Tipe</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($forms as $i => $form)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $form->title }}</td>
                <td>{{ $form->book->title ?? 'Umum' }}</td>
                <td><span class="badge {{ $form->file_type == 'pdf' ? 'bg-danger' : 'bg-primary' }}">{{ strtoupper($form->file_type) }}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" onclick="editForm({{ $form->id }}, '{{ $form->title }}', {{ $form->book_id }})">Edit</button>
                    <form action="/admin/forms/{{ $form->id }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
