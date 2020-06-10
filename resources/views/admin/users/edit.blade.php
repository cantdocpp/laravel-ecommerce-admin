@extends('layouts.admin')

@section('admin-title')
    User edit page
@endsection

@section('content')
    <div class="user-create">
        <a href="{{ route('admin.users') }}" class="user-create-back">
            Get Back
        </a>
        <h1 class="user-create-header">
            Edit user
        </h1>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="user-create-form">
            @csrf
            @method('put')
            <div class="user-create__row">
                <label class="user-create__label">
                    <div class="user-create__desc">Full name</div>
                    <input 
                        type="text" 
                        name="name" 
                        class="user-create__input @error('name') user-create__input--error @enderror" 
                        placeholder="Ex: William Gunawan"
                        value="{{ old('name') ? old('name') : $user->name }}"
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
                        value="{{ old('email') ? old('email') : $user->email }}"
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
                        type="text" 
                        name="phone" 
                        class="user-create__input @error('phone') user-create__input--error @enderror" 
                        placeholder="Ex: 08**********"
                        value="{{ old('phone') ? old('phone') : $user->phone }}"
                    />
                    @error('phone')
                        <div class="user-create__error">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="user-create__label">
                    <div class="user-create__desc">Role</div>
                    <select name="role" class="user-create__role">
                        <option value="">Select User Role</option>
                        <option value="1" {{ $user->role === 1 ? 'selected' : '' }}>User</option>
                        <option value="2" {{ $user->role === 2 ? 'selected' : '' }}>Reseller</option>
                        <option value="3" {{ $user->role === 3 ? 'selected' : '' }}>Admin</option>
                        <option value="4" {{ $user->role === 4 ? 'selected' : '' }}>Owner</option>
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
