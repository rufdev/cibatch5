<?= $this->extend('template/admin_template') ?>

<?= $this->section('contentarea') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mb-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-6 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $totaloffices ?></h3>

                        <p>Total Offices</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $totaltickets ?></h3>

                        <p>Total Tickets</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <!-- BAR CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Bar Chart</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <!-- BAR CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Bar Chart 2</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>

    <?= $this->section('pagescript'); ?>
    <script>
        $(function() {
            let barChartCanvas = $('#barChart').get(0).getContext('2d');
            let barchartdata = <?= json_encode($barchartdata) ?>;
           
            let barChartData = {
                labels: barchartdata.map(function(item) {
                    return item.office_name;
                }),
                datasets: [{
                    label: "Total Tickets",
                    backgroundColor: "#28a745",
                    borderColor: "#28a745",
                    borderWidth: 1,
                    data: barchartdata.map(function(item) {
                        return item.ticket_count;
                    }),
                }]
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });


            let barChart2Canvas = $('#barChart2').get(0).getContext('2d');
            let barchart2data = <?= json_encode($barchart2data) ?>;
           
            let barChart2Data = {
                labels: barchart2data.map(function(item) {
                    return item.severity;
                }),
                datasets: [{
                    label: "Total Tickets",
                    backgroundColor: "#28a745",
                    borderColor: "#28a745",
                    borderWidth: 1,
                    data: barchart2data.map(function(item) {
                        return item.ticket_count;
                    }),
                }]
            }

            new Chart(barChart2Canvas, {
                type: 'bar',
                data: barChart2Data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });

        });
    </script>
    <?= $this->endSection(); ?>