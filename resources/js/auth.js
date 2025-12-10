document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const submitBtn = document.getElementById('submitBtn');
    const nipInput = document.getElementById('nip');

    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    }

    function validateNIP(nip) {
        const re = /^\d{8,}$/;
        if (!nip) return false;
        return re.test(nip);
    }

    function showError(inputId, message) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);

        if (errorElement && inputElement) {
            errorElement.textContent = message;
            inputElement.classList.add('error');
        }
    }

    function clearError(inputId) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);

        if (errorElement && inputElement) {
            errorElement.textContent = '';
            inputElement.classList.remove('error');
        }
    }

    function showAlert(message, type = 'error') {
        const alertContainer = document.getElementById('alert-container');
        if (!alertContainer) return;

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.textContent = message;

        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    if (nipInput) {
        nipInput.addEventListener('keypress', function(e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                e.preventDefault();
                this.style.border = '2px solid #fc8181';
                setTimeout(() => {
                    this.style.border = '';
                }, 200);
            }
        });

        nipInput.addEventListener('blur', function() {
            const nip = this.value.trim();
            clearError('nip');
            if (nip && !validateNIP(nip)) {
                showError('nip', 'NIP harus berupa angka dan minimal 8 digit.');
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            const password = this.value;
            clearError('password');
            if (password && password.length < 6) {
                showError('password', 'Password minimal 6 karakter');
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            clearError('nip');
            clearError('password');

            const formData = new FormData(this);
            const nip = formData.get('nip') ? formData.get('nip').trim() : '';
            const password = formData.get('password') || '';

            let hasError = false;

            if (!nip) {
                showError('nip', 'NIP wajib diisi');
                hasError = true;
            } else if (!validateNIP(nip)) {
                showError('nip', 'NIP harus berupa angka dan minimal 8 digit.');
                hasError = true;
            }

            if (!password) {
                showError('password', 'Password wajib diisi');
                hasError = true;
            } else if (password.length < 6) {
                showError('password', 'Password minimal 6 karakter');
                hasError = true;
            }

            if (hasError) return;

            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').style.display = 'none';
            submitBtn.querySelector('.btn-loader').style.display = 'inline-block';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nip: nip,
                        password: password,
                        remember: formData.get('remember') ? true : false
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert(data.message || 'Login berhasil!', 'success');

                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1000);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            showError(key, data.errors[key][0]);
                        });
                    } else {
                        showAlert(data.message || 'Terjadi kesalahan saat login.');
                    }
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                showAlert('Terjadi kesalahan koneksi atau server');
            } finally {
                submitBtn.disabled = false;
                submitBtn.querySelector('.btn-text').style.display = 'inline-block';
                submitBtn.querySelector('.btn-loader').style.display = 'none';
            }
        });
    }
});
