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

                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img src="{{ asset('assets/images/faces/face6.jpg') }}" alt="user-avatar"
                                class="d-block rounded shadow-sm" style="width: 100px; height: 100px; object-fit: cover;"
                                id="uploadedAvatar" />

                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-warning me-2 mb-2" tabindex="0">
                                    <span>Unggah Foto Baru</span>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-2">
                                    Reset
                                </button>
                                <div class="text-muted small mt-1">Format: JPG, GIF, atau PNG (maks. 800KB)</div>
                            </div>
                        </div>

                        <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Tombol Ubah Password (di bawah input email) -->
                        <div class="mb-4">
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahPasswordModal">
            Ubah Password
        </button>
    </div>

                            <!-- Tombol Simpan & Batal (rata kanan) -->
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
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
                <div class="card shadow-sm border-0 mt-5">
                    <h5 class="card-header bg-white fw-semibold">Hapus Akun</h5>
                    <div class="card-body">
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading fw-bold mb-1">Apakah Anda yakin ingin menghapus akun?</h6>
                            <p class="mb-0">Setelah akun dihapus, Anda tidak bisa memulihkannya kembali. Harap pastikan
                                keputusan Anda.</p>
                        </div>

                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-3">
                                <input class="form-check-input ms-1" type="checkbox" name="accountActivation"
                                    id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">
                                    Saya yakin ingin menonaktifkan akun saya
                                </label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account" id="deactivateBtn" disabled>
                                Nonaktifkan Akun
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('accountActivation');
            const button = document.getElementById('deactivateBtn');

            checkbox.addEventListener('change', function () {
                button.disabled = !checkbox.checked;
            });
        });
    </script>
@endpush