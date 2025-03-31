{{-- EXTENDS TO app.blade.php --}}
@extends('app')

{{-- TITLE --}}
@section('title', 'Records')

{{-- SECTION --}}
@section('auth')

    {{-- VITE STYLE AND SCRIPT --}}
    @vite(['resources/css/auth/records.css', 'resources/js/auth/records.js'])

    {{-- style and script for multiple select --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>

    {{-- CONTENT --}}
    <section class="container-fluid p-0 m-0 w-100 overflow-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Records Of Incidents</h5>
            </div>
            <div class="card-body">
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
            </div>
        </div>
    </section>

    {{-- MODAL EDIT RECORD --}}
    <x-modal modal-id="edit-record-modal" modal-title="Edit Record">
        {{-- FORM --}}
        <x-form class="w-100 form-edit-response p-3" id="form-edit-record" style="max-width: 800px;">
            @csrf
            @method('PUT')
            {{-- INPUT --}}
            <div class="row">
                {{-- RESPONDENT --}}
                <div class="mb-3 col-sm-6">
                    <label for="respondent" class="fw-bold mb-1 text-primary">RESPONDENT</label>

                    <select id="responder" name="respondent[]" class="form-select text-primary responders" placeholder="Respondent" style="color: var(--primary-color);" multiple required>

                        {{--
                            LOOP THE RESPONDENTS,
                            THEN MAKE THE OPTION SELECTED
                            IF ITS ID WAS EQUAL TO ID IN THE DATABASE
                        --}}
                        @foreach ($respondents as $respondent)
                            <option value="{{ $respondent->encrypted_id }}">
                                {{
                                    $respondent->first_name . ' ' .
                                    $respondent->middle_name . ' ' .
                                    $respondent->last_name
                                }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- LOCATION --}}
                <div class="mb-3 col-sm-6">
                    <label for="location" class="fw-bold mb-1 text-primary">LOCATION</label>
                    <select name="location" id="location" class="form-select text-primary edit-location" required>
                        <option value="" disabled selected>Select Brgy</option>
                        <option value="benit">Benit</option>
                        <option value="buac_daku">Buac Daku</option>
                        <option value="buac_gamay">Buac Gamay</option>
                        <option value="cabadbaran">Cabadbaran</option>
                        <option value="concepcion">Concepcion</option>
                        <option value="consolacion">Consolacion</option>
                        <option value="dagsa">Dagsa</option>
                        <option value="hibod_hibod">Hibod-hibod</option>
                        <option value="hindangan">Hindangan</option>
                        <option value="hipantag">Hipantag</option>
                        <option value="javier">Javier</option>
                        <option value="kahupian">Kahupian</option>
                        <option value="kanangkaan">Kanangkaan</option>
                        <option value="kauswagan">Kauswagan</option>
                        <option value="la_purisima_concepcion">La Purisima Concepcion</option>
                        <option value="libas">Libas</option>
                        <option value="lum_an">Lum-an</option>
                        <option value="mabicay">Mabicay</option>
                        <option value="mac">Mac</option>
                        <option value="magatas">Magatas</option>
                        <option value="mahayahay">Mahayahay</option>
                        <option value="malinao">Malinao</option>
                        <option value="maria_plana">Maria Plana</option>
                        <option value="milagroso">Milagroso</option>
                        <option value="olisihan">Olisihan</option>
                        <option value="pancho_villa">Pancho Villa</option>
                        <option value="pandan">Pandan</option>
                        <option value="rizal">Rizal</option>
                        <option value="salvacion">Salvacion</option>
                        <option value="san_francisco_mabuhay">San Francisco Mabuhay</option>
                        <option value="san_isidro">San Isidro</option>
                        <option value="san_jose">San Jose</option>
                        <option value="san_juan">San Juan</option>
                        <option value="san_miguel">San Miguel</option>
                        <option value="san_pedro">San Pedro</option>
                        <option value="san_roque">San Roque</option>
                        <option value="san_vicente">San Vicente</option>
                        <option value="santa_maria">Santa Maria</option>
                        <option value="suba">Suba</option>
                        <option value="tampoong">Tampoong</option>
                        <option value="zone_i">Zone I</option>
                        <option value="zone_ii">Zone II</option>
                        <option value="zone_iii">Zone III</option>
                        <option value="zone_iv">Zone IV</option>
                        <option value="zone_v">Zone V</option>
                    </select>
                </div>

                {{-- DATE TIME --}}
                <div class="mb-3 col-sm-6">
                    <label for="datetime" class="fw-bold mb-1 text-primary">DATE TIME</label>
                    <input type="datetime-local" name="datetime" id="datetime" class="form-control text-primary" placeholder="Date-Time" required>
                </div>


                {{-- INVOLVE --}}
                <div class="mb-3 col-sm-6">
                    <label for="involve" class="fw-bold mb-1 text-primary">INVOLVE</label>
                    <select name="involve" id="involve" class="form-select" placeholder="Involve">
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                        <option value="mf">Both Male Female</option>
                    </select>
                </div>

                {{-- REFERE HOSPITAL --}}
                <div class="mb-3 col-sm-6">
                    <label for="hospital" class="fw-bold mb-1 text-primary">REFER TO HOSPITAL</label>
                    <input type="hospital" name="hospital" id="hospital" class="form-control text-primary" placeholder="Refer To Hospital" required>
                </div>

                {{-- INCIDENT TYPE --}}
                <div class="mb-3 col-sm-6">
                    <label for="incident_type" class="fw-bold mb-1 text-primary">INCIDENT TYPE</label>
                    <input type="text" name="incident_type" id="incident_type" class="form-control text-primary" placeholder="Enter Incident Type" required>
                </div>

                {{-- REASON/CAUSE --}}
                <div class="mb-3 col-sm-6">
                    <label for="cause" class="fw-bold mb-1 text-primary">IMMEDIATE CAUSE OR REASON</label>
                    <input type="cause" name="cause" id="cause" class="form-control text-primary" placeholder="Immediate cause or reason" required>
                </div>

                {{-- REMARKS --}}
                <div class="mb-3 col-sm-12">
                    <label for="remarks" class="fw-bold mb-1 text-primary">REMARKS</label>
                    <textarea name="remarks" id="remarks" class="form-control text-primary" placeholder="Remarks" required style="min-height: 150px;"></textarea>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="d-flex justify-content-end align-items-center gap-2">
                {{-- CLOSE BTN --}}
                <button
                    class="btn btn-primary fw-bold px-4 m-0"
                    data-bs-dismiss="modal">
                    <i class="bi bi-x-lg" style="font-style: normal;"> Cancel</i>
                </button>

                {{-- BTN SUBMIT --}}
                <button
                    class="btn btn-primary fw-bold px-4 m-0 d-flex algin-items-center gap-1 btn-edit-response"
                    type="submit"
                    id="submit-btn-edit-record">
                    <i class="bi bi-floppy" style="font-style: normal;"> Update</i>
                </button>
            </div>
        </x-form>
    </x-modal>
@endsection
