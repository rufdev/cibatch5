<?= $this->extend('template/admin_template') ?>

<?= $this->section('contentarea') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Ticket Management</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="clearform()">
                    Add Ticket
                </button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>STATE</th>
                            <th>SEVERITY</th>
                            <th>FULL NAME</th>
                            <th>OFFICE</th>
                            <th>DESCRIPTION</th>
                            <th>CREATED AT</th>
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
                        <h4 class="modal-title">Ticket Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            <div class="card-body">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid first name.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid last name.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid email.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="office_id">Office</label>
                                    <select class="form-control" id="office_id" name="office_id" required>
                                        <option value="">Select Office</option>
                                        <?php foreach ($offices as $office) : ?>
                                            <option value="<?= $office['id'] ?>"><?= $office['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="severity">Severity</label>
                                    <select class="form-control" id="severity" name="severity" required>
                                        <option value="">Select Severity</option>
                                        <option value="LOW">LOW</option>
                                        <option value="MEDIUM">MEDIUM</option>
                                        <option value="HIGH">HIGH</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="5" name="description" required>
                                    </textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office.
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

                if (!formdata.id) {
                    $.ajax({
                        url: "<?= base_url('tickets'); ?>",
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
                            clearform();
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
                } else {
                    $.ajax({
                        url: "<?= base_url('tickets'); ?>/" + formdata.id,
                        type: "PUT",
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
                            clearform();
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
            url: "<?= base_url('tickets/list'); ?>",
            type: "POST"
        },
        columns: [{
                data: "id",
            },
            {
                data: "state",
            },
            {
                data: "severity",
            },
            {
                data: "full_name",
            },
            {
                data: "office_name",
            },
            {
                data: "description",
            },
            {
                data: "created_at",
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

    $(document).on('click', '#deleteBtn', function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                url: "<?= base_url('tickets'); ?>/" + id,
                type: "DELETE",
                success: function(response) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Success',
                        body: JSON.stringify(response.message),
                        autohide: true,
                        delay: 3000
                    });
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
            })
        }


    });


    $(document).on('click', '#editBtn', function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        $.ajax({
            url: "<?= base_url('tickets'); ?>/" + id,
            type: "GET",
            success: function(response) {
                $('#modalID').modal('show');
                $("#id").val(response.id);
                $("#first_name").val(response.first_name);
                $("#last_name").val(response.last_name);
                $("#email").val(response.email);
                $("#office_id").val(response.office_id);
                $("#severity").val(response.severity);
                $("#description").val(response.description);
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
        })

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

    function clearform() {
        $("#id").val("");
        $("#first_name").val("");
        $("#last_name").val("");
        $("#email").val("");
        $("#office_id").val("");
        $("#severity").val("");
        $("#description").val("");
    }
</script>
<?= $this->endSection() ?>