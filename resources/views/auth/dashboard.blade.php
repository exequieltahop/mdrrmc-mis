@extends('app')

@section('title', 'Dashboard - MIMS')

@vite(['resources/css/auth/dashboard.js', 'resources/css/auth/dashboard.css'])

@section('auth')
    <section class="container-fluid p-0 m-0">
        <div class="row">

            {{-- ##################################### IF ADMIN ################################# --}}
            @if (Auth::user()->role == 'admin')
                <div class="col-sm-3 p-3">
                    <div class="bg-white rounded h-100 shadow-lg p-3 d-flex align-items-center justify-content-center gap-3 w-100">
                        <div class="d-grid text-center justify-content-start">
                            <span class="text-primary">Total Users</span>
                            <h5 class="text-primary fw-bold">
                                {{ $total_user }}
                            </h5>
                        </div>
                        <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            @endif

            <div class="col-sm-3 p-3">
                <div class="bg-white rounded h-100 shadow-lg p-3 d-flex align-items-center justify-content-center gap-3 w-100">
                    <div class="d-grid text-center justify-content-start">
                        <span class="text-primary">Total Respondents</span>
                        <h5 class="text-primary fw-bold">
                            {{ $total_respondent }}
                        </h5>
                    </div>
                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 p-3">
                <div class="bg-white rounded h-100 shadow-lg p-3 d-flex align-items-center justify-content-center gap-3 w-100">
                    <div class="d-grid text-center justify-content-start">
                        <span class="text-primary">Total Responses</span>
                        <h5 class="text-primary fw-bold">
                            {{ $total_response }}
                        </h5>
                    </div>
                    <i class="bi bi-check-square-fill text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </section>
@endsection
