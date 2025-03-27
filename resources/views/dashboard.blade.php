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
                            <h1 class="pg-title">Welcome back</h1>
                            <p>Hello, {{ Auth::user()->name }}!</p>
                        </div>
                        <div class="pg-header-action-wrap">
                            <div class="input-group w-300p">
                                <span class="input-affix-wrapper">
                                    <div class="" id="clock"></div>
                                    <div>&nbsp;</div>
                                    <div id="date"></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            @if (Auth::user()->role == 'superadmin')
                <!-- Page Body -->
                <div class="hk-pg-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data_order">
                            <div class="row">
                                <form id="filterForm">
                                    <div class="col-sm p-3 bg-grey-light-5 rounded">
                                        <div class="row align-items-center">
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Filter by Bulan :</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <select class="form-control" name="month">
                                                    <option value="">Select Month</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $filterMonth == $i ? 'selected' : '' }}>
                                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <label class="form-label mb-xl-0">Filter by Tahun :</label>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <select class="form-control" name="year">
                                                    <option value="">Select Year</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                        $numberOfYears = 2; // You can adjust this as needed
                                                    @endphp

                                                    {{-- @for ($i = $currentYear + $numberOfYears; $i >= $currentYear; $i--)
                                                        <option value="{{ $i }}"
                                                            {{ $filterYear == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor --}}
                                                    @for ($i = $currentYear - 4; $i < $currentYear + $numberOfYears; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $filterYear == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <button class="btn btn-sm btn-primary" type="submit" id="submitFilter">
                                                    <span>
                                                        <span class="icon">
                                                            <span class="feather-icon">
                                                                <i data-feather="calendar"></i>
                                                            </span>
                                                        </span>
                                                        <span class="btn-text">Tampilkan</span></span>
                                                </button>
                                            </div>
                                            <div class="col-xl-auto mb-xl-0 mb-2">
                                                <button class="btn btn-sm btn-primary" id="resetFilter">
                                                    <span>
                                                        <span class="icon">
                                                            <span class="feather-icon">
                                                                <i data-feather="refresh-cw"></i>
                                                            </span>
                                                        </span>
                                                        <span class="btn-text">Reset</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Order Belum Terbayar
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <h1 id="pendingOrder">Rp {{ number_format($data['pendingOrder']) }}
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Order Sudah Terbayar
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="settleOrder">Rp {{ number_format($data['settleOrder']) }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Piutang Surabaya
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <h1 id="piutangSurabaya">Rp
                                                        {{ number_format($data['piutangSurabaya']) }}
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Piutang Makassar
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="piutangMakassar">Rp {{ number_format($data['piutangMakassar']) }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Pengeluaran Surabaya
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <h1 id="pengeluaranSurabaya">Rp
                                                        {{ number_format($data['pengeluaranSby']) }}
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Pengeluaran Makassar
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="pengeluaranMakassar">Rp
                                                    {{ number_format($data['pengeluaranMks']) }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Pendapatan Bersih</h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="totalOrder">Rp {{ number_format($data['totalOrder']) }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Order Global</h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="totalOrderGlobal">Rp {{ number_format($data['totalOrderGlobal']) }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Body -->
                </div>
            @endif


            <!-- Page Footer -->
            @include('layouts.footer')
            <!-- / Page Footer -->

        </div>
        <!-- /Main Content -->
    @endsection

    @push('script-alt')
        <script>
            function updateClockAndDate() {
                const clockElement = document.getElementById('clock');
                const dateElement = document.getElementById('date');
                const now = new Date();

                // Update the clock
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeString = `${hours}:${minutes}:${seconds}`;
                clockElement.textContent = timeString;

                // Update the date
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const dateString = `${day}/${month}/${year}`;
                dateElement.textContent = dateString;
            }

            // Call the function to update the clock and date every second
            setInterval(updateClockAndDate, 1000);

            // Initial update
            updateClockAndDate();

            // FORMAT CURRENCY
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('#submitFilter').on('click', function(e) {
                    e.preventDefault(); // Prevent form submission
                    fetchFilteredData();
                });

                $('#resetFilter').on('click', function(e) {
                    e.preventDefault(); // Prevent button default behavior
                    fetchAllTimeData();
                });

                function fetchFilteredData() {
                    // Send AJAX request
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('dashboard.filter') }}',
                        data: $('#filterForm').serialize(), // Serialize form data
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            // Update card content with filtered data
                            updateCardContent(response);
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                }

                function fetchAllTimeData() {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('dashboard.reset.filter') }}', // Update route to match your controller method
                        dataType: 'json',
                        success: function(response) {
                            updateCardContent(response);
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                }

                function updateCardContent(data) {
                    $('#pendingOrder').text(rupiah(data.pendingOrder));
                    $('#piutangSurabaya').text(rupiah(data.piutangSurabaya));
                    $('#piutangMakassar').text(rupiah(data.piutangMakassar));
                    $('#settleOrder').text(rupiah(data.settleOrder));
                    $('#totalOrder').text(rupiah(data.totalOrder));
                    $('#totalOrderGlobal').text(rupiah(data.totalOrderGlobal));
                    $('#pengeluaranSurabaya').text(rupiah(data.pengeluaranSby))
                    $('#pengeluaranMakassar').text(rupiah(data.pengeluaranMks))
                }
            });
        </script>
    @endpush
