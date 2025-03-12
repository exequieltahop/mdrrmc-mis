{{-- EXTENDS TO app.blade.php --}}
@extends('app')

{{-- TITLE --}}
@section('title', 'Respondents List')

{{-- VITE --}}
@vite(['resources/js/auth/respondents.js', 'resources/css/auth/respondents.css'])

{{-- STARTS SECTION AUTH --}}
@section('auth')

    {{-- CONTENT --}}
    <section class="container-fluid p-0 m-0 overflow-auto">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-add-respondent">
            <i class="bi bi-plus-lg"></i>
            Add Respondent
        </button>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Respondent's List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="respondents-table">
                        <thead class="align-middle text-nowrap">
                            <th>No.</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Birth Date</th>
                            <th>Birth Place</th>
                            <th>Civil Status</th>
                            <th>Photo</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </thead>
                        <tbody class="align-middle text-nowrap">
                            {{-- LOOP respondents --}}
                            @forelse ($respondents as $respondent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $respondent->first_name }}</td>
                                    <td>{{ $respondent->middle_name }}</td>
                                    <td>{{ $respondent->last_name }}</td>
                                    <td>{{ $respondent->age }}</td>
                                    <td>
                                        @if ($respondent->gender == 'm')
                                            Male
                                        @endif
                                        @if ($respondent->gender == 'f')
                                            Female
                                        @endif
                                    </td>
                                    <td>{{ $respondent->address }}</td>
                                    <td>{{ $respondent->birthdate }}</td>
                                    <td>{{ $respondent->birthplace }}</td>
                                    <td>{{ $respondent->civil_status }}</td>
                                    <td>
                                        @if ($respondent->photo == "")
                                            <img src="{{ asset('assets/icons/user.png') }}" alt="user" class="rounded-circle" style="initial-ratio: 1; max-width: 25px;">
                                        @endif

                                        @if ($respondent->photo != "")
                                            <img src="{{ asset('storage/'.$respondent->photo) }}" alt="user" class="rounded-circle" style="max-width: 25px; initial-ratio: 1;">
                                        @endif
                                    </td>
                                    <td>{{ $respondent->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <button class="btn btn-primary text-nowrap m-0">
                                                <i class="bi bi-pencil-square"></i>
                                                Edit
                                            </button>
                                            <button class="btn btn-primary text-nowrap m-0">
                                                <i class="bi bi-trash3"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL ADD RESPONDENT --}}
    <div class="modal fade" id="modal-add-respondent" aria-hidden="true" tabindex="-1" aria-labelledby="#modal-add-respondent-title" role="dialog">
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0 text-primary">Add Respondent</h5>
                </div>
                <div class="modal-body p-4">

                    {{-- FORM --}}
                    <form action="" method="POST" enctype="multipart/form-data" id="form-add-respondent">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="fname" class="mb-2 text-primary fw-bold">First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control text-primary" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="mname" class="mb-2 text-primary fw-bold">Middle Name</label>
                                <input type="text" name="mname" id="mname" class="form-control text-primary" placeholder="Middle Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="lname" class="mb-2 text-primary fw-bold">Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control text-primary" placeholder="Last Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="gender" class="mb-2 text-primary fw-bold">Gender</label>
                                <select name="gender" id="gender" class="form-select text-primary" required>
                                    <option value="m">Male</option>
                                    <option value="m">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="address" class="mb-2 text-primary fw-bold">Address</label>
                                <input type="text" name="address" id="address" class="form-control text-primary" placeholder="Address" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="birthdate" class="mb-2 text-primary fw-bold">Birth Date</label>
                                <input type="date" name="birthdate" id="birthdate" class="form-control text-primary" placeholder="Birth Date" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="birthplace" class="mb-2 text-primary fw-bold">Birth Place</label>
                                <input type="text" name="birthplace" id="birthplace" class="form-control text-primary" placeholder="Birth Place" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="civil_status" class="mb-2 text-primary fw-bold">Civil Status</label>
                                <select name="civil_status" id="civil_status" class="form-select text-primary">
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="photo" class="mb-2 text-primary fw-bold">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control text-primary" placeholder="Photo" required>
                            </div>

                        </div>

                        {{-- BTNS --}}
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                                Cancel
                            </button>
                            <button class="btn btn-primary" type="submit" id="btn-submit-respondent">
                                <i class="bi bi-plus-lg"></i>
                                Submit
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
{{-- END SECTION --}}
@endsection
