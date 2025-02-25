@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-10 rounded-lg shadow-md mt-24">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" id="login-button" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Login
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
                let form = $(this);
                let button = $('#login-button');

                // Clear previous errors
                $('#email-error, #password-error').text('').addClass('hidden');

                // Validate inputs
                if (email === '' || password === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email and Password are required.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                button.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    timeout: 2000,
                    data: form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Login successful!',
                            icon: 'success',
                            timer: 2000,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('home') }}"; // Redirect after success
                        });
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Login failed. Please check your credentials.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function () {
                        setTimeout(() => {
                            button.prop('disabled', false).text('Login');
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endsection
