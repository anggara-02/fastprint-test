<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= SITE_NAME ."| Fast Print" ?></title>

    <link rel="stylesheet" href="<?= base_url('resources/assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('resources/assets/modules/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('resources/assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

</head>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());

gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!--  Navbar Here -->
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                </form>
            </nav>
            <!-- End Navbar -->

            <!-- Sidebar Here -->
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="#">Tes Programmer</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="#">St</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="dropdown active">
                            <a href="#" class="nav-link has-dropdown"><i
                                    class="fas fa-fire"></i><span>Dashboard</span></a>
                            <ul class="dropdown-menu">
                                <li class="nav_link active"><a class="nav-link" href="#">List Produk</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="main-content">
                <section class="section contens">
                    <div class="konten">
                        <div class="section-header">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">

                                    <!-- Flash Data  -->
                                    <!-- <?php if ($this->session->flashdata('success')) {$success = $this->session->flashdata('success'); $gagal = $this->session->flashdata('error');?> -->
                                    <div class="col-sm-12 control-label action_message" id="action_message">
                                        <div
                                            class="callout mb-1 <?= ($this->session->flashdata('status')=='200')?'callout-success':'callout-danger'; ?>">
                                            <div style="text-align:left;" class="message">
                                                Deleted!
                                                <?= $success ? $success : $gagal; ?></div>
                                        </div>
                                    </div>
                                    <!-- <?php } ?> -->
                                    <!-- End Flash Data  -->

                                    <div class="card-header">
                                        <h4>List Produk</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert action_message alert-warning alert-dismissible fade show"
                                            role="alert">
                                            <strong>Holy guacamole!</strong> You should check in on some of those fields
                                            below.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-info">Add Produk</button>
                                        </div>
                                        <table id="datatable" class="table display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Produk</th>
                                                    <th>Kategori</th>
                                                    <th>Harga</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; <?= date('Y')?> | Bima Anggara Putra
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        loadData();
        setTimeout(function() {
            $('.action_message').hide();
            $('.action_message').find('.message').html('');
        }, 2000);
    })

    function loadData() {
        $('#datatable').DataTable({
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
            $("#datatable th").removeClass("sorting_asc");
        }, 1000);
    }

    function swal_alert(id) {
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
    </script>
</body>

</html>