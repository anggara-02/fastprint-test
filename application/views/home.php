<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

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
                            <button class="btn btn-warning" type="button">Syncron Produk</button>
                        </div>
                        <div class="col-md-6" style="text-align:end;">
                            <!-- <button class="btn btn-primary" type="button">Add Produk</button> -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal_add_produk" data-bs-whatever="Add Produk">Add Produk</button>
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


    <!-- Model Add Produk -->
    <div class="modal fade" id="modal_add_produk" tabindex="-1" aria-labelledby="modal_add_produkLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_add_produkLabel">Add New Produk </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="recipient_name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Kategori Produk</label>
                            <input type="text" type="text" class="form-control" id="kategori">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Model Edit Produk -->
    <div class="modal fade" id="modal_edit_produk" tabindex="-1" aria-labelledby="modal_edit_produkLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_edit_produkLabel">Edit Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk_edit">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Kategori Produk</label>
                            <select class="form-select" aria-label="Default select example" id="kategori_edit"></select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Harga</label>
                            <input type="text" name="harga" id="harga_edit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" id="status">
                                <!-- <option selected>- Pilih Status -</option>
                                <option value="1">Dijual</option>
                                <option value="2">Tidak Dijual</option> -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
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


    <script t ype="text/javascript">
    $(document).ready(function() {
        loadData();
        setTimeout(function() {
            // Fadeto(s) untuk durasi lamanya alert, slideup(kecepatan alert hide)
            $("#alert_message").fadeTo(2000, 1).slideUp(1000);
        });
    })

    function loadData() {
        $('#_data').DataTable({
            processing: true,
            serveside: true,
            searching: false,
            aoColumnDefs: [{
                "bSortable": false,
                "aTargets": ["_all"],
                "orderable": false
            }],
            'ajax': {
                url: '<?= base_url('home/get_datatable')?>',
                type: 'POST',
                dataTYpe: 'json'
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
        setTimeout(function() {
            $("#_data th").removeClass("sorting_asc");
        }, 1000);
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
        $.ajax({
            url: '<?= base_url('home/get_by_id') ?>',
            method: 'POST',
            data: {
                id_produk: id
            },
            dataType: 'JSON',
            success: function(res) {
                if (res.status == 200) {
                    console.log(res);

                    let html = '<option value="0">- Pilih Status -</option>';
                    res.kategori.data.forEach(data => {
                        html += '<option value="' + data.id_kategori +
                            '">' + data.nama_kategori + '</option>';
                    });
                    $('#kategori_edit').append(html);

                    html = '';
                    res.status_produk.data.forEach(data => {
                        html += '<option value="' + data.id_status +
                            '">' + data.status + '</option>';
                    })
                    $('#status').append(html);

                    // Menampilkan modal ambil data dari ajak untuk di edit di form edit
                    $('#modal_edit_produk').modal('show')
                    res.data.forEach(data => {
                        $('#nama_produk_edit').val(data.nama_produk);
                        $('#kategori_edit').val(data.kategori_id);
                        $('#harga_edit').val(data.harga);
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