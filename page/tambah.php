<?php
include('header.php');
include('check_session.php');
?>

<div class="container mt-5">
    <h2 class="mb-4">Add News Form</h2>

    <form id="addNewsForm">
        <div class="form group">
            <label for="judul">Title:</label>
            <input type="text" class="form-control" maxlength="50" id="judul" name="judul" required>
        </div>

        <div class="form group">
            <label for="deskripsi">Content:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
        </div>

        <div class="form group">
            <label for="url_image">Image:</label>
            <input type="file" class="form-control-file" id="url_image" name="url_image" accept="image/*" required>
        </div>

        <button type="button" class="btn btn-primary" onclick="addNews()">Add News</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function addNews() {

            const judul = document.getElementById('judul').value;
            const deskripsi = document.getElementById('deskripsi').value;
            const urlImageInput = document.getElementById('url_image');
            const url_image = urlImageInput.files[0];
            const tanggal = new Date().toISOString().split('T')[0];

            var formData = new FormData();
            formData.append('judul', judul);
            formData.append('deskripsi', deskripsi);
            formData.append('url_image', url_image);
            formData.append('tanggal', tanggal);

            axios.post('https://kakasualanstore.000webhostapp.com/addnews.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(function(response) {
                console.log(response.data);
                console.log(formData);
                alert(response.data);
                document.getElementById('addNewsForm').reset();
            })
                .catch(function(error) {
                    console.error(error);
                    alert('Error adding news');
                });
        }
    </script>