<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Dashboard Admin</title>
</head>
<body>
  <h2>Hello, {{ $dataAdmin->name }}</h2>
  <h1>Selamat Datang di Dashboard Admin</h1>

  <form method="POST" action="{{ url('admin/logout') }}">
    @csrf
    <button class="bg-amber-600 px-2 py-1 cursor-pointer" type="submit">
      Logout
    </button>
  </form>
</body>
</html>