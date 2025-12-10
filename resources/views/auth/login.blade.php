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
            <!-- Logo -->
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-circle"></i>
                </div>
            </div>

            <!-- Title -->
            <h1 class="login-title">Login</h1>
            <p class="login-subtitle">untuk melanjutkan ke akun Anda</p>

            <!-- Alert Container (untuk menampilkan error/success) -->
            <div id="alert-container"></div>

            <!-- Login Form -->
            <form id="loginForm" class="login-form">
                @csrf
                
                <!-- NIP Input -->
            <div class="form-group">
                <input 
                    type="text" 
                    id="nip" 
                    name="nip" 
                    class="form-input" 
                    placeholder=" "
                    required
                    autocomplete="username" 
                    pattern="\d{8,}" inputmode="numeric" >
                <label for="nip" class="form-label">NIP</label>
                <span class="error-message" id="nip-error"></span>
                </div>

                <!-- Password Input -->
                <div class="form-group">
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
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                    <span class="error-message" id="password-error"></span>
                </div>

                <!-- Remember & Forgot -->
                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        Tetap masuk
                    </label>
                    <a href="#" class="forgot-link">FORGOT PASSWORD?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">Login</span>
                    <span class="btn-loader" style="display: none;">
                        <i class="fas fa-circle-notch fa-spin"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>