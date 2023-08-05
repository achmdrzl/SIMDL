@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div class="hk-pg-wrapper">
        <div class="container-xxl">
            <!-- Page Header -->
            <div class="hk-pg-header pg-header-wth-tab pt-7">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h1 class="pg-title">Data Pengeluaran</h1>
                            <p>Management Pengelolaan Data Pengeluaran CV. Den Logistik</p>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-line nav-light nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pengeluaran_group">
                            <span class="nav-link-text">Data Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pengeluaran_single">
                            <span class="nav-link-text">Tambah Pengeluaran</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /Page Header -->

            <!-- Page Body -->
            <div class="hk-pg-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pengeluaran_group">
                        <div class="row">
                            <div class="col-md-12 mb-md-4 mb-3">
                                <div class="card card-border mb-0 h-100">
                                    <div class="card-header card-header-action">
                                        <h6>List Data Pengeluaran
                                            <span class="badge badge-sm badge-light ms-1">{{ count($pengeluaran) }}</span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="pengeluaran_data" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Bulan</th>
                                                        <th>Tahun</th>
                                                        <th>Total Pengeluaran</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="pengeluaran_single">
                        <div class="row">
                            <div class="col-md-12 mb-md-4 mb-3">
                                <div class="card card-border mb-0 h-100">
                                    <div class="card-header card-header-action">
                                        <h6>List Data Order</h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="pengeluaran-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah Pengeluaran</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="pengeluaran_day" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Total</th>
                                                        <th>Jenis Pengeluaran</th>
                                                        <th>Keterangan</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Body -->

            {{-- Modal Order --}}
            <div class="modal fade" id="pengeluaranModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="pengeluaranHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="pengeluaranForm">
                                <div class="row gx-3">
                                    <input type="hidden" id="pengeluaran_id" name="pengeluaran_id">
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="pengeluaran_tanggal"
                                                value="{{ date('Y-m-d') }}" id="pengeluaran_tanggal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Total Pengeluaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Masukkan Total Pengeluaran"
                                                name="pengeluaran_total" id="pengeluaran_total" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Jenis Pengeluaran</label>
                                       <div class="form-group">
                                            <textarea class="form-control" name="pengeluaran_jenis" id="pengeluaran_jenis"
                                                placeholder="Masukkan Jenis Pengeluaran"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Keterangan</label>
                                       <div class="form-group">
                                            <textarea class="form-control" name="pengeluaran_keterangan" id="pengeluaran_keterangan"
                                                placeholder="Masukkan Keterangan Pengeluaran"></textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitPengeluaran">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal DETAIL PENGELUARAN --}}
            <div class="modal fade" id="detailPengeluaran" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 id="detailPengeluaranHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="penjualanreturnForm">
                            <div class="modal-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    style="display: none;" style="color: red"></div>
                                <div class="row">
                                    <div class="col-md p-2 bg-grey-light-5 rounded">
                                        <div class="row align-items-center">
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Bulan:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="text" id="detail_pengeluaran_month" name="detail_pengeluaran_month" />
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Tahun:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="text" id="detail_pengeluaran_year" name="detail_pengeluaran_year" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Pengeluaran</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Jenis Pengeluaran</th>
                                                <th>Keterangan</th>
                                            </thead>
                                            <tbody id="list-pengeluaran">
                                                {{-- List Order Manifest --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-xxl-8">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-bordered subtotal-table">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-bottom-start border-end-0 bg-primary-light-5">
                                                            <span class="text-dark">Grand Harga</span></td>
                                                        <td class="rounded-bottom-end  bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_total_pengeluaran"></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer align-items-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Page Footer -->
            @include('layouts.footer')
        <!-- / Page Footer -->

    </div>
    <!-- /Main Content -->
@endsection

@push('script-alt')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // FORMAT CURRENCY
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            }

            var pengeluaran_data = $('#pengeluaran_data').DataTable({
                scrollX: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                    sLengthMenu: "_MENU_item",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                        previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
                    }
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass(
                        'custom-pagination pagination-simple');
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengeluaran.index') }}",
                columns: [{
                        data: 'DT_RowIndex', // Add the DT_RowIndex column for row index
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'pengeluaran_month',
                        name: 'pengeluaran_month'
                    },
                    {
                        data: 'pengeluaran_year',
                        name: 'pengeluaran_year'
                    },
                    {
                        data: 'total_pengeluaran',
                        name: 'total_pengeluaran'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
            });

            var pengeluaran_day = $('#pengeluaran_day').DataTable({
                scrollX: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                    sLengthMenu: "_MENU_item",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                        previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
                    }
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass(
                        'custom-pagination pagination-simple');
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengeluaran.day') }}",
                columns: [{
                        data: 'index',
                        name: 'index'
                    },
                    {
                        data: 'pengeluaran_tanggal',
                        name: 'pengeluaran_tanggal'
                    },
                    {
                        data: 'pengeluaran_total',
                        name: 'pengeluaran_total'
                    },
                    {
                        data: 'pengeluaran_jenis',
                        name: 'pengeluaran_jenis'
                    },
                    {
                        data: 'pengeluaran_keterangan',
                        name: 'pengeluaran_keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
            });

            // Create Data Order.
            $('#pengeluaran-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#pengeluaran_id').val('');
                $('#pengeluaranForm').trigger("reset");
                $('#pengeluaranHeading').html("TAMBAH DATA PENGELUARAN BARU");
                $('#pengeluaranModal').modal('show');
                
                $('#pengeluaran_total').val('')
                $('#pengeluaran_jenis').val('')
                $('#pengeluaran_keterangan').val('')
            });

            // Stored Data Order.
            $('#submitPengeluaran').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('pengeluaran.store') }}",
                    data: new FormData(this.form),
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: "POST",

                    success: function(response) {
                        console.log(response)
                        if (response.errors) {
                            $('.alert').html('');
                            $.each(response.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });
                            $('#submitPengeluaran').html('Simpan');

                        } else {
                            $('.btn-warning').hide();

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                            });

                            Toast.fire({
                                icon: 'success',
                                title: `${response.message}`,
                            })

                            $('#pengeluaranForm').trigger("reset");
                            $('#submitPengeluaran').html('Simpan');
                            $('#pengeluaranModal').modal('hide');

                            pengeluaran_data.draw();
                            pengeluaran_day.draw();
                        }
                    }
                });
            });

            // Edit Pengeluaran
            $('body').on('click', '#pengeluaran-edit', function(){
                var pengeluaran_id  = $(this).attr('data-id')

                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#pengeluaran_id').val(pengeluaran_id);
                $('#pengeluaranForm').trigger("reset");
                $('#pengeluaranHeading').html("EDIT DATA PENGELUARAN");
                $('#pengeluaranModal').modal('show');

                $.ajax({
                    type: "POST",
                    url: "{{ route('pengeluaran.edit') }}",
                    data: {
                        pengeluaran_id: pengeluaran_id,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response)
                        var pengeluaran_tanggal    = response.pengeluaran_tanggal 
                        var pengeluaran_total      = response.pengeluaran_total 
                        var pengeluaran_jenis      = response.pengeluaran_jenis 
                        var pengeluaran_keterangan = response.pengeluaran_keterangan 
                        
                        $('#pengeluaran_tanggal').val(pengeluaran_tanggal)
                        $('#pengeluaran_total').val(pengeluaran_total)
                        $('#pengeluaran_jenis').val(pengeluaran_jenis)
                        $('#pengeluaran_keterangan').val(pengeluaran_keterangan)
                    }
                });
            })

            // Detail order
            $('body').on('click', '#btn-detail', function() {
                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#orderHeading').html("DETAIL DATA ORDER");
                $('#orderModal').modal('show');

                var order_id = $(this).attr('data-id');
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('order.detail') }}",
                    data: {
                        order_id: order_id,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        // hidden method
                        $('#method').prop('hidden', true)

                        var order_id              = response.order_id
                        var order_tanggal         = response.order_tanggal
                        var order_pengirim        = response.order_pengirim
                        var order_penerima        = response.order_penerima
                        var order_alamat_penerima = response.order_alamat_penerima
                        var order_koli            = response.order_koli
                        var order_kemasan         = response.order_kemasan
                        var order_rincian         = response.order_rincian
                        var order_berat           = response.order_berat
                        var order_volume          = response.order_volume
                        var order_isi             = response.order_isi
                        var order_tarif           = response.order_tarif
                        var order_total           = response.order_total
                        var payment_keterangan    = response.payment.payment_keterangan
                        var payment_status        = response.payment.payment_status
                        var payment_tanggal       = response.payment.payment_tanggal
                        var payment_acc           = response.payment.user_acc.name
                        
                        $('#order_tanggal').val(order_tanggal).prop('readonly', true)
                        $('#order_pengirim').val(order_pengirim).prop('readonly', true)
                        $('#order_penerima').val(order_penerima).prop('readonly', true)
                        $('#order_alamat_penerima').val(order_alamat_penerima).prop('readonly', true)
                        $('#order_koli').val(order_koli).prop('readonly', true)
                        $('#order_kemasan').val(order_kemasan).prop('readonly', true)
                        $('#order_rincian').val(order_rincian).prop('readonly', true)
                        $('#order_berat').val(order_berat).prop('readonly', true)
                        $('#order_volume').val(order_volume).prop('readonly', true)
                        $('#order_isi').val(order_isi).prop('readonly', true)
                        $('#order_tarif').val(order_tarif).prop('readonly', true)
                        $('#order_total').val(order_total).prop('readonly', true)
                        $('#payment_keterangan').val(payment_keterangan).prop('readonly', true)

                        if(payment_status == 'settlement'){
                            var button   = `<div class="col-sm-6">
                                                <label class="form-label">Tanggal Pembayaran</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="date" placeholder="Masukkan Jumlah Koli"
                                                        name="payment_tanggal" id="payment_tanggal" value=`+ payment_tanggal +` readonly />
                                            </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Validasi Pembyaran Oleh:</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="Masukkan Jenis Kemasan" name="payment_acc"
                                                        id="payment_acc" value=`+ payment_acc +` readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">Bukti Pembayaran</label>
                                                <div class="form-group">
                                                    <a href="download/image/` + order_id + `" class="btn btn-primary" id="buktiBayar" target="_blank" download>Download Bukti</a>
                                                </div>
                                            </div>`;

                            $('#codInputs').html(button)
                        }else{
                            $('#codInputs').html('')
                        }

                    }
                });

            })

            // Arsipkan Data Pengeluaran
            $('body').on('click', '#pengeluaran-delete', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var pengeluaran_id = $(this).attr('data-id');

                swalWithBootstrapButtons
                    .fire({
                        title: "Do you want to delete, this data?",
                        text: "This data will be deleted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "me-2",
                        cancelButtonText: "Tidak",
                        confirmButtonText: "Ya",
                        reverseButtons: true,
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('pengeluaran.destroy') }}",
                                data: {
                                    pengeluaran_id: pengeluaran_id,
                                },
                                dataType: "json",
                                success: function(response) {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                    });

                                    Toast.fire({
                                        icon: 'success',
                                        title: `${response.status}`,
                                    })
                                    pengeluaran_data.draw();
                                    pengeluaran_day.draw();
                                }
                            });
                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

            // Detail Pengeluaran
            $('body').on('click', '#pengeluaran-detail', function(){
                var month   = $(this).attr('data-month')
                var year    = $(this).attr('data-year')
                var total   = $(this).attr('data-total')
                
                $('.alert').hide();
                $('#saveBtn').val("detail-manifest");
                $('#manifestForm').trigger("reset");
                $('#detailPengeluaranHeading').html("DETAIL DATA PENGELUARAN");
                $('#detailPengeluaran').modal('show');

                $.ajax({
                    type: "POST",
                    url: "{{ route('pengeluaran.detail') }}",
                    data: {
                        month: month,
                        year: year,
                        total: total,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response)
                        var months   = response.month
                        var year     = response.year
                        var total    = response.total

                        var month    = ''
                        
                        if (months == 1) {
                            month = 'Januari';
                        } else if (months == 2) {
                            month = 'Februari';
                        } else if (months == 3) {
                            month = 'Maret';
                        } else if (months == 4) {
                            month = 'April';
                        } else if (months == 5) {
                            month = 'Mei';
                        } else if (months == 6) {
                            month = 'Juni';
                        } else if (months == 7) {
                            month = 'Juli';
                        } else if (months == 8) {
                            month = 'Agustus';
                        } else if (months == 9) {
                            month = 'September';
                        } else if (months == 10) {
                            month = 'Oktober';
                        } else if (months == 11) {
                            month = 'November';
                        } else {
                            month = 'Desember';
                        }

                        $('#detail_pengeluaran_month').val(month).prop('readonly', true)
                        $('#detail_pengeluaran_year').val(year).prop('readonly', true)
                        $('#detail_total_pengeluaran').html(rupiah(total))

                        var listpengeluaran = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.data, function(index, value) {
                            const pengeluaran_id          = value['pengeluaran_id']
                            const pengeluaran_tanggal     = value['pengeluaran_tanggal']
                            const pengeluaran_total       = value['pengeluaran_total']
                            const pengeluaran_jenis       = value['pengeluaran_jenis']
                            const pengeluaran_keterangan  = value['pengeluaran_keterangan']

                            listpengeluaran += `<tr>
                                                    <td>` + no++ + `</td>
                                                    <td>` + pengeluaran_tanggal + `</td>
                                                    <td>` + rupiah(pengeluaran_total) + `</td>
                                                    <td>` + pengeluaran_jenis + `</td>
                                                    <td>` + pengeluaran_keterangan + `</td>
                                                </tr>`;

                        });

                        $("#list-pengeluaran").html(listpengeluaran)
                    }
                });
            })

            // Print Pengeluaran
            $('body').on('click', '#pengeluaran-print', function(){
                var selectedMonth = $(this).attr('data-month');
                var selectedYear = $(this).attr('data-year');

                // Create an object with month and year properties
                var data = { 'selectedMonth': selectedMonth, 'selectedYear': selectedYear };

                // Serialize the object into query parameters
                var queryParams = $.param(data);

                // Create the URL with query parameters
                var url = "{{ route('pengeluaran.print') }}?" + queryParams;

                // Open the PDF in a new tab/window
                window.open(url, '_blank');

            })
        })
    </script>
@endpush
