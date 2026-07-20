@extends('layouts.admin')

@section('content')
<!-- Masukkan CSS & JS Cropper.js via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<div class="container-fluid py-4 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="glass-panel p-4 mb-5 rounded-4 shadow-sm border border-white/50 d-flex align-items-center gap-4">
        <div class="w-14 h-14 rounded-[1rem] bg-gradient-to-br from-blue-100 to-cyan-50 text-blue-600 d-flex align-items-center justify-content-center shadow-inner border border-white">
            <i class="fa-solid fa-user-pen text-2xl"></i>
        </div>
        <div>
            <h3 class="fw-black text-slate-800 mb-1 tracking-tight">Pengaturan Profil & Atur Foto</h3>
            <p class="text-slate-500 mb-0 text-sm font-medium">Unggah foto baru, lalu sesuaikan posisi dan ukurannya secara interaktif.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border border-green-200/50 text-green-700 fw-bold rounded-4 shadow-sm mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check text-xl me-3"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger glass-panel border border-red-200/50 text-red-600 fw-bold rounded-4 shadow-sm mb-4">
            <div class="d-flex align-items-center mb-2"><i class="fa-solid fa-triangle-exclamation text-xl me-2"></i> Terdapat Kesalahan:</div>
            <ul class="mb-0 ps-4 text-sm">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="glass-panel rounded-[2rem] border border-white/60 shadow-sm bg-white/40 overflow-hidden">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-4 p-md-5" id="profileForm">
            @csrf @method('PUT')

            <!-- Input tersembunyi untuk menampung data gambar hasil crop (Base64) -->
            <input type="hidden" name="cropped_image" id="cropped_image">

            <div class="row g-5">
                <!-- Kolom Kiri: Foto & Basic Info -->
                <div class="col-lg-5 border-end-lg border-slate-200/60 pe-lg-5">
                    <div class="text-center mb-4">
                        <!-- Lingkaran Pratinjau Saat Ini -->
                        <div class="position-relative d-inline-block group mb-3">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('uploads/profiles/' . Auth::user()->profile_photo) }}" class="rounded-circle shadow-md object-fit-cover border-4 border-white" style="width: 140px; height: 140px;" id="currentProfileImg">
                            @else
                                <div class="rounded-circle shadow-md bg-gradient-to-tr from-cyan-400 to-blue-600 d-flex align-items-center justify-content-center border-4 border-white text-white fw-black fs-1 mx-auto" style="width: 140px; height: 140px;" id="currentInitial">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Input File -->
                        <div class="mt-2">
                            <input type="file" id="imageInput" class="form-control form-control-sm bg-white/80 border-slate-300 mx-auto" accept="image/*" style="max-width: 250px;">
                            <small class="text-muted text-[10px] mt-1 d-block">Pilih foto untuk digeser & di-zoom</small>
                        </div>
                    </div>

                    <!-- Modal / Area Crop Interaktif (Muncul otomatis saat foto dipilih) -->
                    <div id="cropContainer" class="mb-4 d-none p-3 bg-white rounded-2xl border border-slate-200 shadow-sm text-center">
                        <p class="text-xs fw-bold text-slate-600 mb-2"><i class="fa-solid fa-crop text-amarin me-1"></i> Sesuaikan Posisi Foto Anda</p>
                        <div style="max-height: 250px; overflow: hidden;" class="mb-3">
                            <img id="imageToCrop" src="" style="max-width: 100%;">
                        </div>
                        <button type="button" id="cropBtn" class="btn btn-sm btn-amarin w-100 fw-bold rounded-pill shadow-sm">
                            <i class="fa-solid fa-check me-1"></i> Terapkan Potongan Foto
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="fw-extrabold text-slate-700 mb-2 text-sm uppercase tracking-wider text-[11px]"><i class="fa-regular fa-id-badge me-1"></i> Nama Lengkap</label>
                        <input type="text" class="form-control bg-white/70 border-slate-200 py-2.5 rounded-xl shadow-inner" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="fw-extrabold text-slate-700 mb-2 text-sm uppercase tracking-wider text-[11px]"><i class="fa-regular fa-envelope me-1"></i> Alamat Email (Username)</label>
                        <input type="email" class="form-control bg-white/70 border-slate-200 py-2.5 rounded-xl shadow-inner" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                </div>

                <!-- Kolom Kanan: Ganti Password -->
                <div class="col-lg-7 ps-lg-5 d-flex flex-column">
                    <div class="bg-slate-50/50 rounded-2xl p-4 border border-slate-100 shadow-inner flex-grow-1">
                        <h6 class="text-xs fw-black text-slate-500 text-uppercase tracking-widest mb-4 border-bottom border-slate-200 pb-3"><i class="fa-solid fa-shield-halved me-2 text-amarin"></i> Keamanan & Kata Sandi</h6>

                        <div class="mb-4">
                            <label class="fw-bold text-slate-700 mb-2 text-sm">Password Lama</label>
                            <input type="password" class="form-control bg-white py-2.5 rounded-xl" name="current_password" placeholder="Masukkan password saat ini untuk validasi">
                            <small class="text-muted text-[10px] mt-1 ms-1">*Wajib diisi jika Anda ingin mengubah password.</small>
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-slate-700 mb-2 text-sm">Password Baru</label>
                            <input type="password" class="form-control bg-white py-2.5 rounded-xl" name="password" minlength="8" placeholder="Minimal 8 karakter">
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold text-slate-700 mb-2 text-sm">Ulangi Password Baru</label>
                            <input type="password" class="form-control bg-white py-2.5 rounded-xl" name="password_confirmation" placeholder="Ketik ulang password baru Anda">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3">
                        <button type="submit" class="btn bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-5 py-3 fw-bold shadow-md rounded-xl hover:-translate-y-1 transition-all">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Skrip JavaScript untuk Mengaktifkan Cropper.js -->
<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const cropContainer = document.getElementById('cropContainer');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropBtn = document.getElementById('cropBtn');
    const croppedImageInput = document.getElementById('cropped_image');
    const currentProfileImg = document.getElementById('currentProfileImg');
    const currentInitial = document.getElementById('currentInitial');

    imageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                imageToCrop.src = e.target.result;
                cropContainer.classList.remove('d-none');

                if (cropper) {
                    cropper.destroy();
                }

                // Inisialisasi Cropper.js dengan aspek rasio 1:1 (Kotak lingkaran)
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    cropBtn.addEventListener('click', function () {
        if (cropper) {
            // Ambil hasil crop dalam bentuk Base64
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });

            const base64Image = canvas.toDataURL('image/jpeg');
            croppedImageInput.value = base64Image; // Masukkan ke input tersembunyi

            // Tampilkan pratinjau instan di halaman
            if (currentProfileImg) {
                currentProfileImg.src = base64Image;
            } else if (currentInitial) {
                currentInitial.outerHTML = `<img src="${base64Image}" class="rounded-circle shadow-md object-fit-cover border-4 border-white" style="width: 140px; height: 140px;" id="currentProfileImg">`;
            }

            // Sembunyikan kotak crop setelah diterapkan
            cropContainer.classList.add('d-none');
            alert('Foto berhasil disesuaikan! Klik tombol "Simpan Perubahan Profil" di bawah untuk menyimpan permanen.');
        }
    });
</script>
@endsection
