@extends('layouts.main')

@push('style-alt')
<style>
    /* Reduce font size for table body cells */
    #manifest_data tbody td {
        font-size: 16px; /*Adjust the font size as needed*/
        text-align: center;
        padding: 3px;
    }
    
</style>
@endpush

@section('content')
    <!-- Main Content -->
    <div class="hk-pg-wrapper">
        <div class="container-xxl">
            <!-- Page Header -->
            <div class="hk-pg-header pg-header-wth-tab pt-7">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h1 class="pg-title">Data Manifest</h1>
                            <p>Management Pengelolaan Data Manifest CV. Den Logistik</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Page Body -->
            <div class="hk-pg-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="data_order">
                        <div class="row">
                            <div class="col-md-12 mb-md-4 mb-3">
                                <div class="card card-border mb-0 h-100">
                                    <div class="card-header card-header-action">
                                        <h6>List Data Manifest
                                            <span class="badge badge-sm badge-light ms-1">{{ count($manifest) }}</span>
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="manifest-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Manifest</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="manifest_data" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Manifest</th>
                                                        <th>Tanggal</th>
                                                        <th>Plat Mobil</th>
                                                        <th>Total Koli</th>
                                                        <th>Total Berat</th>
                                                        <th>Total Harga</th>
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

            {{-- Modal MANIFEST --}}
            <div class="modal fade" id="manifestModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="manifestHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="manifestForm" enctype="multipart/form-data">
                                <div class="row gx-3">
                                    <input type="hidden" id="order_id" name="order_id">
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Manifest</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="manifest_tanggal"
                                                value="{{ date('Y-m-d') }}" id="manifest_tanggal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Plat Mobil</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Plat Mobil"
                                                name="manifest_plat_mobil" id="manifest_plat_mobil" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Awal Manifest</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="manifest_tanggal_awal"
                                                id="manifest_tanggal_awal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Akhir Manifest</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Tanggal Akhir"
                                                name="manifest_tanggal_akhir" id="manifest_tanggal_akhir" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3 table-responsive" id="data-order">
                                    {{--  --}}
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitManifest">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal DETAIL MANIFEST --}}
            <div class="modal fade" id="detailManifest" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 id="detailManifestHeading"></h6>
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
                                                <label class="form-label mb-xl-0">Tanggal Manifest:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="date" id="detail_manifest_tanggal"
                                                    name="detail_manifest_tanggal" />
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">No. Manifest:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="text" id="detail_manifest_no"
                                                    name="detail_manifest_no" />
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Plat Mobil:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="text"
                                                    id="detail_manifest_plat_mobil" name="detail_manifest_plat_mobil" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Order</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>No Resi</th>
                                                <th>Tanggal</th>
                                                <th>Pengirim</th>
                                                <th>Penerima</th>
                                                <th>Berat</th>
                                                <th>Volume</th>
                                                <th>Isi</th>
                                                <th>Tarif</th>
                                                <th>Total</th>
                                                <th>Status Bayar</th>
                                            </thead>
                                            <tbody id="list-manifest">
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
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Koli
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_manifest_total_koli"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Berat
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_manifest_total_berat"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Volume
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_manifest_total_volume"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-bottom-start border-end-0 bg-primary-light-5">
                                                            <span class="text-dark">Total Harga</span></td>
                                                        <td class="rounded-bottom-end  bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_manifest_total_harga"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-bottom-start border-end-0 bg-primary-light-5">
                                                            <span class="text-dark">Total Yang Harus Di Bayar</span></td>
                                                        <td class="rounded-bottom-end  bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="total_harus_dibayar"></div>
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

            var manifestdata = $('#manifest_data').DataTable({
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
                serverSide: false,
                ajax: "{{ route('manifest.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'manifest_no',
                        name: 'manifest_no'
                    },
                    {
                        data: 'manifest_tanggal',
                        name: 'manifest_tanggal'
                    },
                    {
                        data: 'manifest_plat_mobil',
                        name: 'manifest_plat_mobil'
                    },
                    {
                        data: 'manifest_total_koli',
                        name: 'manifest_total_koli'
                    },
                    {
                        data: 'manifest_total_berat',
                        name: 'manifest_total_berat'
                    },
                    {
                        data: 'manifest_total_harga',
                        name: 'manifest_total_harga'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
            });

            // Create Data Order.
            $('#manifest-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-manifest");
                $('#order_id').val('');
                $('#manifestForm').trigger("reset");
                $('#manifestHeading').html("TAMBAH DATA MANIFEST BARU");
                $('#manifestModal').modal('show');

                $('#data-order').html('')
            });

            // Get order data based on tanggal
            $('body').on('input', '#manifest_tanggal_awal, #manifest_tanggal_akhir', function() {
                var tanggal_awal = $('#manifest_tanggal_awal').val()
                var tanggal_akhir = $('#manifest_tanggal_akhir').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('get.order.data') }}",
                    data: {
                        manifest_tanggal_awal: tanggal_awal,
                        manifest_tanggal_akhir: tanggal_akhir,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response.error)
                        console.log(response.hasOwnProperty('error'))

                        if (response.error) {
                            // Display the error message using Swal.fire
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.error,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#data-order').html('')
                            var table = `<h6>No Data Avalilable</h6>`;
                            $('#data-order').html(table)
                            console.log(response.error)
                        } else {
                            if (response.length > 0) {
                                var table = `<h6>Data Order</h6>
                                            <div style="max-height:300px; overflow-y: scroll;">
                                                <table id="order-data" class="table nowrap table-striped" style="width:100%">
                                                    <thead>
                                                        <th></th>
                                                        <th>No</th>
                                                        <th>No Resi</th>
                                                        <th>Tanggal</th>
                                                        <th>Pengirim</th>
                                                        <th>Penerima</th>
                                                        <th>Koli</th>
                                                        <th>Berat</th>
                                                        <th>Tarif</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody id="list-order">
                                                        {{-- List Barang Selected --}}
                                                    </tbody>
                                                </table>
                                            </div>`;

                                var listorder = '';
                                var no = 1;
                                // LOOPING BARANG
                                $.each(response, function(index, value) {
                                    var select           = '<input type="checkbox" class="row-checkbox form-check-input is-valid" value="' + value['order_id'] + '" name="order_id[]" checked>';
                                    const order_id       = value['order_id']
                                    const order_noresi   = value['order_noresi']
                                    const order_tanggal  = value['order_tanggal']
                                    const order_pengirim = value['order_pengirim']
                                    const order_penerima = value['order_penerima']
                                    const order_koli     = value['order_koli']
                                    const order_berat    = value['order_berat']
                                    const order_tarif    = value['order_tarif']
                                    const order_total    = value['order_total']

                                    listorder += `<tr>
                                                        <td>` + select + `</td>
                                                        <td>` + no++ + `</td>
                                                        <td>` + order_noresi + `</td>
                                                        <td>` + order_tanggal + `</td>
                                                        <td>` + order_pengirim + `</td>
                                                        <td>` + order_penerima + `</td>
                                                        <td>` + order_koli + `</td>
                                                        <td>` + order_berat + `</td>
                                                        <td>` + rupiah(order_tarif) + `</td>
                                                        <td>` + rupiah(order_total) + `</td>
                                                    </tr>`;

                                });
                                $('#data-order').html(table)
                                $("#list-order").html(listorder)

                            } else {
                                var table = `<h6>No Data Avalilable</h6>`;
                                $('#data-order').html(table)
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors here if needed
                        console.log(xhr.responseText);
                    }
                });

            })

            // Stored Data Order.
            $('#submitManifest').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('manifest.store') }}",
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
                            $('#submitManifest').html('Simpan');

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

                            $('#manifestForm').trigger("reset");
                            $('#submitManifest').html('Simpan');
                            $('#manifestModal').modal('hide');
                            manifestdata.draw();
                            setInterval(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                });
            });

            // Detail Manifest
            $('body').on('click', '#detail-manifest', function() {
                $('.alert').hide();
                $('#saveBtn').val("detail-manifest");
                $('#manifestForm').trigger("reset");
                $('#detailManifestHeading').html("DETAIL DATA MANIFEST");
                $('#detailManifest').modal('show');

                var manifest_id = $(this).attr('data-id');
                console.log(manifest_id)
                $.ajax({
                    type: "POST",
                    url: "{{ route('manifest.detail') }}",
                    data: {
                        manifest_id: manifest_id,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        var manifest_no           = response.manifest.manifest_no
                        var manifest_tanggal      = response.manifest.manifest_tanggal
                        var manifest_plat_mobil   = response.manifest.manifest_plat_mobil
                        var manifest_total_koli   = response.manifest.manifest_total_koli
                        var manifest_total_berat  = response.manifest.manifest_total_berat
                        var manifest_total_volume = response.manifest.manifest_total_volume
                        var manifest_total_harga  = response.manifest.manifest_total_harga
                        var total_harus_dibayar   = response.sumOrderTotal

                        $("#detail_manifest_tanggal").val(manifest_tanggal).prop('readonly',true)
                        $("#detail_manifest_no").val(manifest_no).prop('readonly', true)
                        $("#detail_manifest_plat_mobil").val(manifest_plat_mobil).prop('readonly', true)
                        $("#detail_manifest_total_koli").html(manifest_total_koli)
                        $("#detail_manifest_total_berat").html(manifest_total_berat+'Kg')
                        $("#detail_manifest_total_volume").html(manifest_total_volume)
                        $("#detail_manifest_total_harga").html(rupiah(manifest_total_harga))
                        $("#total_harus_dibayar").html(rupiah(total_harus_dibayar))

                        var listmanifest = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.manifest.detailmanifest, function(index, value) {
                            const order_id       = value.order['order_id']
                            const order_noresi   = value.order['order_noresi']
                            const order_tanggal  = value.order['order_tanggal']
                            const order_pengirim = value.order['order_pengirim']
                            const order_penerima = value.order['order_penerima']
                            const order_koli     = value.order['order_koli']
                            const order_isi      = value.order['order_isi']
                            const order_volume   = value.order['order_volume']
                            const order_berat    = value.order['order_berat']
                            const order_tarif    = value.order['order_tarif']
                            const order_total    = value.order['order_total']

                            const payment_status = value.order.payment['payment_status']
                            // Validate Badge Status Payment
                            if(value.order.payment['payment_status'] == 'lunas'){
                                var status = '<div class="badge bg-success">' + payment_status.toUpperCase() + '</div>'
                            }else{
                                var status = '<div class="badge bg-danger">' + payment_status.toUpperCase() + '</div>'
                            }
                            
                            listmanifest += `<tr>
                                                <td>` + no++ + `</td>
                                                <td>` + order_noresi + `</td>
                                                <td>` + order_tanggal + `</td>
                                                <td>` + order_pengirim + `</td>
                                                <td>` + order_penerima + `</td>
                                                <td>` + order_berat + `</td>
                                                <td>` + order_volume + `</td>
                                                <td>` + order_isi + `</td>
                                                <td>` + rupiah(order_tarif) + `</td>
                                                <td>` + rupiah(order_total) + `</td>
                                                <td>` + status + `</td>
                                            </tr>`;

                        });
                        $("#list-manifest").html(listmanifest)
                    }
                });
            })

            // Print Manifest
            $('body').on('click', '#manifest-print', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var manifest_id  = $(this).attr('data-id')

                swalWithBootstrapButtons
                    .fire({
                        title: "Apakah kamu ingin mencetak manifest?",
                        text: "Manifest akan dicetak!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "me-2",
                        cancelButtonText: "Tidak",
                        confirmButtonText: "Ya",
                        reverseButtons: true,
                    })
                    .then((result) => {
                        if (result.value) {

                            // Create the URL with query parameters
                            var url = "{{ route('manifest.print') }}?manifest_id=" + manifest_id;

                            // Open the PDF in a new tab/window
                            window.open(url, '_blank');

                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

        })
    </script>
@endpush
