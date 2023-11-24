<?= $this->extend('template/admin_template') ?>

<?= $this->section('contentarea') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Office Management</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalID">
                    Add Office
                </button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>OFFICE ID</th>
                            <th>CODE</th>
                            <th>NAME</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<script>
    let table = $("#dataTable").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: true,
        lengthMenu: [5,10,20,50],
        searching: true,
        ordering: true,
        info: true,
        autoWidth:false,
        ajax : {
            url: "<?= base_url('offices/list'); ?>",
            type: "POST"
        },
        columns : [{
                data: "id",
            },
            {
                data: "code",
            },
            {
                data: "name",
            },
            { 
                data: "",
                defaultContent: `
                    <td>
                    <button type="button" class="btn btn-warning btn-sm" id="editBtn">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteBtn">Delete</button>
                    </td>
                `
            }
        ]


    });

</script>
<?= $this->endSection() ?>