{{-- EXTENDS TO app.blade.php --}}
@extends('app')

{{-- TITLE --}}
@section('title', 'Respondents List')

{{-- STARTS SECTION AUTH --}}
@section('auth')

    {{-- VITE --}}
    @vite(['resources/js/auth/respondents.js', 'resources/css/auth/respondents.css'])

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
                                        <img src="{{ $respondent->photo_file }}" alt="user" class="rounded-circle" style="width: 25px; height: 25px;">
                                    </td>
                                    <td>{{ $respondent->created_at->format('m-d-Y') }}</td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <i class="bi bi-three-dots-vertical" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item edit-btn-responder"
                                                    style="cursor: pointer;"
                                                    data-id="{{ $respondent->encrypted_id }}">
                                                    <i class="bi bi-pencil-square text-secondary" style="font-style: normal;"> Edit</i>
                                                </li>
                                                <li class="dropdown-item delete-responder-btn"
                                                    style="cursor: pointer;"
                                                    data-id="{{ $respondent->encrypted_id }}">
                                                    <i class="bi bi-trash3 text-danger" style="font-style: normal;"> Delete</i>
                                                </li>
                                            </ul>
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

    {{-- MODAL ADD RESPONDER--}}
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

    {{-- MODAL EDIT ERESPONDER --}}
    <div class="modal fade" id="modal-edit-respondent" aria-hidden="true" tabindex="-1" aria-labelledby="#modal-edit-respondent-title" role="dialog">
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0 text-primary" id="modal-edit-respondent-title">Edit Respondent</h5>
                </div>
                <div class="modal-body p-4">

                    {{-- FORM --}}
                    <form action="" method="POST" enctype="multipart/form-data" id="form-edit-respondent">
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="edit_fname" class="mb-2 text-primary fw-bold">First Name</label>
                                <input type="text" name="edit_fname" id="edit_fname" class="form-control text-primary" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_mname" class="mb-2 text-primary fw-bold">Middle Name</label>
                                <input type="text" name="edit_mname" id="edit_mname" class="form-control text-primary" placeholder="Middle Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_lname" class="mb-2 text-primary fw-bold">Last Name</label>
                                <input type="text" name="edit_lname" id="edit_lname" class="form-control text-primary" placeholder="Last Name" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_gender" class="mb-2 text-primary fw-bold">Gender</label>
                                <select name="edit_gender" id="edit_gender" class="form-select text-primary" required>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_address" class="mb-2 text-primary fw-bold">Address</label>
                                <input type="text" name="edit_address" id="edit_address" class="form-control text-primary" placeholder="Address" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_birthdate" class="mb-2 text-primary fw-bold">Birth Date</label>
                                <input type="date" name="edit_birthdate" id="edit_birthdate" class="form-control text-primary" placeholder="Birth Date" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_birthplace" class="mb-2 text-primary fw-bold">Birth Place</label>
                                <input type="text" name="edit_birthplace" id="edit_birthplace" class="form-control text-primary" placeholder="Birth Place" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_civil_status" class="mb-2 text-primary fw-bold">Civil Status</label>
                                <select name="edit_civil_status" id="edit_civil_status" class="form-select text-primary">
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="mb-2 text-primary fw-bold">Responder Photo</label>
                                <img src="{{ asset('assets/icons/responder.png') }}"
                                    alt="responder-photo"
                                    id="edit_responder_photo"
                                    style="width: 100%;
                                        aspect-ratio: 1;
                                        clip-path: circle();">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="edit_photo" class="mb-2 text-primary fw-bold">Photo</label>
                                <input type="file" name="edit_photo" id="edit_photo" class="form-control text-primary" placeholder="Photo">
                            </div>
                        </div>

                        {{-- BTNS --}}
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                                Cancel
                            </button>
                            <button class="btn btn-primary" type="submit" id="edit-btn-submit-respondent">
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
