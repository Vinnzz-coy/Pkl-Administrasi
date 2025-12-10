<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Administrasi PKL</title>

    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-container">
                    <img src="{{ asset('logo-smk.webp') }}" alt="Logo SMK" class="logo-img">
                </div>
            </div>

            <!-- Header Section -->
            <div class="header-section">
                <h1 class="login-title">Login</h1>
                <p class="login-subtitle">untuk masuk ke akun Anda</p>
            </div>

            <!-- Alert Section -->
            <div id="alert-container" class="alert-container"></div>

            <!-- Form Section -->
            <form id="loginForm" class="login-form">
                @csrf

                <!-- NIP Field -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="nip"
                            name="nip"
                            class="form-input"
                            placeholder=" "
                            required
                            autocomplete="username"
                            pattern="\d{8,}"
                            inputmode="numeric"
                        >
                        <label for="nip" class="form-label">NIP</label>
                    </div>
                    <span class="error-message" id="nip-error"></span>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder=" "
                            required
                            autocomplete="current-password"
                        >
                        <label for="password" class="form-label">Password</label>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Show password">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <span class="error-message" id="password-error"></span>
                </div>

                <!-- Submit Button -->
                <div class="form-group form-group-submit">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text">Login</span>
                        <span class="btn-loader">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
