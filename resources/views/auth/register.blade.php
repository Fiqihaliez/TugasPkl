@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
<div class="max-w-sm mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Daftar</h2>
    <form id="register-form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <p id="name-error" class="text-red-500 text-xs mt-1 hidden"></p>
        </div>

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

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Pilih Role</label>
            <select id="role" name="role" required 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <p id="role-error" class="text-red-500 text-xs mt-1 hidden"></p>
        </div>

        <button type="submit" id="register-button" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Daftar
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
    </p>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#register-form').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#register-button');

                // Clear error messages
                $('#name-error, #email-error, #password-error, #role-error').text('').addClass('hidden');

                // Disable button and show "Processing..." text
                button.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: "{{ route('register') }}",
                    type: "POST",
                    timeout: 5000,  // Set a reasonable timeout
                    data: form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Registration successful!',
                            icon: 'success',
                            timer: 1500,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('login') }}"; // Redirect to login page after success
                        });
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (let field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    $('#' + field + '-error').text(errors[field][0]).removeClass('hidden');
                                }
                            }
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: 'Registration failed. Please check the form.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function () {
                        button.prop('disabled', false).text('Daftar');
                    }
                });
            });
        });
    </script>
@endsection
