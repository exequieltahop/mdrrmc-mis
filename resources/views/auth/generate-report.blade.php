@extends('app') {{-- extends to app --}}

@section('title', 'Generate Report') {{-- title --}}

@section('auth')
    {{-- vite --}}
    @vite(['resources/js/auth/generate-report.js',])

    {{-- content --}}
    <x-section-card-list
        list-title="Generate Report">
        <div class="d-flex justify-content-between align-items-center p-0 m-0 mb-3">
            {{-- filter --}}
            <x-form method="GET" class="d-flex align-items-center gap-3" id="form-filter-report">
                {{-- year --}}
                <select name="filter_year" id="filter-year" class="form-select">
                    @for ($i = Carbon\Carbon::now()->year; $i >= 1990; $i--)
                        @if ($year == $i)
                            <option value="{{$i}}" selected>{{$i}}</option>
                        @else
                            <option value="{{$i}}">{{$i}}</option>
                        @endif
                    @endfor
                </select>
                <button class="btn btn-primary" type="submit" id="submit-btn-filter-report">Filter</button>
            </x-form>

            {{-- btn generate report --}}
            <button class="btn btn-primary" id="generate-report-btn">
                <i class="bi bi-box-arrow-down" style="font-style: normal;"> Generate</i>
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered border-dark" id="records-list">
                <thead class="align-middle text-nowrap">
                    <tr class="">
                        <th rowspan="3" class="text-center">No.</th>
                        <th rowspan="3" class="text-center">Month</th>
                        <th rowspan="3" class="text-center">Incident/Emergency</th>
                        <th rowspan="3" class="text-center">Date & Time Incident(YYYY-MM-DD H:m)</th>
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
                <tbody class="align-middle text-center">
                    {{-- LOOP THE responses data --}}
                    @foreach ($responses as $response)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $response->date_time->format('F')}}</td>
                        <td>{{ $response->incident_type}}</td>
                        <td class="text-nowrap">{{ $response->date_time->format('Y-m-j | h:i A')}}</td>
                        <td>{{ $response->location}}</td>
                        <td>{{ $response->incident_type }}</td>
                        @if ($response->involve == 'mf')
                            <td>
                                M
                            </td>
                            <td>
                                F
                            </td>
                        @endif

                        @if ($response->involve == 'm')
                            <td>
                                M
                            </td>
                            <td>

                            </td>
                        @endif

                        @if ($response->involve == 'f')
                            <td>
                                F
                            </td>
                            <td>

                            </td>
                        @endif
                        <td>{{ $response->immediate_cause_or_reason }}</td>
                        <td>
                            {{$response->respondents_name}}
                        </td>
                        <td>{{ $response->refered_hospital }}</td>
                        <td>{{ $response->remark }}</td>
                        @if (Auth::user()->role == "admin")
                            <td>
                                {{-- ACTION EDIT DELETE --}}
                                <div class="dropdown">
                                    <i id="dropdownMenuButton" class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        {{-- EDIT --}}
                                        <div class="dropdown-item text-primary edit-record-btn"
                                            data-id="{{ $response->encrypted_id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit-record-modal"
                                            style="cursor: pointer;">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span>Edit</span>
                                        </div>

                                        {{-- DELETE --}}
                                        <div class="dropdown-item delete-action-btn text-danger" style="cursor: pointer;" data-id="{{ $response->encrypted_id }}">
                                            <i class="bi bi-trash-fill"></i>
                                            <span>Delete</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-section-card-list>
@endsection