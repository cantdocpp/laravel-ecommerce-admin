@extends('layouts.admin')

@section('admin-title')
    User list page
@endsection

@section('content')
    <div class="user">
        <h1 class="user__header">User List</h1>

        <div class="user__add__search">
            <user-search></user-search>
            <a href="{{ route('admin.users.create') }}" class="user__add__link">
                Add User
            </a>
        </div>

        {{-- {{ app('request')->input('role') }} --}}

        <user-table :users="{{ json_encode($users) }}"></user-table>
    </div>
@endsection