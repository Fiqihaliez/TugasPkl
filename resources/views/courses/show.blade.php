<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Course</title>
</head>
<body>
    <h1>Course: {{ $course->title }}</h1>

    <p><strong>Category:</strong> {{ $course->category->name }}</p>
    <p><strong>Description:</strong> {{ $course->description }}</p>

    <a href="/courses/{{ $course->id }}/edit">Edit</a>

    <form method="POST" action="/api/courses/{{ $course->id }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Course</button>
    </form>
</body>
</html>
