@extends('layouts.app')

@section('title', 'Dashboard Security')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h1 class="h2"><i class="mdi mdi-view-dashboard me-2"></i>Dashboard Security</h1>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
                        </button>
                    </div>
                </div>
            </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
            <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="text-primary">{{ $stats['total'] }}</h3>
                            <p class="text-muted mb-0">Total Tamu</p>
                        </div>
                        <div class="icon-large text-primary">
                            <i class="mdi mdi-account-multiple"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
            <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="text-warning">{{ $stats['belum_checkin'] }}</h3>
                            <p class="text-muted mb-0">Belum Check In</p>
                        </div>
                        <div class="icon-large text-warning">
                            <i class="mdi mdi-clock-outline"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
            <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="text-info">{{ $stats['checkin'] }}</h3>
                            <p class="text-muted mb-0">Sudah Check In</p>
                        </div>
                        <div class="icon-large text-info">
                            <i class="mdi mdi-check-all"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
            <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="text-success">{{ $stats['approved'] }}</h3>
                            <p class="text-muted mb-0">Disetujui</p>
                        </div>
                        <div class="icon-large text-success">
                            <i class="mdi mdi-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .icon-large {
        font-size: 2.5rem;
        opacity: 0.8;
    }
</style>
@endpush