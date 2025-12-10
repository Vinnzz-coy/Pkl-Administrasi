document.addEventListener('DOMContentLoaded', function() {
    // --- 0. INISIALISASI VARIABEL ---
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const submitBtn = document.getElementById('submitBtn');
    const nipInput = document.getElementById('nip'); // Variabel NIP

    // --- 1. Toggle Password Visibility ---
    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    }

    // --- 2. Validation Helper Functions ---

    /** Memastikan NIP hanya angka dan minimal 8 digit. */
    function validateNIP(nip) {
        // Regex: ^ (awal string), \d (hanya angka), {8,} (minimal 8 kali), $ (akhir string)
        const re = /^\d{8,}$/;
        
        if (!nip) return false;
        
        return re.test(nip);
    }

    /** Menampilkan pesan error di bawah input. */
    function showError(inputId, message) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);
        
        if (errorElement && inputElement) {
            errorElement.textContent = message;
            inputElement.classList.add('error');
        }
    }

    /** Menghapus pesan error dari input. */
    function clearError(inputId) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);
        
        if (errorElement && inputElement) {
            errorElement.textContent = '';
            inputElement.classList.remove('error');
        }
    }

    /** Menampilkan alert di bagian atas form. */
    function showAlert(message, type = 'error') {
        const alertContainer = document.getElementById('alert-container');
        if (!alertContainer) return;

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.textContent = message;
        
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // --- 3. Input Control & Real-time Validation ---
    
    // KONTROL INPUT: Mencegah pengetikan huruf di field NIP
    if (nipInput) {
        nipInput.addEventListener('keypress', function(e) {
            const charCode = (e.which) ? e.which : e.keyCode;
            
            // Hanya izinkan angka (48-57) dan tombol kontrol (seperti Backspace, Delete, Tab)
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                e.preventDefault();
                
                // Feedback visual singkat
                this.style.border = '2px solid #fc8181';
                setTimeout(() => {
                    this.style.border = ''; // Asumsi CSS yang normal menggunakan border kosong atau default
                }, 200);
            }
        });

        // VALIDASI REAL-TIME UNTUK NIP (Saat blur/keluar dari field)
        nipInput.addEventListener('blur', function() {
            const nip = this.value.trim();
            clearError('nip');
            if (nip && !validateNIP(nip)) {
                showError('nip', 'NIP harus berupa angka dan minimal 8 digit.'); 
            }
        });
    }
    
    // VALIDASI REAL-TIME UNTUK PASSWORD
    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            const password = this.value;
            clearError('password');
            if (password && password.length < 6) {
                showError('password', 'Password minimal 6 karakter');
            }
        });
    }

    // --- 4. Form Submit Handler (AJAX) ---
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearError('nip');
            clearError('password');
            
            // Get form data
            const formData = new FormData(this);
            const nip = formData.get('nip') ? formData.get('nip').trim() : '';
            const password = formData.get('password') || '';
            
            // Validate (Front-end Final Check)
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
            
            // Show loading
            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').style.display = 'none';
            submitBtn.querySelector('.btn-loader').style.display = 'inline-block';
            
            try {
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Submit form (Menggunakan NIP)
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nip: nip, // Mengirim 'nip' ke backend
                        password: password,
                        remember: formData.get('remember') ? true : false
                    })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) { // Cek HTTP status OK dan success flag
                    showAlert(data.message || 'Login berhasil!', 'success');
                    
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1000);
                } else {
                    // Handle Validation Errors from Laravel (HTTP 422) or other server errors
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
                // Reset button setelah try/catch
                submitBtn.disabled = false;
                submitBtn.querySelector('.btn-text').style.display = 'inline-block';
                submitBtn.querySelector('.btn-loader').style.display = 'none';
            }
        });
    }
});