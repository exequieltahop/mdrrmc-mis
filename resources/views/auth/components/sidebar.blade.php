<aside class="offcanvas-lg offcanvas-start w-100 p-3 w-100" id="side-bar" data-bs-scroll="true" tabindex="-1" aria-labelledby="sidebar-title" style="min-width: 230px; max-width: 230px;">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center gap-0 px-2">
            {{-- LOGO --}}
            <img src="{{ asset('assets/logos/mdrrmc-logo-removebg-preview.png') }}" alt="mdrrmc-logo" style="max-width: 70px; width: 100%;" class="m-0">

            {{-- HEADER --}}
            <h5 class="m-0 nav-link text-primary fs-5">MDRRMC</h5>
        </div>
        <button class="btn-close m-0" data-bs-dismiss="offcanvas" data-bs-target="#side-bar"></button>
    </div>
    <hr class="m-0">
    <div class="offcanvas-body">
        <ul class="nav flex-column">

            <div class="w-100 p-0 m-0 d-lg-block d-none">
                <div class="d-flex align-items-center gap-1 px-2">
                    {{-- LOGO --}}
                    <img src="{{ asset('assets/logos/mdrrmc-logo-removebg-preview.png') }}" alt="mdrrmc-logo" style="max-width: 70px; width: 100%;" class="m-0">

                    {{-- HEADER --}}
                    <h5 class="m-0 text-primary fs-5">MDRRMC</h5>
                </div>
                <hr>
            </div>

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'dashboard' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('data-entry') }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'data-entry' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                    <i class="bi bi-database-fill-add"></i>
                    Data Entry
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('records') }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'records' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                    <i class="bi bi-clipboard-data"></i>
                    Records
                </a>
            </li>

            {{-- generate report --}}
            <li class="nav-item">
                <a href="{{ route('generate-report', ['year' => Carbon\Carbon::now()->year]) }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'generate-report' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                    <i class="bi bi-clipboard-data"></i>
                    Generate Report
                </a>
            </li>

            {{-- ################################## IF ADMIN ################################# --}}
            @if (Auth::user()->role == 'admin')
                {{-- RESPONDERS --}}
                <li class="nav-item">
                    <a href="{{ route('respondents') }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'respondents' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                        <i class="bi bi-people"></i>
                        Respondents
                    </a>
                </li>

                {{-- USERS LIST --}}
                <li class="nav-item">
                    <a href="{{ route('users.list') }}" class="nav-link text-primary {{ Route::currentRouteName()  == 'users.list' ? 'nav-link-active' : '' }}" style="font-weight: 600;">
                        <i class="bi bi-people"></i>
                        Users
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-primary" style="font-weight: 600;">
                    <i class="bi bi-box-arrow-left"></i>
                    Log Out
                </a>
            </li>
        </ul>
    </div>
</aside>

