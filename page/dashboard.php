<?php
include('header.php')
?>

<div class="container">
    <div class="container mt-5">
        <h2 id="welcomeMessage">Selamat Datang di Dashboard</h2>
    </div>

    <div class="row">
        <div class="cold-md-12">
            <button onclick="downloadExcel()" class="btn btn-success mr-2">
                <i class="fas fa-download"></i>Unduh Excel
            </button>
            <button onclick="downloadPDF()" class="btn btn-danger">
                <i class="fas fa-download"></i> Unduh PDF
            </button>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <div class="card bg-success my-4">
                <div class="card-header">
                    Akumulasi Berita
                </div>
                <div class="card-body">
                    <h3 id="jumlahBerita" class="text-dark">
                        <i class="fas fa-newspaper">Loading...</i>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="tahunSelect">Pilih Tahun</label>
            <select class="form-control" id="tahunSelect"></select>
        </div>
    </div>
    <hr>

    <h2 class="text-center">GRAFIK JUMLAH BERITA DALAM 1 TAHUN</h2>
    <div class="row">
        <div class="col-md-12">
            <canvas id="newsChart" width="400" height="200"></canvas>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        function downloadExcel() {
            var selectedYear = document.getElementById('tahunSelect').value;
            fetchData(selectedYear)
                .then(response => {
                    var data = response.data;

                    var ws = XLSX.utils.json_to_sheet(data);

                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "Laporan");

                    XLSX.writeFile(wb, "laporan_excel_" + selectedYear + ".xlsx");
                })
                .catch(error => {
                    console.error('Error fetching data for Excel:', error);
                });
        }

        function downloadPDF() {
            var canvas = document.getElementById('newsChart');

            var imgData = canvas.toDataURL('image/png');

            var selectedYear = document.getElementById('tahunSelect').value;

            var docDefinition = {
                content: [{
                        text: 'Laporan Tahun ' + selectedYear,
                        style: 'header'
                    },
                    {
                        image: imgData,
                        width: 500
                    }
                ],
                style: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10],
                    },
                },
            };

            pdfMake.createPdf(docDefinition).download('laporan_' + selectedYear + '_pdf.pdf');
        }
        </script>
        <script>
            axios.get('https://kakasualanstore.000webhostapp.com/sum_berita.php')
            .then(function(response) {
                var dataJumlahBerita = response.data;

                var jumlahBeritaElement = document.getElementById('jumlahBerita');

                jumlahBeritaElement.innerHTML = `<i class="fas fa-newspaper"></i> Jumlah Berita: ${dataJumlahBerita[0].jumlah_berita}`;
            })
            .catch(function(error) {
                console.error('Error fetching data:', error);
            });


        function fetchData(tahun) {
            var formData = new FormData();
            formData.append('tahun', tahun);

            return axios({
                method: 'post',
                url: 'https://kakasualanstore.000webhostapp.com/sum_berita.php',
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        }

        function createChart(data) {
            var ctx = document.getElementById('newsChart').getContext('2d');

            var existChart = Chart.getChart(ctx);
            if (existChart) {
                existChart.destroy();
            }

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.bulan),
                    datasets: [{
                        label: 'Jumlah Berita',
                        data: data.map(item => item.jumlah_berita),
                        backgroundColor: 'rgba(75, 192, 192, 0, 2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        function populateSelectOptions(data) {
            var selectElement = document.getElementById('tahunSelect');
            data.forEach(item => {
                var option = document.createElement('option');
                option.value = item.tahun;
                option.text = item.tahun;
                selectElement.add(option);
            });

            var lastYear = data[0].tahun;
            document.getElementById('tahunSelect').value = lastYear;

            fetchData(lastYear)
                .then(response => {
                    var chartData = response.data;
                    createChart(chartData);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        document.getElementById('welcomeMessage').innerText = 'Selamat datang ' + localStorage.getItem('nama') + ' Di Dashboard!';

        document.getElementById('tahunSelect').addEventListener('change', function() {
            var selectedYear = this.value;
            fetchData(selectedYear)
                .then(response => {
                    var chartData = response.data;
                    createChart(chartData);
                })
                .catch(error => {
                    console.error('Error fetching data: ', error)
                });
        });

        axios.get('https://kakasualanstore.000webhostapp.com/selecttahun.php')
            .then(response => {
                var tahunData = response.data;
                populateSelectOptions(tahunData);
            })
            .catch(error => {
                console.error('Error fetching tahun data:', error);
            });

        </script>
