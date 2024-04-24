<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Успешная регистрация</title>
</head>
<body>
<div style="text-align: center;">
    <h1>Успешная регистрация!</h1>
    <p>Вы будете перенаправлены на другую страницу через 3 секунды...</p>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 3000);
</script>
</body>
</html>
