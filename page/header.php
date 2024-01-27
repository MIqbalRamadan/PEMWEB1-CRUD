<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Tambahkan pustaka-pustaka Excel dan PDF -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>


    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card-header {
            background-color: #28a745;
            color: #fff;
            font-size: 1.5rem;
        }

        .card-body {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        #newsChart {
            margin-top: 20px;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dashboard &mdash; Kakasualan</title>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-info">
        <a class="navbar-brand text-white" href="#" onclick="dashboard()">Manajemen Data Pengguna</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="nabarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="tambahdata()">Tambah Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="keloladata()">Kelola Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>
        function dashboard() {
            window.location.href = 'index.php';
        }

        function keloladata() {
            window.location.href = 'kelola.php';
        }

        function tambahdata() {
            window.location.href = 'tambah.php';
        }

        function logout() {

            const sessionToken = localStorage.getItem('session_token');

            localStorage.removeItem('nama');

            const formData = new FormData();
            formData.append('session_token', sessionToken);

            axios.post('https://kakasualanstore.000webhostapp.com/logout.php', formData).then(response => {

                    if (response.data.status == 'success') {
                        localStorage.removeItem('nama');
                        localStorage.removeItem('session_token');
                        window.location.href = 'login.php';
                    } else {
                        alert('Logout failed. Please try again');
                    }
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                });
        }
    </script>
</body>

</html>