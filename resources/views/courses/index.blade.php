@extends('layouts.app')
@section('content')
<div class="flex">
<div>
    <h3 class="text-2xl">Course in This Category</h3>
    <br>
    <a href="{{ route('home') }}" class="text-blue-500"><= Back To Category</a>
</div>
<div class="text-right w-full">
<a href="{{ route('courses.create', ['category_id' => $category_id]) }}" class="btn btn-primary text-xl bg-blue-300 p-1">Create Course</a>
</div>
</div>
<br>
<div id="course-list" class="flex gap-10"></div>
<script>
    var categoryId = {{ $category_id }};
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
    url: '/api/courses/' + categoryId, 
    type: 'GET',
    success: function(response) {
        var courseList = $('#course-list');
        courseList.empty(); 
        if (response.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data',
                    text: 'Tidak ada kursus ditemukan di kategori ini.',
                });
            }
        $.each(response, function(index, course) {
            var courseHtml = `
                <div id="course-${course.id}">   
                    <h3>${course.title}</h3>
                    <p>${course.description}</p>
                    <a href="/courses/${course.id}" class="btn btn-info">Show</a>
                    <a href="/courses/${course.id}/edit" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger" onclick="deleteCourse(${course.id})">Delete</button>
                </div>
                <br>
            `;
            courseList.append(courseHtml); 
        });
    },
    error: function(xhr, status, error) {
        if (xhr.status === 500) {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan',
                text: 'Tidak dapat mengambil data kursus. Coba lagi nanti.',
            });
        } else if (xhr.status === 404) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data',
                text: 'Kursus tidak ditemukan untuk kategori ini.',
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error fetching courses: ' + error,
            });
        }
    }
});
    function deleteCourse(courseId) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Kursus ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/api/courses/' + courseId, 
                type: 'DELETE',
                success: function(response) {
                    if (response.message === 'Course deleted successfully.') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Kursus berhasil dihapus.'
                        });
                        $('#course-' + courseId).remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Kursus gagal dihapus.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus kursus.'
                    });
                }
            });
        }
    });
}
</script>
@endsection
    

