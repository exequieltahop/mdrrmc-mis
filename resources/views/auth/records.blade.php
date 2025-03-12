{{-- EXTENDS TO app.blade.php --}}
@extends('app')

{{-- TITLE --}}
@section('title', 'Records')

{{-- SECTION --}}
@section('auth')

    {{-- VITE STYLE AND SCRIPT --}}
    @vite(['resources/css/auth/records.css', 'resources/js/auth/records.js'])

    {{-- CONTENT --}}
    <section class="container-fluid p-0 m-0 w-100 overflow-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Records Of Incidents</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered border-dark" id="records-list">
                        <thead class="align-top">
                            <tr class="">
                                <th rowspan="3" class="text-center">No.</th>
                                <th rowspan="3" class="text-center">Month</th>
                                <th rowspan="3" class="text-center">Incident/Emergency</th>
                                <th rowspan="3" class="text-center">Date & Time Incident</th>
                                <th rowspan="3" class="text-center">Location Of Incident</th>
                                <th rowspan="3" class="text-center">Incident Type</th>
                                <th colspan="3" class="text-center">Details Of Incident</th>
                                <th rowspan="3" class="text-center">Responded by (Agency)</th>
                                <th rowspan="3" class="text-center">Refer to Hospital</th>
                                <th rowspan="3" class="text-center">Remarks</th>
                                {{-- IF USER ROLE WAS ADMIN --}}
                                @if (Auth::user()->role == 'admin')
                                    <th rowspan="3" class="text-center">Actions</th>
                                @endif
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center align-middle">Involved</th>
                                <th rowspan="2" class="text-center align-middle">Immediate Cause or Reason</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">M</th>
                                <th class="text-center align-middle">F</th>
                            </tr>
                        </thead>
                        <tbody class="text-nowrap">
                            {{-- LOOP THE responses data --}}

                            @foreach ($responses as $response)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $response->date_time->format('F')}}</td>
                                <td>{{ $response->incident_type}}</td>
                                <td>{{ $response->date_time->format('m-j-Y h:i A')}}</td>
                                <td>{{ $response->location}}</td>
                                <td>{{ $response->incident_type}}</td>
                                @if ($response->involve == 'mf')
                                    <td>
                                        M
                                    </td>
                                    <td>
                                        F
                                    </td>
                                @else
                                    <td>
                                        @if ($response->involve == 'm')
                                            M
                                        @endif
                                    </td>
                                    <td>
                                        @if ($response->involve == 'f')
                                            F
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $response->immediate_cause_or_reason }}</td>
                                <td>{{ $response->fname.' '.$response->mname.' '.$response->lastname }}</td>
                                <td>{{ $response->refered_hospital }}</td>
                                <td>{{ $response->remarks }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <button class="btn btn-primary text-nowrap">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </button>
                                        <button class="btn btn-primary text-nowrap">
                                            <i class="bi bi-trash3"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
