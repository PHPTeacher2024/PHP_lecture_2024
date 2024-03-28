<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Add post</title>
</head>
<body>
<form action="/add_post.php" method="post">
    <div>
        <label for="title">Title:</label>
        <input name="title" id="title" type="text">
    </div>
    <div>
        <label for="subtitle">Subtitle:</label>
        <input name="subtitle" id="subtitle" type="text">
    </div>
    <div>
        <label for="content">Content:</label>
        <input name="content" id="content" type="text">
    </div>

    <button type="submit">Submit</button>
</form>
</body>
</html>