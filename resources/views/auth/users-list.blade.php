@extends('app')

{{-- TITLE --}}
@section('title', 'Respondents List')

@section('auth')
    {{-- VITE --}}
    @vite(['resources/js/auth/users-list.js'])

    {{-- section card list --}}
    <x-section-card-list list-title="Users List">

        {{-- add user btn --}}
        <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#modal-add-user">
            <i class="bi bi-person-plus-fill" style="font-style: normal;"> Add User</i>
        </button>

        {{-- table users list --}}
        <x-table
            table-id="users-list-table"
            :ths="['No', 'Name', 'Email', 'Create At', 'Action']"
            tbody-id="tbody-users-list"
            table-class="table-hover">

            {{-- loop the users array and render it --}}
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d | h:i A') : "" }}</td>
                    <td class="align-middle text-center">

                        {{-- ACTION EDIT DELETE --}}
                        <div class="dropdown">
                            <i id="dropdownMenuButton" class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                {{-- EDIT --}}
                                <div class="dropdown-item text-primary edit-record-btn"
                                    data-id="{{ $user->encrypted_id }}"
                                    style="cursor: pointer;">
                                    <i class="bi bi-pencil-fill"></i>
                                    <span>Edit</span>
                                </div>

                                {{-- DELETE --}}
                                <div
                                    class="dropdown-item delete-action-btn text-danger delete-user-btn"
                                    style="cursor: pointer;"
                                    data-id="{{ $user->encrypted_id }}">
                                    <i class="bi bi-trash-fill"></i>
                                    <span>Delete</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach

        </x-table>

        {{-- modal add user --}}
        <x-modal
            modal-id="modal-add-user"
            modal-title="Add User">

            {{-- form add user --}}
            <x-form id="form-add-user" method="POST" class="p-3">
                @csrf

                {{-- name --}}
                <x-input
                    input-type="text"
                    name="name"
                    label="Name"/>

                {{-- email --}}
                <x-input
                    input-type="email"
                    name="email"
                    label="Email"/>

                {{-- password --}}
                <x-input
                    input-type="password"
                    name="password"
                    label="Password"/>

                <x-input
                    input-type="password"
                    name="password_confirmation"
                    label="Confirm Password"/>

                {{-- btns --}}
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <button class="btn btn-primary mb-0" type="submit" id="submit-add-user-btn">
                        <i class="bi bi-plus-lg" style="font-style: normal;"> Submit</i>
                    </button>
                    <button class="btn btn-primary mb-0"
                        data-bs-dismiss="modal"
                        type="button"
                        id="btn-dismiss-modal">
                        <i class="bi bi-x-lg" style="font-style: normal;"> Cancel</i>
                    </button>
                </div>

            </x-form>

        </x-modal>

        {{-- edit user modal --}}
        <x-modal
            modal-id="edit-user-modal"
            modal-title="Add User">

            {{-- form edit user --}}
            <x-form id="edit-user-modal" method="POST" class="p-3">
                @csrf
                @method('PUT')

                {{-- id --}}
                <x-input
                    input-type="hidden"
                    name="edit_id"
                    label="Id"/>

                {{-- name --}}
                <x-input
                    input-type="text"
                    name="edit_name"
                    label="Name"/>

                {{-- email --}}
                <x-input
                    input-type="email"
                    name="edit_email"
                    label="Email"/>

                {{-- new password --}}
                <x-input
                    input-type="password"
                    name="edit_new_password"
                    label="New Password"
                    :required="false"/>

                <x-input
                    input-type="password"
                    name="edit_new_password_confirmation"
                    label="Confirm Password"
                    :required="false"/>

                {{-- btns --}}
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <button class="btn btn-primary mb-0" type="submit" id="submit-edit-user-btn">
                        <i class="bi bi-plus-lg" style="font-style: normal;"> Submit</i>
                    </button>
                    <button class="btn btn-primary mb-0"
                        data-bs-dismiss="modal"
                        type="button"
                        id="btn-dismiss-modal-edit">
                        <i class="bi bi-x-lg" style="font-style: normal;"> Cancel</i>
                    </button>
                </div>

            </x-form>

        </x-modal>

    </x-section-card-list>
@endsection