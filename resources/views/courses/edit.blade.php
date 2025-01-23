<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Edit Course</h1>
    <form id="edit-course-form">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="{{ $course->title }}" required><br><br>

        <label for="category_id">Category:</label><br>
        <input type="number" id="category_id" name="category_id" value="{{ $course->category_id }}" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description">{{ $course->description }}</textarea><br><br>

        <button type="submit">Update Course</button>
    </form>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#edit-course-form').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                title: $('#title').val(),
                category_id: $('#category_id').val(),
                description: $('#description').val()
            };

            var courseId = "{{ $course->id }}";

            $.ajax({
                url: '/api/courses/' + courseId,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    console.log(response.data);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });
    </script>
</body>
</html>
