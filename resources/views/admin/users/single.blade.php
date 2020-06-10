@extends('layouts.admin')

@section('admin-title')
    User detail page
@endsection

@section('content')
    <div class="single-user">
        <div class="single-user__content">
            <div class="single-user__block">
                <div class="single-user__label">
                    Name
                </div>
                <div class="single-user__data">
                    {{ $user->name }}
                </div>
            </div>
            <div class="single-user__block">
                <div class="single-user__label">
                    Email
                </div>
                <div class="single-user__data">
                    {{ $user->email }}
                </div>
            </div>
            <div class="single-user__block">
                <div class="single-user__label">
                    Phone number
                </div>
                <div class="single-user__data">
                    {{ $user->phone }}
                </div>
            </div>
            <div class="single-user__block">
                <div class="single-user__label">
                    Role
                </div>
                <div class="single-user__data">
                    @if ($user->role === 1)
                        User
                    @elseif ($user->role === 2)
                        Reseller
                    @elseif ($user->role === 3)
                        Admin
                    @elseif ($user->role === 4)
                        Owner
                    @endif
                </div>
            </div>
            <div class="single-user__block">
                <div class="single-user__label">
                    Status
                </div>
                <div class="single-user__data">
                    @if ($user->email_verified_at)
                        Verified
                    @elseif(! $user->email_verified_at)
                        Not verified
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ url()->current() }}/edit" class="single-user__button">
            Edit
        </a>
    </div>
@endsection