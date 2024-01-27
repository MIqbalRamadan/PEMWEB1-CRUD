<?php
include('header.php');
include('check_session.php');
?>

<div class="container mt-5">
    <h2 class="mb-4">List News</h2>

    <table id="newsTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#newsTable').DataTable({
            "processing": true,
            "serverside": true,
            "ajax": function(data, callback, settings) {
                axios.get('https://kakasualanstore.000webhostapp.com/listnews.php', {
                    params: {
                        //key: data.search.value
                        key:""
                    }
                })
                .then(function(response) {
                    console.log(response);
                    response.data.forEach(function(row, index) {
                        row.no = index + 1;
                    });
                    callback({
                        draw: data.draw,
                        recordsTotal:response.data.length,
                        recordsFiltered: response.data.length,
                        data: response.data
                    });
                })
                .catch(function(error) {
                    console.error(error);
                    alert('Error fetching news data.');
                });
            },
            "columns": [{
                "data": "no"
            },
            {
                "data": "title"
            },
            {
                "data": "desc"
            },
            {
                "data": "img",
                "render":function(data, type, row) {
                    return '<img src="' + data + '" alt="Image" style="max-width: 100px; max-height: 100px;">';
                }
            },
            {
                "data": null,
                "render":function(data, type, row) {
                    return '<button class="btn btn-danger btn-sm" onclick="deleteNews(' + row.id + ')">Delete</button>' +
                    ' <form action="edit.php" method="post">' +
                    '<input type ="hidden" name="id" value="' + row.id + '">' +
                    '<button type="submit" class="btn btn-primary btn-sm">Edit</button>' +
                    '</form>';
                }
            }

            ]
        });
    });

    function deleteNews(id) {
        var formData = new FormData();
        formData.append('idnews', id);

        if (confirm("Are you sure you want to delete this news?")) {
            axios.post('https://kakasualanstore.000webhostapp.com/deletenews.php', formData)
            .then(function(response) {
                alert(response.data);

                $('#newsTable').DataTable().ajax.reload();
            })
            .catch(function(error) {
                console.error(error);
                alert('Error deleting news.');
            });
        }
    }
</script>