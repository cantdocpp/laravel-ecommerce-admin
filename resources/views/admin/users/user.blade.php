@extends('layouts.admin')

@section('content')
    <div class="user">
        <h1 class="user__header">User List</h1>

        <div class="user__add__search">
            <div class="user__search">
                <input type="text" class="user__search__input" placeholder="Search user by name">
            </div>
            <a href="{{ route('admin.users.create') }}" class="user__add__link">
                Add User
            </a>
        </div>

        <user-table></user-table>

        <div class="user-sort">
            <div class="user-sort__option">
                <select name="role" class="user-sort__role">
                    <option value="">Role</option>
                    <option value="1">User</option>
                    <option value="2">Reseller</option>
                    <option value="3">Admin</option>
                    <option value="4">Owner</option>
                </select>
            </div>

            <div class="user-sort__page"></div>
        </div>
    </div>
@endsection