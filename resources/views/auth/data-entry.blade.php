@extends('app')

@section('title', 'Data Entry')

@section('auth')
    {{-- vite --}}
    @vite(['resources/js/auth/data-entry.js', 'resources/css/auth/data-entry.css'])

    {{-- style and script for multiple select --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>

    {{-- section --}}
    <section class="container-fluid p-0 m-0">
        <div class="card bg-white shadow">
            <div class="card-header">
                <h5 class="card-title m-0 text-primary">Data Entry</h5>
            </div>
            <div class="card-body d-flex justify-content-center">
                {{-- FORM --}}
                <form id="form-data-entry" class="w-100" method="POST" style="max-width: 800px;">
                    @csrf
                    <div class="row">
                        {{-- RESPONDENT --}}
                        <div class="mb-3 col-sm-6">
                            <label for="respondent" class="fw-bold mb-1 text-primary">RESPONDENT</label>
                            <select id="respondent" name="respondent[]" class="form-select text-primary" placeholder="Respondent" multiple required>
                                {{-- LOOP THE RESPONDENTS --}}
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
                            <select name="location" id="location" class="form-select text-primary" required>
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
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" required style="min-height: 150px;"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary fw-bold px-4 d-flex algin-items-center gap-1" id="submit-report">
                        <i class="bi bi-floppy"></i>
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
