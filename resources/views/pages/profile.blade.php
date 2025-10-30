@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">

                {{-- Card Profil Akun --}}
                <div class="card mb-5 shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-3 fw-semibold">Profil Akun</h4>
                        <p class="text-muted mb-4">Perbarui informasi dan foto profilmu di sini.</p>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-center gap-4 mb-4">
                                <img src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/images/user.jpg') }}"
                                    alt="Avatar" id="uploadedAvatar"
                                    style="width:100px;height:100px;object-fit:cover;border-radius:8px;">

                                <div>
                                    <label class="btn btn-warning">
                                        Unggah Foto Baru
                                        <input type="file" name="profile_photo" id="upload" hidden
                                            accept="image/png, image/jpeg">
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary" id="resetImage">Reset</button>
                                    <p class="text-muted small mt-1">Format: JPG, GIF, atau PNG (Max 2MB)</p>
                                </div>
                            </div>

                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="form-control mb-3">
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="form-control mb-3">
                            <div class="mb-4">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#ubahPasswordModal">
                                    Ubah Password
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>


                        <!-- Modal Ubah Password -->
                        <div class="modal fade" id="ubahPasswordModal" tabindex="-1"
                            aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('profile.updatePassword') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Password Lama</label>
                                                <input type="password" name="current_password" id="current_password"
                                                    class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">Password Baru</label>
                                                <input type="password" name="new_password" id="new_password"
                                                    class="form-control" required minlength="6">
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label">Konfirmasi
                                                    Password Baru</label>
                                                <input type="password" name="new_password_confirmation"
                                                    id="new_password_confirmation" class="form-control" required
                                                    minlength="6">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- Card Hapus Akun --}}
                {{-- <div class="card shadow-sm border-0 mt-5">
                    <h5 class="card-header bg-white fw-semibold">Hapus Akun</h5>
                    <div class="card-body">
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading fw-bold mb-1">Apakah Anda yakin ingin menghapus akun?</h6>
                            <p class="mb-0">Setelah akun dihapus, Anda tidak bisa memulihkannya kembali. Harap pastikan
                                keputusan Anda.</p>
                        </div>

                        <form id="formAccountDeactivation" method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <div class="form-check mb-3">
                                <input class="form-check-input ms-1" type="checkbox" id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">
                                    Saya yakin ingin menonaktifkan akun saya
                                </label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account" id="deactivateBtn" disabled>
                                Nonaktifkan Akun
                            </button>
                        </form>
                    </div>
                </div> --}} 

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const uploadInput = document.getElementById('upload');
        const preview = document.getElementById('uploadedAvatar');
        const resetBtn = document.getElementById('resetImage');
        const defaultAvatar = "{{ asset('assets/images/user.jpg') }}";

        uploadInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });

        resetBtn.addEventListener('click', () => {
            uploadInput.value = '';
            preview.src = defaultAvatar;
        });


        // hapus akun
        // const checkbox = document.getElementById('accountActivation');
        // const btn = document.getElementById('deactivateBtn');
        // checkbox.addEventListener('change', () => {
        //     btn.disabled = !checkbox.checked;
        // });
    </script>
@endpush