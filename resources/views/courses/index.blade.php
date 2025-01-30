<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Courses in Category</title>
</head>
<body>
    <h1>Courses in this Category</h1>
    <a href="{{ route('home   ') }}"><h3><= Back To Category</h1></a>
    <br>
    <a href="{{ route('courses.create', ['category_id' => $category_id]) }}" class="btn btn-primary">Create Course</a>

    <div>
        @foreach($courses as $course)
            <div id="course-{{ $course->id }}">
                <h3>{{ $course->title }}</h3>
                <p>{{ $course->description }}</p>
                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info">Show</a>
                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Edit</a>
                <button class="btn btn-danger" onclick="deleteCourse({{ $course->id }})">Delete</button>
            </div>
            <hr>
        @endforeach
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function deleteCourse(courseId) {
            if (confirm("Are you sure you want to delete this course?")) {
                $.ajax({
                    url: '/api/courses/' + courseId,
                    type: 'DELETE', 
                    success: function(response) {
                if (response.message === 'Course deleted successfully.') {
                    alert(response.message);
                    $('#course-' + courseId).remove(); 
                } else {
                    alert('Course not found or failed to delete.');
                }
            },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            }
        }
    </script>
</body>
</html>