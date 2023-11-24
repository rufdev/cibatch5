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

        <div class="modal fade" id="modalID">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Office Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid code.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid name.
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<script>
    $(function() {
        $('form').submit(function(e) {
            e.preventDefault();

            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);

            if (this.checkValidity()) {
                //create
                $.ajax({
                    url: "<?= base_url('offices'); ?>",
                    type: "POST",
                    data: jsondata,
                    success: function(response) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Success',
                            body: JSON.stringify(response.message),
                            autohide: true,
                            delay: 3000
                        });
                        $('#modalID').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(response) {
                        let parsedresponse = JSON.parse(response.responseText);
                        
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Error',
                            body: JSON.stringify(parsedresponse.message),
                            autohide: true,
                            delay: 3000
                        });
                    }
                });
            }

        })
    });

    let table = $("#dataTable").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: true,
        lengthMenu: [5, 10, 20, 50],
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        ajax: {
            url: "<?= base_url('offices/list'); ?>",
            type: "POST"
        },
        columns: [{
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

    $(document).ready(function() {
        'use strict';

        let form = $(".needs-validation");
        form.each(function() {
            $(this).on('submit', function(e) {
                if (this.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });
    });
</script>
<?= $this->endSection() ?>