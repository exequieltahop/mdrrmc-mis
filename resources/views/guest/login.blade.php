@extends('app')

@section('title', 'Log In')

@section('guest')
    @vite(['resources/css/guest/login.css', 'resources/js/guest/login.js'])
    <section class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="card w-100 shadow-lg" style="max-width: 500px;">
            <div class="card-body p-4">
                <div class="d-grid" style="justify-items: center;">
                    <img src="{{ asset('assets/logos/mdrrmc-logo-removebg-preview.png') }}" alt="mdrrmc-logo" class="img-fluid" style="height: 70px; max-width: 90px;">
                    <h5 class="card-title m-0 mb-4 text-primary text-center">MDRRMC Information Management System</h5>
                </div>

                {{-- <==================== start form log in ====================> --}}
                <form id="form_login" method="POST">
                    @csrf
                    {{-- email --}}
                    <div class="form-floating mb-4">
                        <input type="email" name="email" id="email" class="form-control text-primary" placeholder="email" required style="font-size: 0.9rem;">
                        <label for="email" class="text-primary">Email</label>
                    </div>
                    {{-- password --}}
                    <div class="form-floating mb-1">
                        <input type="password" name="password" id="password" class="form-control" placeholder="password" required style="font-size: 0.9rem;">
                        <label for="password" class="text-primary">Password</label>
                    </div>
                    {{-- show password --}}
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <input type="checkbox" id="show_password" class="m-0">
                        <label for="show_password" class="m-0" style="font-size: 0.9rem;">Show Password<label>
                    </div>
                    {{-- btns --}}
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary fw-bold px-4" type="submit" id="btn_login" style="border: none;">Log In</button>
                    </div>
                </form>
                {{-- <==================== end form log in ====================> --}}
            </div>
        </div>
    </section>
@endsection
