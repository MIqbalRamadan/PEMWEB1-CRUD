<?php
include('header.php');
include('check_session.php');

$id = isset($_POST['id']) ? $_POST['id'] : null;
//echo $id;
?>

<div class="container mt-5">
    <h2 class="mb-4">Add News Form</h2>

    <form class="addNewsForm">
    <input type="hidden" class="form-control" value="<?php echo $id;?>" maxlength="50" id="newsId" name="newsId" required>
        <div class="form-group">
            <label for="judul">Title:</label>
            <input type="text" class="form-control" maxlength="50" id="judul" name="judul" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Content:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
        </div>

        <div class="form-group">
            <label for="url_image">Title:</label>
            <input type="file" class="form-control-file" id="url_image" name="url_image" accept="image/*" required>
        </div>


        <button type="button" class="btn btn-primary" onclick="editNews()">Edit News</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function getData() {
        const newsId = document.getElementById('newsId').value;
        var formData = new FormData();
        formData.append('idnews', newsId);

        axios.post('https://kakasualanstore.000webhostapp.com/selectdata.php', formData)
        .then(function(response) {

            document.getElementById('judul').value = response.data.title;
            document.getElementById('deskripsi').value = response.data.desc;
            console.log(response.data);
        })
        .catch(function(error) {
            console.error(error);
            alert('Error fetching news data.');
        });
    }

    function editNews() {
        const newsId = document.getElementById('newsId').value;
        const judul = document.getElementById('judul').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const urlImageInput = document.getElementById('url_image');
        const url_image = urlImageInput.files[0];
        const tanggal = new Date().toISOString().split('T')[0];

        var formData = new FormData();
        formData.append('idnews', newsId);
        formData.append('judul', judul);
        formData.append('deskripsi', deskripsi);
        formData.append('tanggal', tanggal);

        if (urlImageInput.files.length > 0) {
            formData.append('url_image', url_image);
        } else {
            formData.append('url_image', null);
        }
        axios.post('https://kakasualanstore.000webhostapp.com/editnews.php', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },  
        })
        .then(function(response) {
            console.log(response.data);
            alert(response.data);
            window.location.href = 'kelola.php';
        })
        .catch(function(error) {
            console.error(error);
            alert('Error editing news.');
        });
    }
    window.onload = getData;
</script>