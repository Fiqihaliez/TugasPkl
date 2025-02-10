@extends('layouts.app')
@section('content')
<h1 class="text-4xl">Create Course</h1>
<br>
<form id="create-course-form" class="w-full h-full">
    <select id="category_id" name="category_id" class="border border-gray-300 rounded-md" required>
        <option value="">Select a Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select><br><br>
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" class="border border-gray-300 rounded-md" required><br><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description" class="w-full h-32 border border-gray-300 rounded-md"></textarea><br><br>
    <button type="submit" class="bg-green-300 text-lg p-2">Create Course</button>
</form>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#create-course-form').on('submit', function(e) {
        e.preventDefault();
        var formData = {
            title: $('#title').val(),
            category_id: $('#category_id').val(), 
            description: $('#description').val()
        };
        $.ajax({
            url: '{{ route('api.courses.store')}}', 
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Kursus Berhasil Dibuat!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#create-course-form')[0].reset();  
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal membuat kursus. Coba lagi.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection
    