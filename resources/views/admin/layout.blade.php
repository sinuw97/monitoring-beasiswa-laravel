<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title') - Monitoring Beasiswa</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    @include('components.navbar-admin')
    @yield('content')

    @include('components.confirmation-modal')

    <script>
        let formToSubmit = null;

        function showConfirmationModal(event, message) {
            event.preventDefault();
            formToSubmit = event.target;
            if (message) {
                document.getElementById('confirmationMessage').innerText = message;
            }
            document.getElementById('globalConfirmationModal').classList.remove('hidden');
            return false;
        }

        function confirmAction() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
            closeConfirmationModal();
        }

        function closeConfirmationModal() {
            document.getElementById('globalConfirmationModal').classList.add('hidden');
            formToSubmit = null;
        }
    </script>
</body>

</html>
