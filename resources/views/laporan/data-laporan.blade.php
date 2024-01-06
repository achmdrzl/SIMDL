@extends('layouts.main')

@push('style-alt')
<style>
    /* Reduce font size for table body cells */
    #laporan_data tbody td {
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
                            <h1 class="pg-title">Data Laporan</h1>
                            <p>Management Pengelolaan Data Laporan CV. Den Logistik</p>
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
                                        <h6>List Data Laporan
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="laporan-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Laporan</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="laporan_data" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Total Omset</th>
                                                        <th>Total Handling</th>
                                                        <th>Pengeluaran Mks</th>
                                                        <th>Total Operasional</th>
                                                        <th>Total Transportasi</th>
                                                        <th>Total Gaji</th>
                                                        <th>Total Laba Bersih</th>
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

            {{-- Modal LAPORAN --}}
            <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="laporanHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="laporanForm" enctype="multipart/form-data">
                                <div class="row gx-3">
                                    <input type="hidden" id="laporan_id" name="laporan_id">
                                    <div class="col-sm-4">
                                        <label class="form-label">Tanggal Laporan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="laporan_tanggal"
                                                value="{{ date('Y-m-d') }}" id="laporan_tanggal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Tanggal Awal</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Tanggal Awal"
                                                name="laporan_tanggal_awal" id="laporan_tanggal_awal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Tanggal Akhir</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Tanggal Akhir"
                                                name="laporan_tanggal_akhir" id="laporan_tanggal_akhir" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3 table-responsive" id="data-order">
                                    {{--  --}}
                                </div>
                                <hr class="hr-3 mb-3">
                                <div class="handling_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-handling">
                                        <h6>Laporan Pendapatan Handling</h6>
                                        <div class="col-sm-2">
                                            <label class="form-label">Kota</label>
                                            <div class="form-group">
                                                <input class="form-control handling_kota" type="text"
                                                    name="handling_kota[]" id="handling_kota" placeholder="Masukkan Kota" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Tarif</label>
                                            <div class="form-group">
                                                <input class="form-control handling_tarif" type="number"
                                                    name="handling_tarif[]" id="handling_tarif"
                                                    placeholder="Masukkan Tarif" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Berat</label>
                                            <div class="form-group">
                                                <input class="form-control handling_berat" type="number"
                                                    name="handling_berat[]" id="handling_berat"
                                                    placeholder="Masukkan Berat" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Total</label>
                                            <div class="form-group">
                                                <input class="form-control handling_total" type="number"
                                                    name="handling_total[]" id="handling_total"
                                                    placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mt-5 mb-2">
                                            <button type="button" id="addBtnHandling" class="btn btn-primary"><span
                                                    class="material-icons btn-md">add_circle_outline</span></button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="hr-3 mb-3">
                                <div class="row gx-3 table-responsive" id="data-pengeluaran-mks">
                                    {{--  --}}
                                </div>
                                <hr class="hr-3 mb-3">
                                <div class="transportasi_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-transportasi">
                                        <h6>Laporan Pengeluaran Transportasi</h6>
                                        <div class="col-sm-4">
                                            <label class="form-label">Keterangan</label>
                                            <div class="form-group">
                                                <input class="form-control" type="text"
                                                    name="transportasi_keterangan[]" id="transportasi_keterangan"
                                                    placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Total</label>
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="transportasi_total[]"
                                                    id="transportasi_total" placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Bukti</label>
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="transportasi_bukti[]"
                                                    id="transportasi_bukti" placeholder="Masukkan Bukti" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mt-5 mb-2">
                                            <button type="button" id="addBtnTransportasi" class="btn btn-primary"><span
                                                    class="material-icons btn-md">add_circle_outline</span></button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="hr-3 mb-3">
                                <div class="operasional_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-operasional">
                                        <h6>Laporan Pengeluaran Operasional</h6>
                                        <div class="col-sm-4">
                                            <label class="form-label">Keterangan</label>
                                            <div class="form-group">
                                                <input class="form-control" type="text"
                                                    name="operasional_keterangan[]" id="operasional_keterangan"
                                                    placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Total</label>
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="operasional_total[]"
                                                    id="operasional_total" placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Bukti</label>
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="operasional_bukti[]"
                                                    id="operasional_bukti" placeholder="Masukkan Bukti" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mt-5 mb-2">
                                            <button type="button" id="addBtnOperasional" class="btn btn-primary"><span
                                                    class="material-icons btn-md">add_circle_outline</span></button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="hr-3 mb-3">
                                <div class="gaji_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-operasional">
                                        <h6>Laporan Pengeluaran Gaji</h6>
                                        <div class="col-sm-4">
                                            <label class="form-label">Keterangan</label>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="gaji_keterangan[]"
                                                    id="gaji_keterangan" placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Total</label>
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="gaji_total[]"
                                                    id="gaji_total" placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Bukti</label>
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="gaji_bukti[]"
                                                    id="gaji_bukti" placeholder="Masukkan Bukti" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mt-5 mb-2">
                                            <button type="button" id="addBtnGaji" class="btn btn-primary"><span
                                                    class="material-icons btn-md">add_circle_outline</span></button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitLaporan">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal DETAIL LAPORAN --}}
            <div class="modal fade" id="detailLaporan" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 id="laporanDetailHeading"></h6>
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
                                                <label class="form-label mb-xl-0">Tanggal Laporan:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="date" id="detail_laporan_tanggal"
                                                    name="detail_laporan_tanggal" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Handling</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Kota</th>
                                                <th>Tarif</th>
                                                <th>Berat</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody id="list-handling">
                                                {{-- List Handling --}}
                                            </tbody>
                                            <tfoot id="foot-handling">
                                                {{-- LIST FOOTER --}}
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Transportasi</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Total</th>
                                                <th>Bukti</th>
                                            </thead>
                                            <tbody id="list-transportasi">
                                                {{-- List Transportasi --}}
                                            </tbody>
                                            <tfoot id="foot-transportasi">
                                                {{-- LIST FOOTER --}}
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Operasional</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Total</th>
                                                <th>Bukti</th>
                                            </thead>
                                            <tbody id="list-operasional">
                                                {{-- List Operasional --}}
                                            </tbody>
                                            <tfoot id="foot-operasional">
                                                {{-- LIST FOOTER --}}
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Gaji</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Total</th>
                                                <th>Bukti</th>
                                            </thead>
                                            <tbody id="list-gaji">
                                                {{-- List Gaji --}}
                                            </tbody>
                                            <tfoot id="foot-gaji">
                                                {{-- LIST FOOTER --}}
                                            </tfoot>
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
                                                            Omset
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_omset"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Handling
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_handling"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Pengeluaran Makassar
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_pengeluaran_mks"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Transportasi
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_transportasi"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Operasional
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_operasional"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-top-start border-end-0 border-bottom-0">Total
                                                            Gaji
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total_gaji"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-bottom-start border-end-0 bg-primary-light-5">
                                                            <span class="text-dark">Total Laba Bersih</span>
                                                        </td>
                                                        <td class="rounded-bottom-end  bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_laporan_total"></div>
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

            var laporandata = $('#laporan_data').DataTable({
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
                ajax: "{{ route('laporan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'laporan_tanggal',
                        name: 'laporan_tanggal'
                    },
                    {
                        data: 'laporan_total_omset',
                        name: 'laporan_total_omset'
                    },
                    {
                        data: 'laporan_total_handling',
                        name: 'laporan_total_handling'
                    },
                    {
                        data: 'laporan_total_pengeluaran_mks',
                        name: 'laporan_total_pengeluaran_mks'
                    },
                    {
                        data: 'laporan_total_operasional',
                        name: 'laporan_total_operasional'
                    },
                    {
                        data: 'laporan_total_transportasi',
                        name: 'laporan_total_transportasi'
                    },
                    {
                        data: 'laporan_total_gaji',
                        name: 'laporan_total_gaji'
                    },
                    {
                        data: 'laporan_total',
                        name: 'laporan_total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
            });

            // Get order data based on tanggal
            $('body').on('input', '#laporan_tanggal_awal, #laporan_tanggal_akhir', function() {
                var tanggal_awal = $('#laporan_tanggal_awal').val()
                var tanggal_akhir = $('#laporan_tanggal_akhir').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('laporan.order.data') }}",
                    data: {
                        laporan_tanggal_awal: tanggal_awal,
                        laporan_tanggal_akhir: tanggal_akhir,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
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
                            if (response.data.length > 0) {
                                var table = `<h6>Data Order</h6>
                                            <div style="max-height:300px; overflow-y: scroll;">
                                                <table id="order-data" class="table nowrap table-striped" style="width:100%">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>No Resi</th>
                                                        <th>Tanggal</th>
                                                        <th>Pengirim</th>
                                                        <th>Penerima</th>
                                                        <th>Koli</th>
                                                        <th>Berat</th>
                                                        <th>Tarif</th>
                                                        <th>Total</th>
                                                        <th>Status Pembayaran</th>
                                                    </thead>
                                                    <tbody id="list-order">
                                                        {{-- List Barang Selected --}}
                                                    </tbody>
                                                    <tfoot id="total-orders">
                                                    </tfoot>
                                                </table>
                                            </div>`;

                                var table2 = `<h6>Data Pengeluaran Makassar</h6>
                                            <div style="max-height:300px; overflow-y: scroll;">
                                                <table id="pengeluaran-data" class="table nowrap table-striped" style="width:100%">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Total Modal</th>
                                                        <th>Total Operasional</th>
                                                        <th>Total Transportasi</th>
                                                        <th>Total Gaji</th>
                                                        <th>Pengeluaran Total</th>
                                                    </thead>
                                                    <tbody id="list-pengeluaran">
                                                        {{-- List Barang Selected --}}
                                                    </tbody>
                                                    <tfoot id="total-pengeluaran">
                                                    </tfoot>
                                                </table>
                                            </div>`;

                                var listorder = '';
                                var no = 1;
                                // LOOPING ORDER
                                $.each(response.data, function(index, value) {
                                    const order_id       = value['order_id']
                                    const order_noresi   = value['order_noresi']
                                    const order_tanggal  = value['order_tanggal']
                                    const order_pengirim = value['order_pengirim']
                                    const order_penerima = value['order_penerima']
                                    const order_koli     = value['order_koli']
                                    const order_berat    = value['order_berat']
                                    const order_tarif    = value['order_tarif']
                                    const order_total    = value['order_total']

                                    const payment_status = value.payment['payment_status']
                                    // Validate Badge Status Payment
                                    if(value.payment['payment_status'] == 'lunas'){
                                        var status = '<div class="badge bg-success">' + payment_status.toUpperCase() + '</div>'
                                    }else{
                                        var status = '<div class="badge bg-danger">' + payment_status.toUpperCase() + '</div>'
                                    }

                                    listorder += `<tr>
                                                        <td>` + no++ + `</td>
                                                        <td>` + order_noresi + `</td>
                                                        <td>` + order_tanggal + `</td>
                                                        <td>` + order_pengirim + `</td>
                                                        <td>` + order_penerima + `</td>
                                                        <td>` + order_koli + `</td>
                                                        <td>` + order_berat + `</td>
                                                        <td>` + rupiah(order_tarif) + `</td>
                                                        <td>` + rupiah(order_total) + `</td>
                                                        <td>` + status + `</td>
                                                    </tr>`;

                                });

                                var total       = response.total_order
                                var tfoot_order = '';
                                tfoot_order += `<tr>
                                                    <td colspan="7" style="text-align:right;">Total</td>
                                                    <td> <input class="form-control" type="hidden" name="laporan_total_omset"
                                                    id="laporan_total_omset" value="`+total+`" /></td>
                                                    <td>` + rupiah(total) + `</td>
                                                </tr>`;

                                $('#data-order').html(table)
                                $("#list-order").html(listorder)
                                $("#total-orders").html(tfoot_order)

                                // LOOPING PENGELUARAN
                                var listpengeluaran = '';
                                var no = 1;
                                // LOOPING BARANG
                                $.each(response.pengeluaran, function(index, value) {
                                    const pengeluaran_id                  = value['pengeluaran_id']
                                    const pengeluaran_tanggal             = value['pengeluaran_tanggal']
                                    const pengeluaran_total_modal         = value['pengeluaran_total_modal']
                                    const pengeluaran_total_operasional   = value['pengeluaran_total_operasional']
                                    const pengeluaran_total_transportasi  = value['pengeluaran_total_transportasi']
                                    const pengeluaran_total_gaji          = value['pengeluaran_total_gaji']
                                    const pengeluaran_total               = value['pengeluaran_total']
                                    const pengeluaran_sisa_saldo          = value['pengeluaran_sisa_saldo']

                                    listpengeluaran += `<tr>
                                                        <td>` + no++ + `</td>
                                                        <td>` + pengeluaran_tanggal + `</td>
                                                        <td>` + rupiah(pengeluaran_total_modal) + `</td>
                                                        <td>` + rupiah(pengeluaran_total_operasional) + `</td>
                                                        <td>` + rupiah(pengeluaran_total_transportasi) + `</td>
                                                        <td>` + rupiah(pengeluaran_total_gaji) + `</td>
                                                        <td>` + rupiah(pengeluaran_total) + `</td>
                                                    </tr>`;

                                });

                                var total             = response.total_pengeluaran
                                var sisa_saldo        = response.sisa_saldo
                                var tfoot_pengeluaran = '';
                                tfoot_pengeluaran    += `<tr>
                                                            <td colspan="5" style="text-align:right;">Total</td>
                                                            <td> <input class="form-control" type="hidden" name="pengeluaran_total"
                                                            id="pengeluaran_total" value="` + total + `" />
                                                            <td>` + rupiah(total) + `</td>
                                                        </tr>`;

                                $("#data-pengeluaran-mks").html(table2)
                                $('#list-pengeluaran').html(listpengeluaran)
                                $("#total-pengeluaran").html(tfoot_pengeluaran)

                            } else {
                                var table = `<h6>No Data Avalilable</h6>`;
                                $('#data-order').html(table)
                                $("#data-pengeluaran-mks").html(table)

                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors here if needed
                        console.log(xhr.responseText);
                    }
                });

            })

            // HANDLING multiple input
            // max field dinamis input
            var maxFieldHandling = 30; //Input fields increment limitation

            // Append Ticket Category Input
            var addButtonHandling = $('#addBtnHandling'); //Add button selector
            var wrapperHandling = $('.handling_wrapper'); //Input field wrapper
            var fieldHTMLHandling = `<div class="row gx-3 table-responsive" id="data-handling">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input class="form-control handling_kota" type="text"
                                                    name="handling_kota[]" id="handling_kota" placeholder="Masukkan Kota" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input class="form-control handling_tarif" type="number"
                                                    name="handling_tarif[]" id="handling_tarif"
                                                    placeholder="Masukkan Tarif" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input class="form-control handling_berat" type="number"
                                                    name="handling_berat[]" id="handling_berat"
                                                    placeholder="Masukkan Berat" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control handling_total" type="number"
                                                    name="handling_total[]" id="handling_total"
                                                    placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-2">
                                            <button type="button" class="btn btn-danger minBtnHandling"><span class="material-icons btn-md">remove_circle_outline</span></button>
                                        </div>
                                    </div>`;

            var xHandling = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonHandling).click(function() {
                //Check maximum number handlingf input fields
                if (xHandling < maxFieldHandling) {
                    xHandling++; //Increment field counter
                    $(wrapperHandling).append(fieldHTMLHandling); //Add field html
                    if (xHandling == 30) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Penambahan telah maksimal',
                        })
                    }
                }
            });

            //Once remove button is clicked
            $(wrapperHandling).on('click', '.minBtnHandling', function(e) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                xHandling--; //Decrement field counter

                if (xHandling == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan handling paling tidak satu!',
                    })
                }
            });

            // OPERASIONAL multiple input
            // max field dinamis input
            var maxFieldOperasional = 30; //Input fields increment limitation

            // Append Ticket Category Input
            var addButtonOperasional = $('#addBtnOperasional'); //Add button selector
            var wrapperOperasional = $('.operasional_wrapper'); //Input field wrapper
            var fieldHTMLOperasional = ` <div class="row gx-3 table-responsive" id="data-operasional">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" type="text"
                                                    name="operasional_keterangan[]" id="operasional_keterangan"
                                                    placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="operasional_total[]"
                                                    id="operasional_total" placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="operasional_bukti[]"
                                                    id="operasional_bukti" placeholder="Masukkan Bukti" />
                                            </div>
                                        </div>
                                         <div class="col-sm-2 mb-2">
                                             <button type="button" class="btn btn-danger minBtnOperasional"><span class="material-icons btn-md">remove_circle_outline</span></button>
                                        </div>
                                    </div>`;

            var xOperasional = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonOperasional).click(function() {
                //Check maximum number input fields
                if (xOperasional < maxFieldOperasional) {
                    xOperasional++; //Increment field counter
                    $(wrapperOperasional).append(fieldHTMLOperasional); //Add field html
                    if (xOperasional == 30) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Penambahan telah maksimal',
                        })
                    }
                }
            });

            //Once remove button is clicked
            $(wrapperOperasional).on('click', '.minBtnOperasional', function(e) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                xOperasional--; //Decrement field counter

                if (xOperasional == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Operasional paling tidak satu!',
                    })
                }
            });

            // GAJI multiple input
            // max field dinamis input
            var maxFieldGaji = 30; //Input fields increment limitation

            // Append Ticket Category Input
            var addButtonGaji = $('#addBtnGaji'); //Add button selector
            var wrapperGaji = $('.gaji_wrapper'); //Input field wrapper
            var fieldHTMLGaji = `<div class="row gx-3 table-responsive" id="data-gaji">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="gaji_keterangan[]"
                                                id="gaji_keterangan" placeholder="Masukkan Keterangan" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="gaji_total[]"
                                                id="gaji_total" placeholder="Masukkan Total" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input class="form-control" type="file" name="gaji_bukti[]"
                                                id="gaji_bukti" placeholder="Masukkan Bukti" />
                                        </div>
                                    </div>
                                        <div class="col-sm-2 mb-2">
                                            <button type="button" class="btn btn-danger minBtnGaji"><span class="material-icons btn-md">remove_circle_outline</span></button>
                                    </div>
                                </div>`;

            var xGaji = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonGaji).click(function() {
                //Check maximum number input fields
                if (xGaji < maxFieldGaji) {
                    xGaji++; //Increment field counter
                    $(wrapperGaji).append(fieldHTMLGaji); //Add field html
                    if (xGaji == 30) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Penambahan telah maksimal',
                        })
                    }
                }
            });

            //Once remove button is clicked
            $(wrapperGaji).on('click', '.minBtnGaji', function(e) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                xGaji--; //Decrement field counter

                if (xGaji == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Gaji paling tidak satu!',
                    })
                }
            });

            // TRANSPORTASI multiple input
            // max field dinamis input
            var maxFieldTransportasi = 30; //Input fields increment limitation

            // Append Ticket Category Input
            var addButtonTransportasi = $('#addBtnTransportasi'); //Add button selector
            var wrapperTransportasi = $('.transportasi_wrapper'); //Input field wrapper
            var fieldHTMLTransportasi = ` <div class="row gx-3 table-responsive" id="data-transportasi">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="transportasi_keterangan[]"
                                                    id="transportasi_keterangan" placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="transportasi_total[]"
                                                    id="transportasi_total" placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="transportasi_bukti[]"
                                                    id="transportasi_bukti" placeholder="Masukkan Bukti" />
                                            </div>
                                        </div>
                                         <div class="col-sm-2 mb-2">
                                             <button type="button" class="btn btn-danger minBtnTransportasi"><span class="material-icons btn-md">remove_circle_outline</span></button>
                                        </div>
                                    </div>`;

            var xTransportasi = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonTransportasi).click(function() {
                //Check maximum number input fields
                if (xTransportasi < maxFieldTransportasi) {
                    xTransportasi++; //Increment field counter
                    $(wrapperTransportasi).append(fieldHTMLTransportasi); //Add field html
                    if (xTransportasi == 30) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Penambahan telah maksimal',
                        })
                    }
                }
            });

            //Once remove button is clicked
            $(wrapperTransportasi).on('click', '.minBtnTransportasi', function(e) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                xTransportasi--; //Decrement field counter

                if (xTransportasi == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Transportasi paling tidak satu!',
                    })
                }
            });

            // SUM TOTAL ON HANDLING
            $('body').on('input', '.handling_tarif, .handling_berat', function() {
                var row   = $(this).closest('div.row');
                var tarif = parseFloat(row.find('.handling_tarif').val()) || 0;
                var berat = parseFloat(row.find('.handling_berat').val()) || 0;

                var total = (tarif * berat); // Tarif Handling * Berat on Handling
                var decimalPlaces = 2; // Change this number to round to a different number of decimal places

                // Round the total value to the specified decimal places
                total = parseFloat(total.toFixed(decimalPlaces));

                row.find('.handling_total').val(total);
            })

            // Create Data Order.
            $('#laporan-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-manifest");
                $('#laporan_id').val('');
                $('#laporanForm').trigger("reset");
                $('#laporanHeading').html("TAMBAH DATA LAPORAN BARU");
                $('#laporanModal').modal('show');

                $('#data-order').html('')
                $('#data-pengeluaran-mks').html('')
            });

            // Stored Data Laporan.
            $('#submitLaporan').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('laporan.store') }}",
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
                            $('#submitLaporan').html('Simpan');

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

                            $('#laporanForm').trigger("reset");
                            $('#submitLaporan').html('Simpan');
                            $('#laporanModal').modal('hide');
                            laporandata.draw();
                        }
                    }
                });
            });

            // Detail Laporan
            $('body').on('click', '#laporan-detail', function() {
                $('.alert').hide();
                $('#saveBtn').val("detail-manifest");
                $('#laporanForm').trigger("reset");
                $('#laporanDetailHeading').html("DETAIL DATA LAPORAN");
                $('#detailLaporan').modal('show');

                var laporan_id = $(this).attr('data-id');
                console.log(laporan_id)
                $.ajax({
                    type: "POST",
                    url: "{{ route('laporan.detail') }}",
                    data: {
                        laporan_id: laporan_id,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        // DATA TOTAL LAPORAN
                        var laporan_tanggal               = response.laporan.laporan_tanggal
                        var laporan_total_omset           = response.laporan.laporan_total_omset
                        var laporan_total_handling        = response.laporan.laporan_total_handling
                        var laporan_total_pengeluaran_mks = response.laporan.laporan_total_pengeluaran_mks
                        var laporan_total_transportasi    = response.laporan.laporan_total_transportasi
                        var laporan_total_operasional     = response.laporan.laporan_total_operasional
                        var laporan_total_gaji            = response.laporan.laporan_total_gaji
                        var laporan_total                 = response.laporan.laporan_total

                        var order_total                   = response.order_total
                        var laba_bersih                   = response.laba_bersih

                        $("#detail_laporan_tanggal").val(laporan_tanggal).prop('readonly', true)
                        $("#detail_laporan_total_omset").html(rupiah(order_total))
                        $("#detail_laporan_total_handling").html(rupiah(laporan_total_handling))
                        $("#detail_laporan_total_transportasi").html(rupiah(laporan_total_transportasi))
                        $("#detail_laporan_total_pengeluaran_mks").html(rupiah(laporan_total_pengeluaran_mks))
                        $("#detail_laporan_total_operasional").html(rupiah(laporan_total_operasional))
                        $("#detail_laporan_total_gaji").html(rupiah(laporan_total_gaji))
                        $("#detail_laporan_total").html(rupiah(laba_bersih))

                        // DATA HANDLING
                        var listhandling = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.laporan.handling, function(index, value) {
                            const handling_kota  = value['handling_kota']
                            const handling_berat = value['handling_berat']
                            const handling_tarif = value['handling_tarif']
                            const handling_total = value['handling_total']

                            listhandling += `<tr>
                                                <td>` + no++ + `</td>
                                                <td>` + handling_kota + `</td>
                                                <td>` + rupiah(handling_tarif) + `</td>
                                                <td>` + handling_berat + `</td>
                                                <td>` + rupiah(handling_total) + `</td>
                                            </tr>`;

                        });
                        var footer_handling = `<tr>
                                                    <th colspan="4" style="text-align:center">TOTAL</th>
                                                    <th colspan="1">` + rupiah(laporan_total_handling) + `</th>
                                                </tr>`;

                        $("#list-handling").html(listhandling)
                        $("#foot-handling").html(footer_handling)

                        // DATA TRANSPORTASI
                        var listtransportasi = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.laporan.transportasi, function(index, value) {
                            const transportasi_id          = value['transportasi_id']
                            const transportasi_keterangan  = value['transportasi_keterangan']
                            const transportasi_total       = value['transportasi_total']
                            const transportasi_bukti       = value['transportasi_bukti']
                            var transportasi               = 'transportasi' + transportasi_id;

                            if(transportasi_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaranTransportasi/` + transportasi_id + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                                // var button = ` <a href="downloadBuktiPengeluaran/` + transportasi + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                            }else{
                                var button = '-'
                            }

                            listtransportasi += `<tr>
                                                <td>` + no++ + `</td>
                                                <td>` + transportasi_keterangan + `</td>
                                                <td>` + rupiah(transportasi_total) + `</td>
                                                <td>  
                                                    ` + button + ` 
                                                </td>
                                            </tr>`;

                        });
                        var footer_transportasi = `<tr>
                                                        <th colspan="2" style="text-align:center">TOTAL</th>
                                                        <th colspan="2">` + rupiah(laporan_total_transportasi) + `</th>
                                                    </tr>`;

                        $("#list-transportasi").html(listtransportasi)
                        $("#foot-transportasi").html(footer_transportasi)

                        // DATA OPERASIONAL
                        var listoperasional = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.laporan.operasional, function(index, value) {
                            const operasional_id          = value['operasional_id']
                            const operasional_keterangan  = value['operasional_keterangan']
                            const operasional_total       = value['operasional_total']
                            const operasional_bukti       = value['operasional_bukti']
                            var operasional               = 'operasional' + operasional_id;

                            if(operasional_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaranOperasional/` + operasional_id + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                                // var button = ` <a href="downloadBuktiPengeluaran/` + operasional + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                            }else{
                                var button = '-'
                            }

                            listoperasional += `<tr>
                                                <td>` + no++ + `</td>
                                                <td>` + operasional_keterangan + `</td>
                                                <td>` + rupiah(operasional_total) + `</td>
                                                <td>  
                                                    ` + button + `
                                                </td>
                                            </tr>`;

                        });
                        var footer_operasional = `<tr>
                                                        <th colspan="2" style="text-align:center">TOTAL</th>
                                                        <th colspan="2">` + rupiah(laporan_total_operasional) + `</th>
                                                    </tr>`;

                        $("#list-operasional").html(listoperasional)
                        $("#foot-operasional").html(footer_operasional)

                        // DATA GAJI
                        var listgaji = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.laporan.gaji, function(index, value) {
                            const gaji_id          = value['gaji_id']
                            const gaji_keterangan  = value['gaji_keterangan']
                            const gaji_total       = value['gaji_total']
                            const gaji_bukti       = value['gaji_bukti']
                            var gaji               = 'gaji' + gaji_id;

                            if(gaji_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaranGaji/` + gaji_id + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                                // var button = ` <a href="downloadBuktiPengeluaran/` + gaji + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
                            }else{
                                var button = '-'
                            }

                            listgaji += `<tr>
                                                <td>` + no++ + `</td>
                                                <td>` + gaji_keterangan + `</td>
                                                <td>` + rupiah(gaji_total) + `</td>
                                                <td>  
                                                    ` + button + `
                                                </td>
                                            </tr>`;

                        });
                        var footer_gaji = `<tr>
                                                <th colspan="2" style="text-align:center">TOTAL</th>
                                                <th colspan="2">` + rupiah(laporan_total_gaji) + `</th>
                                            </tr>`;

                        $("#list-gaji").html(listgaji)
                        $("#foot-gaji").html(footer_gaji)
                    }
                });
            })

            // Print Laporan
            $('body').on('click', '#laporan-print', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var laporan_id  = $(this).attr('data-id')

                swalWithBootstrapButtons
                    .fire({
                        title: "Apakah kamu ingin mencetak laporan?",
                        text: "Laporan akan dicetak!",
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
                            var url = "{{ route('laporan.print') }}?laporan_id=" + laporan_id;

                            // Open the PDF in a new tab/window
                            window.open(url, '_blank');

                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

            // Delete Laporan
            $('body').on('click', '#laporan-delete', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var laporan_id = $(this).attr('data-id');

                swalWithBootstrapButtons
                    .fire({
                        title: "Apakah kamu ingin menghapus data laporan ini?",
                        text: "Laporan akan di hapus!",
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
                                url: "{{ route('laporan.destroy') }}",
                                data: {
                                    laporan_id: laporan_id,
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
                                    laporandata.draw();
                                },
                                error: function(error) {
                                    Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                                },
                            });
                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

        })
    </script>
@endpush
