@extends('layouts.main')

@push('style-alt')
<style>
    /* Reduce font size for table body cells */
    #order_data tbody td {
        font-size: 16px; /*Adjust the font size as needed*/
        text-align: center;
        padding: 3px;
    }

    .wrap-text {
        max-width: 90px; /* Ganti nilai sesuai dengan kebutuhan */
        word-wrap: break-word; /* Memungkinkan kata-kata untuk wrap ke bawah */
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
                            <h1 class="pg-title">Data Order</h1>
                            <p>Management Pengelolaan Data Order CV. Den Logistik</p>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-line nav-light nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#data_order">
                            <span class="nav-link-text">Data Order</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pembayaran_order">
                            <span class="nav-link-text">Pembayaran Order</span>
                        </a>
                    </li>
                </ul>
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
                                        <h6>List Data Order
                                            <span class="badge badge-sm badge-light ms-1">{{ count($orders) }}</span>
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="order-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Order</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="order_data" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Resi</th>
                                                        {{-- <th>Tanggal</th> --}}
                                                        <th>Pengirim</th>
                                                        <th>Penerima</th>
                                                        {{-- <th>Berat</th>
                                                        <th>Volume</th>
                                                        <th>Tarif</th>
                                                        <th>Total</th> --}}
                                                        <th>Status Bayar</th>
                                                        <th>Status Pengiriman</th>
                                                        <th>Metode Bayar</th>
                                                        {{-- <th>Di Buat</th> --}}
                                                        <th>Di Terima</th>
                                                        {{-- <th>Terima Validasi</th> --}}
                                                        {{-- <th>Bayar Validasi</th> --}}
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p id="total_berat" style="font-size: 18px"></p>
                                    </div>
                                    <div class="card-footer">
                                        <p id="total_volume" style="font-size: 18px"></p>
                                    </div>
                                    <div class="card-footer">
                                        <p id="total_harga" style="font-size: 18px"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="pembayaran_order">
                        <div class="row">
                            <div class="col-md-12 mb-md-4 mb-3">
                                <div class="card card-border mb-0 h-100">
                                    <div class="card-header card-header-action">
                                        <h6>List Data Order</h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="order-validate"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Validasi Pembayaran</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="order_validate" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>No Resi</th>
                                                        <th>Tanggal</th>
                                                        <th>Pengirim</th>
                                                        <th>Penerima</th>
                                                        <th>Total</th>
                                                        <th>Metode Bayar</th>
                                                        <th>Status Bayar</th>
                                                        <th>Status Pengiriman</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Order Data --}}
                                                </tbody>
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
            <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="orderHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="orderForm" enctype="multipart/form-data">
                                <div class="row gx-3">
                                    <input type="hidden" id="order_id" name="order_id">
                                    <div class="col-sm-4">
                                        <label class="form-label">Tanggal</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="order_tanggal"
                                                value="{{ date('Y-m-d') }}" id="order_tanggal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Pengirim</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Pengirim"
                                                name="order_pengirim" id="order_pengirim" />
                                        </div>
                                        <!-- Add a div to display the suggestions as a dropdown -->
                                        <div id="suggestionDropdown" style="display: none;"></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Penerima</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Penerima"
                                                name="order_penerima" id="order_penerima" />
                                            <!-- Add a div to display the suggestions as a dropdown -->
                                            <div id="suggestionDropdown2" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Alamat Penerima</label>
                                        <div class="form-group">
                                            <textarea class="form-control" name="order_alamat_penerima" id="order_alamat_penerima"
                                                placeholder="Masukkan Alamat Penerima"></textarea>
                                            <!-- Add a div to display the suggestions as a dropdown -->
                                            <div id="suggestionDropdown4" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-3">
                                        <label class="form-label">No Hp Penerima</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Masukkan No Hp"
                                                name="order_nohp_penerima" id="order_nohp_penerima" />
                                            <!-- Add a div to display the suggestions as a dropdown -->
                                            <div id="suggestionDropdown3" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Koli</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Masukkan Jumlah Koli"
                                                name="order_koli" id="order_koli" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Kemasan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Jenis Kemasan" name="order_kemasan"
                                                id="order_kemasan" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Rincian</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Jumlah rincian" name="order_rincian"
                                                id="order_rincian" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-3">
                                        <label class="form-label">Isi Barang</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Jumlah isi"
                                                name="order_isi" id="order_isi" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Berat</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number"
                                                placeholder="Masukkan Jumlah berat" name="order_berat"
                                                id="order_berat" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Volume</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Jenis volume" name="order_volume"
                                                id="order_volume" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Tarif</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Jumlah tarif" name="order_tarif"
                                                id="order_tarif" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Total</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number"
                                                placeholder="Masukkan Jumlah berat" name="order_total"
                                                id="order_total" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3" id="method">
                                    <label class="form-label">Metode Pembayaran</label>
                                    {{-- <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" class="form-check-input" id="lunas" name="lunas">
                                            <label class="form-check-label text-muted fs-7" for="logged_in">Bayar Langsung</label>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" class="form-check-input" id="bayar-makassar" name="bayar-makassar">
                                            <label class="form-check-label text-muted fs-7" for="logged_in">Bayar Makassar</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="checkbox" class="form-check-input" id="bayar-surabaya" name="bayar-surabaya">
                                            <label class="form-check-label text-muted fs-7" for="logged_in">Bayar Surabaya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3" id="codInputs">
                                    {{--  --}}
                                </div>
                                <div class="row gx-3">
                                    <input type="hidden" id="payment_tanggal" name="payment_tanggal">
                                    <input type="hidden" id="payment_status" name="payment_status">
                                    <div class="col-sm-4">
                                        <label class="form-label">Kota Transit</label>
                                        <div class="form-group">
                                            <textarea class="form-control" name="payment_keterangan" id="payment_keterangan"
                                                placeholder="Masukkan Kota Transit"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Lampiran</label>
                                        <div class="form-group">
                                            <textarea class="form-control" name="order_lampiran" id="order_lampiran"
                                                placeholder="Masukkan Lampiran Order"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Keterangan</label>
                                        <div class="form-group">
                                            <textarea class="form-control" name="order_keterangan" id="order_keterangan"
                                                placeholder="Masukkan Keterangan Order"></textarea>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row gx-3">
                                </div>
                                 <div class="row gx-3">
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitOrder">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Order Validate --}}
            <div class="modal fade" id="validateOrderModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="validateOrderHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="orderValidateForm" enctype="multipart/form-data">
                                <div class="row gx-3 table-responsive">
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
                                            <th>Tarif</th>
                                            <th>Total</th>
                                            <th>Metode Bayar</th>
                                        </thead>
                                        <tbody id="list-order">
                                            {{-- List Barang Selected --}}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row gx-3 mt-2">
                                    {{-- <div class="col-sm-4">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <div class="form-group">
                                            <select class="form-select" name="payment_method" id="payment_method">
                                                <option value="" selected disabled>-- Pilih Metode Bayar --</option>
                                                <option value="bayar-makassar">Bayar Makassar</option>
                                                <option value="bayar-surabaya">Bayar Surabaya</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Pembayaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="payment_tanggal"
                                                value="{{ date('Y-m-d') }}" id="payment_tanggal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Bukti Pembayaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="file" placeholder="Masukkan Pengirim"
                                                name="payment_bukti" id="payment_bukti" />
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitOrderValidate">Simpan</button>
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

            var orderdata = $('#order_data').DataTable({
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
                "createdRow": function(row, data, dataIndex) {
                    // Assuming 'order_status' column index is 7, adjust this as needed
                    var orderStatusCell = $(row).find('td:eq(3)');
                    orderStatusCell.addClass('wrap-text');
                },
                processing: true,
                serverSide: false,
                ajax: "{{ route('order.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'order_noresi',
                        name: 'order_noresi'
                    },
                    // {
                    //     data: 'order_tanggal',
                    //     name: 'order_tanggal'
                    // },
                    {
                        data: 'order_pengirim',
                        name: 'order_pengirim'
                    },
                    {
                        data: 'order_penerima',
                        name: 'order_penerima'
                    },
                    // {
                    //     data: 'order_berat',
                    //     name: 'order_berat'
                    // },
                    // {
                    //     data: 'order_volume',
                    //     name: 'order_volume'
                    // },
                    // {
                    //     data: 'order_tarif',
                    //     name: 'order_tarif'
                    // },
                    // {
                    //     data: 'order_total',
                    //     name: 'order_total'
                    // },
                    {
                        data: 'payment_status',
                        name: 'payment.payment_status'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment.payment_method'
                    },
                    // {
                    //     data: 'order_create',
                    //     name: 'order_create'
                    // },
                    {
                        data: 'order_received',
                        name: 'order_received'
                    },
                    // {
                    //     data: 'payment_acc',
                    //     name: 'payment_acc'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
                // footerCallback: function (row, data, start, end, display) {
                //     var api = this.api();

                //     // Calculate the sum of 'order_berat'
                //     var totalBerat = api
                //         .column('order_berat:name', { search: 'applied', filter: 'applied' })
                //         .data()
                //         .reduce(function (acc, value) {
                //             return acc + parseFloat(value);
                //         }, 0);

                //     // Calculate the sum of 'order_total'
                //     var totalOrder = api
                //         .column('order_total:name', { search: 'applied', filter: 'applied' })
                //         .data()
                //         .reduce(function (acc, value) {
                //             return acc + parseFloat(value);
                //         }, 0);

                //     // Update the footer cells with the calculated sums
                //     $(api.column('order_berat:name').footer()).html('Total Berat: ' + totalBerat + ' Kg');
                //     $(api.column('order_total:name').footer()).html('Total Order: ' + rupiah(totalOrder));
                // },
            });

            // ORDER TOTAL LOAD
            sumOrder()
            function sumOrder(){
                $.ajax({
                    type: "GET",
                    url: "{{ route('order.total') }}",
                    dataType: "JSON",
                    success: function (response) {
                        var berat  = `TOTAL BERAT: <strong>` + response.berat +`Kg</strong>`;
                        var volume = `TOTAL VOLUME: <strong>` + response.volume +`</strong>`;
                        var total  = `TOTAL ORDER: <strong>` + rupiah(response.total) + `</strong>`;
                        $("#total_volume").html(volume)
                        $("#total_berat").html(berat)
                        $("#total_harga").html(total)
                    }
                });
            }

            var ordervalidate = $('#order_validate').DataTable({
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
                ajax: "{{ route('order.payment.index') }}",
                columns: [{
                        data: 'select',
                        name: 'select'
                    },
                    {
                        data: 'order_noresi',
                        name: 'order_noresi',
                    },
                    {
                        data: 'order_tanggal',
                        name: 'order_tanggal'
                    },
                    {
                        data: 'order_pengirim',
                        name: 'order_pengirim'
                    },
                    {
                        data: 'order_penerima',
                        name: 'order_penerima'
                    },
                    {
                        data: 'order_total',
                        name: 'order_total'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status'
                    },
                ]
            });

            // Create Data Order.
            $('#order-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#orderHeading').html("TAMBAH DATA ORDER BARU");
                $('#orderModal').modal('show');
                $('#method').prop('hidden', false)
                $('#codInputs').html('')

                $('#order_tanggal').prop('readonly', false).val()
                $('#order_pengirim').prop('readonly', false).val()
                $('#order_penerima').prop('readonly', false).val()
                $('#order_alamat_penerima').prop('readonly', false).val()
                $('#order_nohp_penerima').prop('readonly', false).val()
                $('#order_koli').prop('readonly', false).val()
                $('#order_kemasan').prop('readonly', false).val()
                $('#order_rincian').prop('readonly', false).val()
                $('#order_berat').prop('readonly', false).val()
                $('#order_volume').prop('readonly', false).val()
                $('#order_isi').prop('readonly', false).val()
                $('#order_tarif').prop('readonly', false).val()
                $('#order_total').prop('readonly', false).val()
                $('#order_lampiran').prop('readonly', false).val()
                $('#order_keterangan').prop('readonly', false).val()
                $('#payment_keterangan').prop('readonly', false).val()
                
            });

            // Edit Data Order.
            $('body').on('click', '#order-edit', function() {
                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#orderHeading').html("EDIT DATA ORDER BARU");
                $('#orderModal').modal('show');
                $('#method').prop('hidden', false)
                $('#codInputs').html('')

                var order_id    = $(this).attr('data-id')

                $.ajax({
                    type: "POST",
                    url: "{{ route('order.detail') }}",
                    data: {
                        order_id: order_id,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response)
                        // hidden method
                        $('#method').prop('hidden', false)

                        var order_id              = response.order_id
                        var order_tanggal         = response.order_tanggal
                        var order_pengirim        = response.order_pengirim
                        var order_penerima        = response.order_penerima
                        var order_alamat_penerima = response.order_alamat_penerima
                        var order_nohp_penerima   = response.order_nohp_penerima
                        var order_koli            = response.order_koli
                        var order_kemasan         = response.order_kemasan
                        var order_rincian         = response.order_rincian
                        var order_berat           = response.order_berat
                        var order_volume          = response.order_volume
                        var order_isi             = response.order_isi
                        var order_tarif           = response.order_tarif
                        var order_total           = response.order_total
                        var order_lampiran        = response.order_lampiran
                        var order_keterangan      = response.order_keterangan
                        var payment_status        = response.payment.payment_status
                        var payment_tanggal       = response.payment.payment_tanggal
                        var payment_method        = response.payment.payment_method
                        var payment_bukti         = response.payment.payment_bukti
                        var payment_keterangan    = response.payment.payment_keterangan
                        var payment_method        = response.payment.payment_method

                        if(payment_method === 'bayar-surabaya'){
                            $('#bayar-surabaya').prop('checked', true)
                        }else if(payment_method === 'bayar-makassar'){
                            $('#bayar-makassar').prop('checked', true)
                        }
                        
                        $('#order_id').val(order_id)
                        $('#order_tanggal').val(order_tanggal).prop('readonly', false)
                        $('#order_pengirim').val(order_pengirim).prop('readonly', false)
                        $('#order_penerima').val(order_penerima).prop('readonly', false)
                        $('#order_alamat_penerima').val(order_alamat_penerima).prop('readonly', false)
                        $('#order_nohp_penerima').val(order_nohp_penerima).prop('readonly', false)
                        $('#order_koli').val(order_koli).prop('readonly', false)
                        $('#order_kemasan').val(order_kemasan).prop('readonly', false)
                        $('#order_rincian').val(order_rincian).prop('readonly', false)
                        $('#order_berat').val(order_berat).prop('readonly', false)
                        $('#order_volume').val(order_volume).prop('readonly', false)
                        $('#order_isi').val(order_isi).prop('readonly', false)
                        $('#order_tarif').val(order_tarif).prop('readonly', false)
                        $('#order_total').val(order_total).prop('readonly', false)
                        $('#order_lampiran').val(order_lampiran).prop('readonly', false)
                        $('#order_keterangan').val(order_keterangan).prop('readonly', false)
                        $('#payment_keterangan').val(payment_keterangan).prop('readonly', false)
                    }
                });
            });

            // Stored Data Order.
            $('#submitOrder').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                if (!validateOneCheckboxChecked()) {
                    event.preventDefault(); // Prevent form submission if validation fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Hanya Boleh Memilih 1 Metode Pembayaran.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#submitOrder').html('Simpan');
                    return;
                }else{
                    $.ajax({
                        url: "{{ route('order.store') }}",
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
    
                                $('#submitOrder').html('Simpan');
    
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
    
                                $('#orderForm').trigger("reset");
                                $('#submitOrder').html('Simpan');
                                $('#orderModal').modal('hide');
    
                                orderdata.draw();
                                ordervalidate.draw();
                                 setInterval(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    });
                }
            });

            // Calculate and update the total of order
           $('body').on('input', '#order_berat, #order_tarif, #order_volume', function() {
                var berat = parseFloat($("#order_berat").val()) || 0;
                var tarif = parseFloat($("#order_tarif").val()) || 0;
                var volume = parseFloat($("#order_volume").val()) || 0;

                var total;

                if (berat === 0 && volume === 0) {
                    total = 0; // If both berat and volume are 0, set the total to 0
                } else if (berat === 0 || isNaN(berat)) {
                    // If berat is 0 or null, calculate total using volume * tarif
                    total = volume * tarif;
                } else if (volume === 0 || isNaN(volume)) {
                    // If volume is 0 or null, calculate total using berat * tarif
                    total = berat * tarif;
                } else {
                    // If both berat and volume have values, use berat for the calculation
                    total = berat * tarif;
                }

                var decimalPlaces = 2; // Change this number to round to a different number of decimal places

                // Round the total value to the specified decimal places
                var totals = parseFloat(total.toFixed(decimalPlaces));
                $("#order_total").val(totals);
            });

            // If Payment Method using COD admin must to upload bukti pembayaran
            $('#lunas').on('change', function() {
                var isChecked = $(this).prop('checked');
                var codInputsDiv = $('#codInputs');
                
                $("#payment_status").val('lunas')
                $("#payment_tanggal").val($("#order_tanggal").val())
                if (isChecked) {
                    // Add input elements if the "COD" checkbox is checked
                    codInputsDiv.html(`
                        <div class="col-sm-12">
                            <label class="form-label">Bukti Pembayaran</label>
                            <div class="form-group">
                                <input class="form-control" type="file"
                                    placeholder="Masukkan Jumlah tarif" name="payment_bukti"
                                    id="payment_bukti" />
                            </div>
                        </div>
                    `);

                } else {
                    // Remove input elements if the "COD" checkbox is unchecked
                    codInputsDiv.empty();
                }
            });

            // If Payment Method using Bayar Makassar
            $('#bayar-makassar').on('change', function() {
                var isChecked = $(this).prop('checked');
                var codInputsDiv = $('#codInputs');

                if (isChecked) {
                    $("#payment_status").val('blm-lunas')
                }
            });

            // If Payment Method using Bayar Surabaya
            $('#bayar-surabaya').on('change', function() {
                var isChecked = $(this).prop('checked');
                var codInputsDiv = $('#codInputs');

                if (isChecked) {
                    $("#payment_status").val('blm-lunas')
                }
            });

            // Function validate payment method
            function validateOneCheckboxChecked() {
                var lunasChecked  = $("#lunas").is(":checked");
                var mksChecked    = $("#bayar-makassar").is(":checked");
                var sbyChecked    = $("#bayar-surabaya").is(":checked");
                            
                return (lunasChecked + mksChecked + sbyChecked) === 1;
            }

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
                        var order_nohp_penerima   = response.order_nohp_penerima
                        var order_koli            = response.order_koli
                        var order_kemasan         = response.order_kemasan
                        var order_rincian         = response.order_rincian
                        var order_berat           = response.order_berat
                        var order_volume          = response.order_volume
                        var order_isi             = response.order_isi
                        var order_tarif           = response.order_tarif
                        var order_total           = response.order_total
                        var order_lampiran        = response.order_lampiran
                        var order_keterangan      = response.order_keterangan
                        var order_diterima        = response.order_received == null ? '-' : response.order_received
                        var payment_status        = response.payment.payment_status
                        var payment_tanggal       = response.payment.payment_tanggal
                        var payment_method        = response.payment.payment_method
                        var payment_bukti         = response.payment.payment_bukti

                        // GET NAME OF PAYMENT VALIDATION
                        var payment_acc = '';
                        if (response.payment && response.payment.user_acc && response.payment.user_acc.name !== null) {
                            payment_acc = response.payment.user_acc.name;
                        }

                        // GET PAYMENT KETERANGAN OR KOTA TRANSIT
                        var payment_keterangan = '-';
                        if (response.payment && response.payment.payment_keterangan !== null) {
                            payment_keterangan = response.payment.payment_keterangan;
                        }

                        var download_button = '';
                        if(payment_bukti != '-'){
                            download_button = `<div class="col-sm-12">
                                                    <label class="form-label">Bukti Pembayaran</label>
                                                    <div class="form-group">
                                                        <a href="download/image/` + order_id + `" class="btn btn-primary" id="buktiBayar" target="_blank" download>Download Bukti</a>
                                                    </div>
                                                </div>`;
                        }else{
                            download_button = '';
                        }
                        
                        $('#order_tanggal').val(order_tanggal).prop('readonly', true)
                        $('#order_pengirim').val(order_pengirim).prop('readonly', true)
                        $('#order_penerima').val(order_penerima).prop('readonly', true)
                        $('#order_alamat_penerima').val(order_alamat_penerima).prop('readonly', true)
                        $('#order_nohp_penerima').val(order_nohp_penerima).prop('readonly', true)
                        $('#order_koli').val(order_koli).prop('readonly', true)
                        $('#order_kemasan').val(order_kemasan).prop('readonly', true)
                        $('#order_rincian').val(order_rincian).prop('readonly', true)
                        $('#order_berat').val(order_berat).prop('readonly', true)
                        $('#order_volume').val(order_volume).prop('readonly', true)
                        $('#order_isi').val(order_isi).prop('readonly', true)
                        $('#order_tarif').val(order_tarif).prop('readonly', true)
                        $('#order_total').val(order_total).prop('readonly', true)
                        $('#order_lampiran').val(order_lampiran).prop('readonly', true)
                        $('#order_keterangan').val(order_keterangan).prop('readonly', true)
                        $('#payment_keterangan').val(payment_keterangan).prop('readonly', true)

                        if(payment_status == 'lunas'){
                            var button   = `<div class="col-sm-3">
                                                <label class="form-label">Tanggal Pembayaran</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="date" placeholder="Masukkan Jumlah Koli"
                                                        name="payment_tanggal" id="payment_tanggal" value=`+ payment_tanggal +` readonly />
                                            </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="form-label">Validasi Pembayaran Oleh:</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="Masukkan Jenis Kemasan" name="payment_acc"
                                                        id="payment_acc" value=`+ payment_acc +` readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="form-label">Di Terima Oleh:</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="Masukkan Jenis Kemasan" name="order_diterima"
                                                        id="order_diterima" value=`+ order_diterima +` readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="form-label">Metode Pembayaran:</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text"
                                                        placeholder="Masukkan Jenis Kemasan" name="payment_acc"
                                                        id="payment_acc" value=`+ payment_method +` readonly />
                                                </div>
                                            </div>
                                            ` + download_button + ` `;

                            $('#codInputs').html(button)
                        }else{
                            $('#codInputs').html('')
                        }

                    }
                });

            })

            // Create Validate Pembayaran
             $('#order-validate').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-order");
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#validateOrderHeading').html("VALIDATE PEMBAYARAN ORDER");

                var selectedValues = [];

                $('.row-checkbox:checked').each(function() {
                    var row      = $(this).closest('tr');
                    var rowData  = ordervalidate.row(row).data();
                    var order_id = rowData.order_id;
                    selectedValues.push(order_id);
                });
                if (selectedValues.length > 0) {
                    $('#validateOrderModal').modal('show');
                    // REQUEST SELECTED BARANG
                    $.ajax({
                        type: "POST",
                        url: "{{ route('load.orderSelected') }}",
                        data: {
                            order_id: selectedValues,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            console.log(response)
                            var listorder = '';
                            var no = 1;
                            // LOOPING BARANG
                            $.each(response, function(index, value) {
                                const order_id       = value['order_id']
                                const order_noresi   = value['order_noresi']
                                const order_tanggal  = value['order_tanggal']
                                const order_pengirim = value['order_pengirim']
                                const order_penerima = value['order_penerima']
                                const order_berat    = value['order_berat']
                                const order_volume   = value['order_volume']
                                const order_tarif    = value['order_tarif']
                                const order_total    = value['order_total']
                                const payment_method = value.payment['payment_method']
                                
                                listorder += `<tr>
                                                    <td>` + no++ + `</td>
                                                    <td>` + order_noresi + `</td>
                                                    <td>` + order_tanggal + `</td>
                                                    <td>` + order_pengirim + `</td>
                                                    <td>` + order_penerima + `</td>
                                                    <td>` + order_berat + `</td>
                                                    <td>` + order_volume + `</td>
                                                    <td>` + rupiah(order_tarif) + `</td>
                                                    <td>` + rupiah(order_total) + `</td>
                                                    <td>` + payment_method.charAt(0).toUpperCase() + payment_method.slice(1) + `</td>
                                                    <td>
                                                        <input class="form-control" id="order_id" type="hidden" value="` + order_id + `" name="order_id[]" />
                                                    </td>
                                                </tr>`;

                            });
                            $("#list-order").html(listorder)
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih setidaknya satu order!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
                
            });

            // Store order validate
            $("#submitOrderValidate").click(function(e){
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('order.validate.store') }}",
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
                            $('#submitOrderValidate').html('Simpan');

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

                            $('#orderValidateForm').trigger("reset");
                            $('#submitOrderValidate').html('Simpan');
                            $('#validateOrderModal').modal('hide');

                            orderdata.draw();
                            ordervalidate.draw();
                             setInterval(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                });
            })

            // Print surat jalan
            $('body').on('click', '#order-print', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var order_id  = $(this).attr('data-id')

                swalWithBootstrapButtons
                    .fire({
                        title: "Apakah kamu ingin mencetak surat jalan?",
                        text: "Surat jalan akan dicetak!",
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
                            var url = "{{ route('order.print') }}?order_id=" + order_id;

                            // Open the PDF in a new tab/window
                            window.open(url, '_blank');

                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

            // Update order diterima
            $('body').on('click', '#order-receive', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,
                });

                var order_id = $(this).attr('data-id');

                swalWithBootstrapButtons.fire({
                    title: "Apakah kamu yakin order ini telah diterima?",
                    text: "Data order ini akan diperbarui menjadi diterima!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "me-2",
                    cancelButtonText: "Tidak",
                    confirmButtonText: "Ya",
                    reverseButtons: true,
                    input: "text",  // Add an input field to the SweetAlert modal
                    inputPlaceholder: "Masukkan Nama Penerima :",  // Placeholder for the input
                    inputAttributes: {
                        autocapitalize: "off",
                    },
                    showLoaderOnConfirm: true,  // Display loader while confirming
                    preConfirm: (inputValue) => {
                        // Handle the AJAX request
                        return $.ajax({
                            type: "POST",
                            url: "{{ route('order.receive') }}",
                            data: {
                                order_id: order_id,
                                order_received: inputValue,  // Pass the input value to the server
                            },
                            dataType: "json",
                        })
                        .then((response) => {
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
                            });

                            setInterval(function() {
                                window.location.reload();
                            }, 1000);
                        })
                        .catch((error) => {
                            Swal.fire("Error!", "There was an error processing your request.", "error");
                        });
                    },
                })
                .then((result) => {
                    if (!result.isConfirmed) {
                        Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                    }
                });
            });

            // AUTO FILL PENGIRIM
            var autofillInProgress = false;

            $('body').on('input', '#order_pengirim', function() {
                // Fetch historical search data from the API endpoint
                $.ajax({
                    url: '{{ route('get.input') }}', // Change the URL to match the endpoint in your routes
                    data: { query: $(this).val() }, // Pass the input value as a parameter
                    success: function (data) {
                        // Display suggestions in a dropdown or autocomplete list below the input field
                        if (data.length > 0) {
                            var suggestionDropdown = $('#suggestionDropdown');
                            suggestionDropdown.empty(); // Clear previous suggestions

                            // Add suggestions to the dropdown
                            data.forEach(function(suggestion) {
                                suggestionDropdown.append('<div class="suggestion">' + suggestion + '</div>');
                            });

                            // Show the dropdown
                            suggestionDropdown.show();
                        } else {
                            // Hide the dropdown if no suggestions are available
                            $('#suggestionDropdown').hide();

                            // If no suggestions are found, save the input to the database
                            if (!autofillInProgress) {
                                autofillInProgress = true; // Set the autofill flag to prevent duplicate autofill
                                $.ajax({
                                    url: '{{ route('store.input') }}', // Change the URL to match the endpoint in your routes
                                    method: 'POST', // Use POST method to send the data
                                    data: { query: $('#order_pengirim').val() }, // Pass the input value as a parameter
                                    success: function () {
                                        autofillInProgress = false; // Reset the autofill flag
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Handle click on the suggestion in the dropdown
            $('body').on('click', '.suggestion', function() {
                var selectedSuggestion = $(this).text();
                $('#order_pengirim').val(selectedSuggestion);
                $('#suggestionDropdown').hide();
            });

            // Hide the dropdown when clicking outside
            $('body').on('click', function(event) {
                if (!$(event.target).closest('#suggestionDropdown').length && !$(event.target).is('#order_pengirim')) {
                    $('#suggestionDropdown').hide();
                }
            });

            // Handle keydown event to prevent autofill on keys other than "Tab"
            $('body').on('keydown', '#order_pengirim', function(e) {
                if (e.keyCode !== 9) { // 9 is the keycode for "Tab" key
                    autofillInProgress = false; // Reset the autofill flag
                }
            });

            // AUTO FILL PENERIMA
            $('body').on('input', '#order_penerima', function() {
                // Fetch historical search data from the API endpoint
                $.ajax({
                    url: '{{ route('get.input') }}', // Change the URL to match the endpoint in your routes
                    data: { query: $(this).val() }, // Pass the input value as a parameter
                    success: function (data) {
                        // Display suggestions in a dropdown or autocomplete list below the input field
                        if (data.length > 0) {
                            var suggestionDropdown2 = $('#suggestionDropdown2');
                            suggestionDropdown2.empty(); // Clear previous suggestions

                            // Add suggestions to the dropdown
                            data.forEach(function(suggestion) {
                                suggestionDropdown2.append('<div class="suggestion2">' + suggestion + '</div>');
                            });

                            // Show the dropdown
                            suggestionDropdown2.show();
                        } else {
                            // Hide the dropdown if no suggestions are available
                            $('#suggestionDropdown2').hide();

                            // If no suggestions are found, save the input to the database
                            if (!autofillInProgress) {
                                autofillInProgress = true; // Set the autofill flag to prevent duplicate autofill
                                $.ajax({
                                    url: '{{ route('store.input') }}', // Change the URL to match the endpoint in your routes
                                    method: 'POST', // Use POST method to send the data
                                    data: { query: $('#order_penerima').val() }, // Pass the input value as a parameter
                                    success: function () {
                                        autofillInProgress = false; // Reset the autofill flag
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Handle click on the suggestion in the dropdown
            $('body').on('click', '.suggestion2', function() {
                var selectedSuggestion = $(this).text();
                $('#order_penerima').val(selectedSuggestion);
                $('#suggestionDropdown2').hide();
            });

            // Hide the dropdown when clicking outside
            $('body').on('click', function(event) {
                if (!$(event.target).closest('#suggestionDropdown2').length && !$(event.target).is('#order_penerima')) {
                    $('#suggestionDropdown2').hide();
                }
            });

            // Handle keydown event to prevent autofill on keys other than "Tab"
            $('body').on('keydown', '#order_penerima', function(e) {
                if (e.keyCode !== 9) { // 9 is the keycode for "Tab" key
                    autofillInProgress = false; // Reset the autofill flag
                }
            });

            // AUTO FILL NO HP
            $('body').on('input', '#order_nohp_penerima', function() {
                // Fetch historical search data from the API endpoint
                $.ajax({
                    url: '{{ route('get.input') }}', // Change the URL to match the endpoint in your routes
                    data: { nohp: $(this).val() }, // Pass the input value as a parameter
                    success: function (data) {
                        // Display suggestions in a dropdown or autocomplete list below the input field
                        if (data.length > 0) {
                            var suggestionDropdown3 = $('#suggestionDropdown3');
                            suggestionDropdown3.empty(); // Clear previous suggestions

                            // Add suggestions to the dropdown
                            data.forEach(function(suggestion) {
                                suggestionDropdown3.append('<div class="suggestion3">' + suggestion + '</div>');
                            });

                            // Show the dropdown
                            suggestionDropdown3.show();
                        } else {
                            // Hide the dropdown if no suggestions are available
                            $('#suggestionDropdown3').hide();

                            // If no suggestions are found, save the input to the database
                            if (!autofillInProgress) {
                                autofillInProgress = true; // Set the autofill flag to prevent duplicate autofill
                                $.ajax({
                                    url: '{{ route('store.input') }}', // Change the URL to match the endpoint in your routes
                                    method: 'POST', // Use POST method to send the data
                                    data: { nohp: $('#order_nohp_penerima').val() }, // Pass the input value as a parameter
                                    success: function () {
                                        autofillInProgress = false; // Reset the autofill flag
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Handle click on the suggestion in the dropdown
            $('body').on('click', '.suggestion3', function() {
                var selectedSuggestion = $(this).text();
                $('#order_nohp_penerima').val(selectedSuggestion);
                $('#suggestionDropdown3').hide();
            });

            // Hide the dropdown when clicking outside
            $('body').on('click', function(event) {
                if (!$(event.target).closest('#suggestionDropdown3').length && !$(event.target).is('#order_nohp_penerima')) {
                    $('#suggestionDropdown3').hide();
                }
            });

            // Handle keydown event to prevent autofill on keys other than "Tab"
            $('body').on('keydown', '#order_nohp_penerima', function(e) {
                if (e.keyCode !== 9) { // 9 is the keycode for "Tab" key
                    autofillInProgress = false; // Reset the autofill flag
                }
            });

            // AUTO FILL ALAMAT
            $('body').on('input', '#order_alamat_penerima', function() {
                // Fetch historical search data from the API endpoint
                $.ajax({
                    url: '{{ route('get.input') }}', // Change the URL to match the endpoint in your routes
                    data: { address: $(this).val() }, // Pass the input value as a parameter
                    success: function (data) {
                        // Display suggestions in a dropdown or autocomplete list below the input field
                        if (data.length > 0) {
                            var suggestionDropdown4 = $('#suggestionDropdown4');
                            suggestionDropdown4.empty(); // Clear previous suggestions

                            // Add suggestions to the dropdown
                            data.forEach(function(suggestion) {
                                suggestionDropdown4.append('<div class="suggestion4">' + suggestion + '</div>');
                            });

                            // Show the dropdown
                            suggestionDropdown4.show();
                        } else {
                            // Hide the dropdown if no suggestions are available
                            $('#suggestionDropdown4').hide();

                            // If no suggestions are found, save the input to the database
                            if (!autofillInProgress) {
                                autofillInProgress = true; // Set the autofill flag to prevent duplicate autofill
                                $.ajax({
                                    url: '{{ route('store.input') }}', // Change the URL to match the endpoint in your routes
                                    method: 'POST', // Use POST method to send the data
                                    data: { address: $('#order_alamat_penerima').val() }, // Pass the input value as a parameter
                                    success: function () {
                                        autofillInProgress = false; // Reset the autofill flag
                                    }
                                });
                            }
                        }
                    }
                });
            });

            // Handle click on the suggestion in the dropdown
            $('body').on('click', '.suggestion4', function() {
                var selectedSuggestion = $(this).text();
                $('#order_alamat_penerima').val(selectedSuggestion);
                $('#suggestionDropdown4').hide();
            });

            // Hide the dropdown when clicking outside
            $('body').on('click', function(event) {
                if (!$(event.target).closest('#suggestionDropdown4').length && !$(event.target).is('#order_alamat_penerima')) {
                    $('#suggestionDropdown4').hide();
                }
            });

            // Handle keydown event to prevent autofill on keys other than "Tab"
            $('body').on('keydown', '#order_alamat_penerima', function(e) {
                if (e.keyCode !== 9) { // 9 is the keycode for "Tab" key
                    autofillInProgress = false; // Reset the autofill flag
                }
            });

        })
    </script>
@endpush
