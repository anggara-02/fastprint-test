<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= SITE_NAME ?></title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container-fluid">
        <div class="content m-4">
            <div class="card">
                <div class="card-header">
                    <h3>List Produk</h3>
                </div>

                <div class="card-body">
                    <!-- Flash data     -->
                    <?php if (isset($_SESSION['status'])) { ;?>
                    <div class="alert <?= ($_SESSION['status'] == 200) ? 'alert-success' : 'alert-danger' ; ?> fade show"
                        role="alert" id="alert_message">
                        <div class="message">
                            <strong><?= $_SESSION['msg'] ;?></strong>.
                        </div>
                    </div>
                    <?php } ;?>
                    <!-- End Flash data     -->

                    <div class="d-flex m-3">
                        <div class="col-md-6">
                            <button class="btn btn-warning" type="button" id="sync_button">Syncron Produk</button>
                            <button class="btn btn-primary" type="button" id="semua_data">Semua Data</button>
                            <button class="btn btn-info" type="button" id="data_terjual">Data Terjual</button>
                            <input type="hidden" name="status_hidden" id="status_data">
                        </div>
                        <div class=" col-md-6" style="text-align:end;">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#_modal" data-bs-whatever="Add Produk" id="add_produk">Add
                                Produk</button>
                        </div>
                    </div>
                    <table id="_data" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Model Edit Produk -->
    <div class="modal fade" id="_modal" tabindex="-1" aria-labelledby="_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="_modalLabel">Edit Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-3">
                    <div class="alert alert-danger fade show" role="alert" id="validation_errors" hidden>
                        <div class="message">
                            <strong class="msg_erros"></strong>.
                        </div>
                    </div>
                    <form style="margin-bottom:50px" id="form_produk">
                        <input type="hidden" name="id" id="id_produk_hidden">
                        <div class="mb-3">
                            <label class="col-form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="">
                            <div class="invalid-feedback msg-invalid"></div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Kategori Produk</label>
                            <select class="form-select kategori" aria-label="Default select example" name="kategori">
                                <option value="0">- Pilih Kategori -</option>
                                <?php foreach ($kategori['data'] as $value) { ?>

                                <option value="<?= $value->id_kategori; ?>"> <?= $value->nama_kategori ?></option>

                                <?php }?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" value="">
                            <div class="invalid-feedback msg-invalid"></div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" id="status">
                                <?php foreach ($status['data'] as $value) { ?>

                                <option value="<?= $value->id_status; ?>"> <?= $value->status ?></option>

                                <?php }?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $("#alert_message").fadeTo(2000, 1).slideUp(
                1000); // Fadeto(s) untuk durasi lamanya alert, slideup(kecepatan alert hide)
        });

        // Tombol update produk pada modal
        $('#sync_button').on('click', function() {
            $.get('<?= base_url('home/store_data') ;?>', // url untuk GET Controller
                function(data, textStatus, jqXHR) { // success callback
                    window.location.reload()
                });
        })

        $('#add_produk').on('click', function() {
            $('#id_produk_hidden').val(0)
        })

        $('#data_terjual').on('click', function() {
            $('#status_data').val(1)
            loadData();
        })

        $('#semua_data').on('click', function() {
            $('#status_data').val(0)
            loadData();
        })

        $('#save').on('click', function(e) {
            e.preventDefault();
            let data;
            let id = $('#id_produk_hidden').val()

            data = {
                nama_produk: $('input[name=nama_produk]').val(),
                harga: $('input[name=harga').val(),
                kategori: $('.kategori').val(),
                status: $('#status').val(),
            };

            if (!id == 0) {
                data.id_produk = id
            }

            $.ajax({
                url: '<?= base_url('home/update_or_save');?>',
                method: 'POST',
                dataType: 'JSON',
                data: data,
                success: function(res) {
                    $('.form-control').removeClass('is-invalid')

                    console.log(res);
                    // Jika code status yang di dapat 200
                    if (res.status == 200) {
                        $('#_modal').modal('hide')
                        window.location.reload();
                    } else {
                        for (let i = 0; i < res.inputerror.length; i++) {
                            $('input[name=' + res.inputerror[i] + ']').addClass(
                                'is-invalid')
                            $('input[name=' + res.inputerror[i] + ']').next().text(res.msg[
                                i])
                        }
                    }
                }
            })
        })

        $('#_modal').on('hidden.bs.modal', function() {
            $('.form-control').removeClass('is-invalid')
            $('#form_produk').trigger('reset')
        });

        loadData();
    })

    function loadData() {
        let status_data = $('#status_data').val();
        console.log(status_data);

        $('#_data').DataTable({
            processing: true,
            serveside: true,
            searching: false,
            bDestroy: true,
            aoColumnDefs: [{
                "bSortable": false,
                "aTargets": ["_all"],
                "orderable": false
            }],
            'ajax': {
                url: '<?= base_url('home/get_datatable')?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    status_data: status_data
                }
            },
            columns: [{
                data: 'no',
                " width": '20px',
                visible: true
            }, {
                data: 'nama_produk',
                visible: true
            }, {
                data: 'kategori',
                visible: true
            }, {
                data: 'harga',
                visible: true
            }, {
                data: 'action',
                width: "100px",
                visible: true
            }, ]
        });
        // setTimeout(function() {
        //     $("#_data th").removeClass("sorting_asc");
        // }, 1000);
    }

    function delete_produk(id) {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data dihapus dan tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "red",
            cancelButtonColor: "grey",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('home/delete_by_id') ;?>',
                    method: 'POST',
                    data: {
                        id_produk: id
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 200) {
                            window.location.reload();
                        }
                    }
                })
            }
        });
    }

    function edit_produk(id) {
        $('.msg-invalid').attr('data-id', id)
        $('#id_produk_hidden').val(id)
        $.ajax({
            url: '<?= base_url('home/get_by_id') ?>',
            method: 'POST',
            data: {
                id_produk: id
            },
            dataType: 'JSON',
            success: function(res) {
                let html = '<option value="0">- Pilih Status -</option>';

                if (res.status == 200) {
                    // Menampilkan modal 
                    $('#_modal').modal('show')

                    // isi tiap field form edit
                    res.data.forEach(data => {
                        $('input[name=nama_produk]').val(data.nama_produk);
                        $('.kategori').val(data.kategori_id);
                        $('input[name=harga]').val(data.harga);
                        $('#status').val(data.status_id);
                    });
                } else {
                    window.location.reload();
                }
            },
        });
    }
    </script>
</body>

</html>