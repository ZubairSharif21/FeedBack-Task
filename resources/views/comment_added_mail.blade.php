<!DOCTYPE html>
<html>
<head>
    <title>New Comment on Your Question</title>
</head>
<body>
    <p>Hello,</p>
    <p>You have received a new comment on your question: <strong>{{ $questionTitle }}</strong></p>
    <p>Comment by: {{ $commentAuthorName }}</p>
    <p>Comment Link: <a href="{{ $commentLink }}">View Comment</a></p>
</body>
</html>
