<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<textarea id="target">Paste an image here</textarea>
<script>
  const target = document.getElementById('target');

  target.addEventListener('paste', (e) => {
    e.preventDefault();
    doSomethingWithFiles(e.clipboardData.files);
  });
</script>
</body>
</html>