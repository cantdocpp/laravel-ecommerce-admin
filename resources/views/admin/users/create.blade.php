@extends('layouts.admin')

@section('content')
    <div class="user-create">
        <a href="{{ route('admin.users') }}" class="user-create-back">
            Get Back
        </a>
        <h1 class="user-create-header">
            New user registration
        </h1>
        <form method="POST" action="{{ route('admin.users.store') }}" class="user-create-form">
            @csrf
            <div class="user-create__row">
                <label class="user-create__label">
                    <div class="user-create__desc">Full name</div>
                    <input 
                        type="text" 
                        name="name" 
                        class="user-create__input @error('name') user-create__input--error @enderror" 
                        placeholder="Ex: William Gunawan"
                        value="{{ old('name') }}"
                    />
                    @error('name')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Email</div>
                    <input 
                        type="text" 
                        name="email" 
                        class="user-create__input @error('email') user-create__input--error @enderror" 
                        placeholder="Ex: you@example.com"
                        value="{{ old('email') }}"
                    />
                    @error('email')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Phone number</div>
                    <input 
                        type="number" 
                        name="phone" 
                        class="user-create__input @error('phone') user-create__input--error @enderror" 
                        placeholder="Ex: 08**********"
                        value="{{ old('phone') }}"
                    />
                    @error('phone')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Password</div>
                    <input 
                        type="password" 
                        name="password" 
                        class="user-create__input @error('password') user-create__input--error @enderror" 
                        placeholder="Minimum 6 characters"
                    />
                    @error('password')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Confirm password</div>
                    <input type="password" name="confirm" class="user-create__input @error('confirm') user-create__input--error @enderror" placeholder="Re-enter the password">
                    @error('confirm')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Role</div>
                    <select name="role" class="user-create__role">
                        <option value="">Select User Role</option>
                        <option value="1">User</option>
                        <option value="2">Reseller</option>
                        <option value="3">Admin</option>
                        <option value="4">Owner</option>
                    </select>
                    @error('role')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
            </div>
            <button class="user-create__button">
                Submit
            </button>
        </form>
    </div>
@endsection