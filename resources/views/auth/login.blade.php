@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-10 rounded-lg shadow-md mt-24">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <form id="login-form" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p id="email-error" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p id="password-error" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>

            <button type="submit" id="login-button" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex justify-center items-center">
                <span id="login-text">Login</span>
                <span id="login-spinner" class="ml-2 hidden">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </span>
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar disini</a>
        </p>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault();

                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let button = $('#login-button');
                let loginText = $('#login-text');
                let loginSpinner = $('#login-spinner');

                $('#email-error, #password-error').text('').addClass('hidden');

                if (email === '' || password === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email dan Password wajib diisi!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                button.prop('disabled', true);
                loginText.text('Processing...');
                loginSpinner.removeClass('hidden');

                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    timeout: 5000,
                    data: {
                        email: email,
                        password: password,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.token) {
                            localStorage.setItem('authToken', response.token);

                            Swal.fire({
                                title: 'Success!',
                                text: 'Login berhasil!',
                                icon: 'success',
                                timer: 2000,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('home') }}";  // Redirect ke Home
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Token tidak ditemukan, coba lagi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Login gagal. Periksa kembali kredensial Anda.';

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON?.errors;
                            if (errors?.email) {
                                $('#email-error').text(errors.email[0]).removeClass('hidden');
                            }
                            if (errors?.password) {
                                $('#password-error').text(errors.password[0]).removeClass('hidden');
                            }
                            errorMessage = 'Periksa kembali input Anda.';
                        } else if (xhr.status === 401) {
                            errorMessage = 'Email atau password salah.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan server, coba lagi nanti.';
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function () {
                        setTimeout(() => {
                            button.prop('disabled', false);
                            loginText.text('Login');
                            loginSpinner.addClass('hidden');
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endsection
