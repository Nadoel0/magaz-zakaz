@extends('layouts.app')

@section('content')
<div class="container">
    <div class="login-container">
        <h2 class="login-name">{{ __('Регистрация') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="user-container">
                <input type="text" class="login-input" name="name" required>
                <label for="name" class="login-label">{{ __('Имя') }}</label>

                @error('name')
                <span class="invalid-input">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="user-container">
                <input type="email" class="login-input" name="email" required>
                <label for="email" class="login-label">{{ __('Email') }}</label>

                @error('email')
                <span class="invalid-input">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="user-container">
                <input type="password" class="login-input" name="password" required>
                <label for="password" class="login-label">{{ __('Пароль') }}</label>

                @error('password')
                <span class="invalid-input">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="user-container">
                <input type="password" class="login-input" name="password-confirmation" required>
                <label for="password-confirm" class="login-label">{{ __('Подтвердите пароль') }}</label>
            <div class="login-submit-container">
                <button type="submit" class="login-submit">Войти</button>
            </div>
        </form>
        <div class="register-prompt-container">
            <p>Уже есть аккаунт?</p>
            <a href="{{ route('login') }}">Войти</a>
        </div>
    </div>
</div>
@endsection
