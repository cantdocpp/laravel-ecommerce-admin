@extends('layouts.admin')

@section('content')
    <div class="user-create">
        <h1 class="user-create-header">
            New user registration
        </h1>
        <form method="POST" action="{{ route('admin.users.store') }}" class="user-create-form">
            @csrf
            <div class="user-create__row">
                <label class="user-create__label">
                    <div class="user-create__desc">Full name</div>
                    <input type="text" name="name" class="user-create__input" placeholder="Ex: William Gunawan">
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Email</div>
                    <input type="text" name="email" class="user-create__input" placeholder="Ex: you@example.com">
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Phone number</div>
                    <input type="number" name="phone" class="user-create__input" placeholder="Ex: 08**********">
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Password</div>
                    <input type="password" name="password" class="user-create__input" placeholder="Minimum 6 characters">
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Confirm password</div>
                    <input type="password" name="confirm" class="user-create__input" placeholder="Re-enter the password">
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Role</div>
                    <select name="role" id="pet-select">
                        <option value="">Select User Role</option>
                        <option value="1">User</option>
                        <option value="2">Reseller</option>
                        <option value="3">Admin</option>
                        <option value="4">Owner</option>
                    </select>
                </label>
            </div>
            <button class="user-create__button">
                Submit
            </button>
        </form>
    </div>
@endsection