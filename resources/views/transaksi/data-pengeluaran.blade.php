@extends('layouts.main')

@push('style-alt')
<style>
    /* Reduce font size for table body cells */
    #pengeluaran_data tbody td {
        font-size: 16px;
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
                            <h1 class="pg-title">Data Pengeluaran Makassar</h1>
                            <p>Management Pengelolaan Data Pengeluaran CV. Den Logistik</p>
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
                                        <h6>List Data Pengeluaran Makassar
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="pengeluaran-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Pengeluaran</span></span></button>
                                            <button class="btn btn-sm btn-primary ms-3" id="pengeluaran-print"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="printer"></i></span></span><span
                                                        class="btn-text">Cetak
                                                        Pengeluaran</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="pengeluaran_data" class="table nowrap table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Total Modal</th>
                                                        <th>Total Operasional</th>
                                                        <th>Total Transportasi</th>
                                                        <th>Total Gaji</th>
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
                </div>
            </div>
            <!-- /Page Body -->

            {{-- Modal PENGELUARAN --}}
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
                            <form id="pengeluaranForm" enctype="multipart/form-data">
                                <div class="row gx-3">
                                    <input type="hidden" id="pengeluaran_id" name="pengeluaran_id">
                                    <div class="col-sm-12">
                                        <label class="form-label">Tanggal Pengeluaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="pengeluaran_tanggal"
                                                value="{{ date('Y-m-d') }}" id="pengeluaran_tanggal" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3 table-responsive" id="data-order">
                                    {{--  --}}
                                </div>
                                <div class="modal_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-modal">
                                        <h6>Laporan Modal</h6>
                                        <div class="col-sm-5">
                                            <label class="form-label">Keterangan</label>
                                            <div class="form-group">
                                                <input class="form-control modal_keterangan" type="text"
                                                    name="modal_keterangan[]" id="modal_keterangan" placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="form-label">Total</label>
                                            <div class="form-group">
                                                <input class="form-control modal_total" type="number"
                                                    name="modal_total[]" id="modal_total"
                                                    placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mt-5 mb-2">
                                            <button type="button" id="addBtnModal" class="btn btn-primary"><span
                                                    class="material-icons btn-md">add_circle_outline</span></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="transportasi_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-transportasi">
                                        <h6>Laporan Transportasi</h6>
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
                                <hr>
                                <div class="operasional_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-operasional">
                                        <h6>Laporan Operasional</h6>
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
                                <hr>
                                <div class="gaji_wrapper">
                                    <div class="row gx-3 table-responsive" id="data-operasional">
                                        <h6>Laporan Gaji</h6>
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
                            <h6 id="pengeluaranDetailHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="pengeluaranDetailForm">
                            <div class="modal-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    style="display: none;" style="color: red"></div>
                                <div class="row">
                                    <div class="col-md p-2 bg-grey-light-5 rounded">
                                        <div class="row align-items-center">
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Tanggal Pengeluaran:</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <input class="form-control" type="date" id="detail_pengeluaran_tanggal"
                                                    name="detail_pengeluaran_tanggal" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-responsive">
                                    <div class="col-md-12 mt-3" style="max-height:300px; overflow-y: scroll;">
                                        <h6>Data Modal</h6>
                                        <table class="table nowrap table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody id="list-modal">
                                                {{-- List Modal --}}
                                            </tbody>
                                            <tfoot id="foot-modal">
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
                                                            Modal
                                                        </td>
                                                        <td
                                                            class="rounded-top-end border-bottom-0 w-30 bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_pengeluaran_total_modal"></div>
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
                                                                id="detail_pengeluaran_total_transportasi"></div>
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
                                                                id="detail_pengeluaran_total_operasional"></div>
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
                                                                id="detail_pengeluaran_total_gaji"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            class="rounded-bottom-start border-end-0 bg-primary-light-5">
                                                            <span class="text-dark">Total Pengeluaran</span>
                                                        </td>
                                                        <td class="rounded-bottom-end  bg-primary-light-5">
                                                            <div class="form-control bg-transparent border-0 p-0 gross-total"
                                                                id="detail_pengeluaran_total"></div>
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

            {{-- Modal PENGELUARAN --}}
            <div class="modal fade" id="pengeluaranPrintModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="pengeluaranPrintHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="pengeluaranPrintForm" enctype="multipart/form-data">
                                <div class="row gx-3">
                                    <input type="hidden" id="pengeluaran_id" name="pengeluaran_id">
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Awal Pengeluaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="pengeluaran_tanggal_awal" id="pengeluaran_tanggal_awal" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Tanggal Akhir Pengeluaran</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="pengeluaran_tanggal_akhir" id="pengeluaran_tanggal_akhir" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3 table-responsive" id="data-pengeluaran">
                                    {{--  --}}
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitCetakPengeluaran">Simpan</button>
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

            var pengeluarandata = $('#pengeluaran_data').DataTable({
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pengeluaran_tanggal',
                        name: 'pengeluaran_tanggal'
                    },
                    {
                        data: 'pengeluaran_total_modal',
                        name: 'pengeluaran_total_modal'
                    },
                    {
                        data: 'pengeluaran_total_operasional',
                        name: 'pengeluaran_total_operasional'
                    },
                    {
                        data: 'pengeluaran_total_transportasi',
                        name: 'pengeluaran_total_transportasi'
                    },
                    {
                        data: 'pengeluaran_total_gaji',
                        name: 'pengeluaran_total_gaji'
                    },
                    {
                        data: 'pengeluaran_total',
                        name: 'pengeluaran_total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
            });

            // MODAL multiple input
            // max field dinamis input
            var maxField = 15; //Input fields increment limitation

            // Append Ticket Category Input
            var addButtonModal    = $('#addBtnModal'); //Add button selector
            var wrapperModal      = $('.modal_wrapper'); //Input field wrapper
            var fieldHTMLModal = `<div class="row gx-3 table-responsive" id="data-modal">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input class="form-control modal_keterangan" type="text"
                                                    name="modal_keterangan[]" id="modal_keterangan" placeholder="Masukkan Keterangan" />
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input class="form-control modal_total" type="number"
                                                    name="modal_total[]" id="modal_total"
                                                    placeholder="Masukkan Total" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-2">
                                            <button type="button" class="btn btn-danger minBtnModal"><span class="material-icons btn-md">remove_circle_outline</span></button>
                                        </div>
                                    </div>`;

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonModal).click(function() {
                //Check maximum number modal input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapperModal).append(fieldHTMLModal); //Add field html
                    if (x == 15) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Penambahan telah maksimal',
                        })
                    }
                }
            });

            //Once remove button is clicked
            $(wrapperModal).on('click', '.minBtnModal', function(e) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); //Remove field html
                x--; //Decrement field counter

                if (x == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan modal paling tidak satu!',
                    })
                }
            });

            // OPERASIONAL multiple input
            // max field dinamis input
            var maxField = 15; //Input fields increment limitation

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

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonOperasional).click(function() {
                //Check maximum number input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapperOperasional).append(fieldHTMLOperasional); //Add field html
                    if (x == 15) {
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
                x--; //Decrement field counter

                if (x == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Operasional paling tidak satu!',
                    })
                }
            });

            // GAJI multiple input
            // max field dinamis input
            var maxField = 15; //Input fields increment limitation

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


            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonGaji).click(function() {
                //Check maximum number input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapperGaji).append(fieldHTMLGaji); //Add field html
                    if (x == 15) {
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
                x--; //Decrement field counter

                if (x == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Gaji paling tidak satu!',
                    })
                }
            });

            // TRANSPORTASI multiple input
            // max field dinamis input
            var maxField = 15; //Input fields increment limitation

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

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButtonTransportasi).click(function() {
                //Check maximum number input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapperTransportasi).append(fieldHTMLTransportasi); //Add field html
                    if (x == 15) {
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
                x--; //Decrement field counter

                if (x == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Masukkan Transportasi paling tidak satu!',
                    })
                }
            });

            // Create Data Pengeluaran.
            $('#pengeluaran-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-manifest");
                $('#laporan_id').val('');
                $('#pengeluaranForm').trigger("reset");
                $('#pengeluaranHeading').html("TAMBAH DATA PENGELUARAN BARU");
                $('#pengeluaranModal').modal('show');

                $('#data-order').html('')
            });

            // Stored Data Pengeluaran.
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
                            pengeluarandata.draw();
                        }
                    }
                });
            });

            // Detail Pengeluaran
            $('body').on('click', '#pengeluaran-detail', function() {
                $('.alert').hide();
                $('#saveBtn').val("detail-manifest");
                $('#pengeluaranForm').trigger("reset");
                $('#pengeluaranDetailHeading').html("DETAIL DATA PENGELUARAN");
                $('#detailPengeluaran').modal('show');

                var pengeluaran_id = $(this).attr('data-id');
                console.log(pengeluaran_id)
                $.ajax({
                    type: "POST",
                    url: "{{ route('pengeluaran.detail') }}",
                    data: {
                        pengeluaran_id: pengeluaran_id,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        // DATA TOTAL LAPORAN
                        var pengeluaran_tanggal            = response.pengeluaran_tanggal
                        var pengeluaran_total_modal        = response.pengeluaran_total_modal
                        var pengeluaran_total_transportasi = response.pengeluaran_total_transportasi
                        var pengeluaran_total_operasional  = response.pengeluaran_total_operasional
                        var pengeluaran_total_gaji         = response.pengeluaran_total_gaji
                        var pengeluaran_total              = response.pengeluaran_total

                        $("#detail_pengeluaran_tanggal").val(pengeluaran_tanggal).prop('readonly', true)
                        $("#detail_pengeluaran_total_modal").html(rupiah(pengeluaran_total_modal))
                        $("#detail_pengeluaran_total_transportasi").html(rupiah(pengeluaran_total_transportasi))
                        $("#detail_pengeluaran_total_operasional").html(rupiah(pengeluaran_total_operasional))
                        $("#detail_pengeluaran_total_gaji").html(rupiah(pengeluaran_total_gaji))
                        $("#detail_pengeluaran_total").html(rupiah(pengeluaran_total))

                        // DATA MODAL
                        if(response.modal != null){
                            var listmodal = '';
                            var no = 1;
                            // LOOPING BARANG
                            $.each(response.modal, function(index, value) {
                                const modal_keterangan  = value['modal_keterangan']
                                const modal_total       = value['modal_total']
    
                                listmodal += `<tr>
                                                    <td>` + no++ + `</td>
                                                    <td>` + modal_keterangan + `</td>
                                                    <td>` + rupiah(modal_total) + `</td>
                                                </tr>`;
    
                            });
                            var footer_modal = `<tr>
                                                        <th colspan="2" style="text-align:center">TOTAL</th>
                                                        <th>` + rupiah(pengeluaran_total_modal) + `</th>
                                                    </tr>`;
    
                            $("#list-modal").html(listmodal)
                            $("#foot-modal").html(footer_modal)
                        }else{
                            $("#list-modal").html('')
                            $("#foot-modal").html('')
                        }

                        // DATA TRANSPORTASI
                        var listtransportasi = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.transportasi, function(index, value) {
                            const transportasi_id          = value['transportasi_id']
                            const transportasi_keterangan  = value['transportasi_keterangan']
                            const transportasi_total       = value['transportasi_total']
                            const transportasi_bukti       = value['transportasi_bukti']
                            var transportasi               = 'transportasi' + transportasi_id;

                            if(transportasi_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaran/` + transportasi + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
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
                                                        <th colspan="2">` + rupiah(pengeluaran_total_transportasi) + `</th>
                                                    </tr>`;

                        $("#list-transportasi").html(listtransportasi)
                        $("#foot-transportasi").html(footer_transportasi)

                        // DATA OPERASIONAL
                        var listoperasional = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.operasional, function(index, value) {
                            const operasional_id          = value['operasional_id']
                            const operasional_keterangan  = value['operasional_keterangan']
                            const operasional_total       = value['operasional_total']
                            const operasional_bukti       = value['operasional_bukti']
                            var operasional               = 'operasional' + operasional_id;

                            if(operasional_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaran/` + operasional + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
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
                                                        <th colspan="2">` + rupiah(pengeluaran_total_operasional) + `</th>
                                                    </tr>`;

                        $("#list-operasional").html(listoperasional)
                        $("#foot-operasional").html(footer_operasional)

                        // DATA GAJI
                        var listgaji = '';
                        var no = 1;
                        // LOOPING BARANG
                        $.each(response.gaji, function(index, value) {
                            const gaji_id          = value['gaji_id']
                            const gaji_keterangan  = value['gaji_keterangan']
                            const gaji_total       = value['gaji_total']
                            const gaji_bukti       = value['gaji_bukti']
                            var gaji               = 'gaji' + gaji_id;

                            if(gaji_bukti != '-'){
                                var button = ` <a href="downloadBuktiPengeluaran/` + gaji + `" class="btn btn-primary" id="buktiPengeluaran" target="_blank" download>Download Bukti</a>`;
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
                                                <th colspan="2">` + rupiah(pengeluaran_total_gaji) + `</th>
                                            </tr>`;

                        $("#list-gaji").html(listgaji)
                        $("#foot-gaji").html(footer_gaji)
                    }
                });
            })

            // Get pengeluaran data based on tanggal
            $('body').on('input', '#pengeluaran_tanggal_awal, #pengeluaran_tanggal_akhir', function() {
                var tanggal_awal = $('#pengeluaran_tanggal_awal').val()
                var tanggal_akhir = $('#pengeluaran_tanggal_akhir').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('pengeluaran.get.data') }}",
                    data: {
                        pengeluaran_tanggal_awal: tanggal_awal,
                        pengeluaran_tanggal_akhir: tanggal_akhir,
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
                            $('#data-pengeluaran').html('')
                            var table = `<h6>No Data Avalilable</h6>`;
                            $('#data-pengeluaran').html(table)
                            console.log(response.error)
                        } else {
                            if (response.data.length > 0) {
                                var table = `<h6>Data Pengeluaran</h6>
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

                                var listpengeluaran = '';
                                var no = 1;
                                // LOOPING BARANG
                                $.each(response.data, function(index, value) {
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

                                var total             = response.total
                                var sisa_saldo        = response.sisa_saldo
                                var tfoot_pengeluaran = '';
                                tfoot_pengeluaran    += `<tr>
                                                            <td colspan="5" style="text-align:right;">Total</td>
                                                            <td> <input class="form-control" type="hidden" name="pengeluaran_total"
                                                            id="pengeluaran_total" value="`+total+`" />
                                                            <input class="form-control" type="hidden" name="pengeluaran_sisa_saldo"
                                                            id="pengeluaran_sisa_saldo" value="`+sisa_saldo+`" /></td>
                                                            <td>` + rupiah(total) + `</td>
                                                        </tr>`;

                                $('#data-pengeluaran').html(table)
                                $("#list-pengeluaran").html(listpengeluaran)
                                $("#total-pengeluaran").html(tfoot_pengeluaran)

                            } else {
                                var table = `<h6>No Data Avalilable</h6>`;
                                $('#data-pengeluaran').html(table)
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors here if needed
                        console.log(xhr.responseText);
                    }
                });

            })

            // Print Laporan
            $('body').on('click', '#pengeluaran-print', function() {

                $('.alert').hide();
                $('#saveBtn').val("detail-manifest");
                $('#pengeluaranPrintForm').trigger("reset");
                $('#pengeluaranPrintHeading').html("PRINT DATA PENGELUARAN");
                $('#pengeluaranPrintModal').modal('show');
                $('#data-pengeluaran').html('')

                var tanggal_awal  = $('#pengeluaran_tanggal_awal').val()
                var tanggal_akhir = $('#pengeluaran_tanggal_akhir').val()
            });

            // Print Laporan
            $('#submitCetakPengeluaran').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                
                var tanggal_awal  = $('#pengeluaran_tanggal_awal').val();
                var tanggal_akhir = $('#pengeluaran_tanggal_akhir').val();
                
                // Perform validation
                if (tanggal_awal === '') {
                    // Display the error message using Swal.fire
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanggal awal harus di isi!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $('#submitCetakPengeluaran').html('Simpan');
                    return;
                }

                if (tanggal_akhir === '') {
                    // Display the error message using Swal.fire
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanggal akhir harus di isi!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $('#submitCetakPengeluaran').html('Simpan');
                    return;
                }

                // Create the URL with query parameters
                var url = "{{ route('pengeluaran.print') }}?tanggal_awal=" + tanggal_awal + "&tanggal_akhir=" + tanggal_akhir;

                // Open the PDF in a new tab/window
                window.open(url, '_blank');
                
                // Reset form and perform other actions
                $('#pengeluaranPrintForm').trigger("reset");
                $('#submitCetakPengeluaran').html('Simpan');
                $('#pengeluaranPrintModal').modal('hide');
            });


        })
    </script>
@endpush
