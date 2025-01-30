<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Create Course</h1>
    <form id="create-course-form">
        <input type="hidden" id="category_id" name="category_id" value="{{ $category_id }}">

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <button type="submit">Create Course</button>
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
                url: '/api/courses', 
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    console.log(response.data);
                    return view('courses.index');
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });
    </script>
</body>
</html>
