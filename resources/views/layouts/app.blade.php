<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SGMS</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url({{ asset('img/blu.jpg') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>


</head>

<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            @yield('content');
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SGMS 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/FRONT_END_URL.js') }}"></script>
<script src="{{ asset('js/message-helper.js') }}"></script>
<script src="{{ asset('js/login.js') }}""></script>

</body>

</html>

@if(session('errors'))
    <script>
        var msg = '<?= session('errors') ?>'
        Swal.fire({
            icon: 'error',
            text: msg,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif
