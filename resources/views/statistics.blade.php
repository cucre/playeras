@extends('layouts.master')

@section('page-header')
    Estadísticas de venta
@endsection

@push('customcss')
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
@endpush

@push('customjs')
    <script src="/assets/plugins/moment/min/moment.min.js"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript">
        var handleDateRangeFilter = function() {
            $('#daterange-filter span').html(moment().subtract('days', 7).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));
            $('#daterange-prev-date').html(moment().subtract('days', 15).format('D MMMM') + ' - ' + moment().subtract('days', 8).format('D MMMM YYYY'));

            $('#daterange-filter').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(7, 'days'),
                endDate: moment(),
                minDate: '01/06/2020',
                maxDate: '07/06/2020',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Último Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' a ',
                locale: {
                    applyLabel: 'Enviar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'De',
                    toLabel: 'Hast',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                $('#daterange-filter span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
                
                var gap = end.diff(start, 'days');
                $('#daterange-prev-date').html(moment(start).subtract('days', gap).format('D MMMM') + ' - ' + moment(start).subtract('days', 1).format('D MMMM YYYY'));
            });
        };

        var DashboardV3 = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDateRangeFilter();
                }
            };
        }();

        $(document).ready(function() {
            DashboardV3.init();

            $("#year").change(function(){
                location.href = '{{ route('statistics.index') }}?year=' + $(this).val();
            });
        });
    </script>
@endpush


@section('content')
<div class="row col-lg-2">
    <label class="label-control">Año</label>
    <select class="form-control btn-inverse" id="year">
        @for($i = date('Y'); $i>=date('Y')-3;$i--)
            <option value="{{ $i }}"@if(request()->year == $i) selected @endif>{{ $i }}</option>
        @endfor
    </select>
</div>
<br>
{{-- <div class="d-sm-flex align-items-center mb-3">
    <a href="#" class="btn btn-inverse mr-2 text-truncate" id="daterange-filter">
        <i class="fa fa-calendar fa-fw text-white-transparent-5 ml-n1"></i> 
        <span>1 Jun 2020 - 7 Jun 2020</span>
        <b class="caret"></b>
    </a>
    <div class="text-muted f-w-600 mt-2 mt-sm-0">compared to <span id="daterange-prev-date">24 Mar-30 Apr 2020</span></div>
</div> --}}
<div class="row">
    <!-- begin col-6 -->
    <div class="col-xl-6">
        <!-- begin card -->
        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <!-- begin card-body -->
            <div class="card-body">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-7 -->
                    <div class="col-xl-7 col-lg-8">
                        <!-- begin title -->
                        <div class="mb-3 text-grey">
                            <b>TOTAL DE VENTAS</b>
                            <span class="ml-2">
                                {{-- <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Total sales" data-placement="top" data-content="Total de ventas por año."></i> --}}
                            </span>
                        </div>
                        <!-- end title -->
                        <!-- begin total-sales -->
                        <div class="d-flex mb-1">
                            <h2 class="mb-0">
                                <span @if((($totalVendedor['vendido'] + $totalDirecto['vendido']) - $inventory['ENTRADA']) < 0)class="text-danger" @else class="text-success" @endif>$</span><span @if((($totalVendedor['vendido'] + $totalDirecto['vendido']) - $inventory['ENTRADA']) < 0)class="text-danger" @else class="text-success"  @endif data-animation="number" data-value="{{ abs(($totalVendedor['vendido'] + $totalDirecto['vendido']) - $inventory['ENTRADA']) }}">
                                    0.00
                                </span>
                            </h2>
                            <div class="ml-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
                        </div>
                        <!-- end total-sales -->
                        <!-- begin percentage -->
                        <div class="mb-3 text-grey">
                            <i class="fa fa-caret-up"></i> {{-- <span data-animation="number" data-value="33.21">0.00</span> --}}
                            Ganancias del año 2020
                        </div>
                        <!-- end percentage -->
                        <hr class="bg-white-transparent-2" />
                        <!-- begin row -->
                        <div class="row text-truncate">
                            <!-- begin col-6 -->
                            <div class="col-6">
                                <div class="f-s-12 text-grey">Total invertido</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1">
                                    $<span data-animation="number" data-value="{{ $inventory['ENTRADA'] }}">0</span>
                                </div>
                                <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                    <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- end col-6 -->
                            <!-- begin col-6 -->
                            <div class="col-6">
                                <div class="f-s-12 text-grey">Total vendido</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1">$<span data-animation="number" data-value="{{ ($totalVendedor['vendido'] + $totalDirecto['vendido']) + $devoluciones['SALIDA'] }}">0.00</span></div>
                                <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                    <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="55%" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- end col-6 -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end col-7 -->
                    <!-- begin col-5 -->
                    <div class="col-xl-5 col-lg-4 align-items-center d-flex justify-content-center">
                        <img src="../assets/img/svg/img-1.svg" height="150px" class="d-none d-lg-block" />
                    </div>
                    <!-- end col-5 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col-6 -->
    <!-- begin col-6 -->
    <div class="col-xl-6">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-sm-6">
                <!-- begin card -->
                <div class="card border-0 text-truncate mb-3 bg-dark text-white">
                    <!-- begin card-body -->
                    <div class="card-body">
                        <!-- begin title -->
                        <div class="mb-3 text-grey">
                            <b class="mb-3">VENTAS DE VENDEDORES</b> 
                            <span class="ml-2">{{-- <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Conversion Rate" data-placement="top" data-content="" data-original-title="" title=""></i> --}}</span>
                        </div>
                        <!-- end title -->
                        <!-- begin conversion-rate -->
                        <div class="d-flex align-items-center mb-1">
                            <h2 class="text-white mb-0">$<span data-animation="number" data-value="{{ $totalVendedor['vendido'] - $totalVendedor['invertido'] }}">0.00</span></h2>
                            <div class="ml-auto">
                                <div id="conversion-rate-sparkline"></div>
                            </div>
                        </div>
                        <!-- end conversion-rate -->
                        <!-- begin percentage -->
                        <div class="mb-4 text-grey">
                            <i class="fa fa-caret-up"></i> Ganancia por ventas de vendedores
                        </div>
                        <!-- end percentage -->
                        <!-- begin info-row -->
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-red f-s-8 mr-2"></i>
                                Inversión
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600">$<span data-animation="number" data-value="{{ $totalVendedor['invertido'] }}">0.00</span></div>
                            </div>
                        </div>
                        <!-- end info-row -->
                        <!-- begin info-row -->
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-warning f-s-8 mr-2"></i>
                                Ventas por vendedor
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600">
                                    $<span data-animation="number" data-value="{{ $totalVendedor['vendido'] }}">0.00</span>
                                </div>
                            </div>
                        </div>
                        <!-- end info-row -->
                        <!-- begin info-row -->
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-lime f-s-8 mr-2"></i>
                                Porcentaje
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600">
                                    <span data-animation="number" data-value="{{ $porcentaje['vendedores'] }}">
                                        0.00
                                    </span>%
                                </div>
                            </div>
                        </div>
                        <!-- end info-row -->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-6 -->
            <!-- begin col-6 -->
            <div class="col-sm-6">
                <!-- begin card -->
                <div class="card border-0 text-truncate mb-3 bg-dark text-white">
                    <!-- begin card-body -->
                    <div class="card-body">
                        <!-- begin title -->
                        <div class="mb-3 text-grey">
                            <b class="mb-3">VENTAS DIRECTAS</b> 
                            <span class="ml-2">{{-- <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Store Sessions" data-placement="top" data-content="" data-original-title="" title=""></i> --}}</span>
                        </div>
                        <!-- end title -->
                        <!-- begin store-session -->
                        <div class="d-flex align-items-center mb-1">
                            <h2 class="text-white mb-0">$<span data-animation="number" data-value="{{ $totalDirecto['vendido'] - $totalDirecto['invertido'] }}">0</span></h2>
                            <div class="ml-auto">
                                <div id="store-session-sparkline"></div>
                            </div>
                        </div>
                        <!-- end store-session -->
                        <!-- begin percentage -->
                        <div class="mb-4 text-grey">
                            <i class="fa fa-caret-up"></i> Ganancia por ventas directas
                        </div>
                        <!-- end percentage -->
                        <!-- begin info-row -->
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-teal f-s-8 mr-2"></i>
                                Inversión
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600">$<span data-animation="number" data-value="{{ $totalDirecto['invertido'] }}">0</span></div>
                            </div>
                        </div>
                        <!-- end info-row -->
                        <!-- begin info-row -->
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-blue f-s-8 mr-2"></i>
                                Ventas directas 
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600">$<span data-animation="number" data-value="{{ $totalDirecto['vendido'] }}">0</span></div>
                            </div>
                        </div>
                        <!-- end info-row -->
                        <!-- begin info-row -->
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-aqua f-s-8 mr-2"></i>
                                Porcentaje
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"></div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="{{ $porcentaje['directo'] }}">0</span>%</div>
                            </div>
                        </div>
                        <!-- end info-row -->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end col-6 -->
</div>

<div class="row">
    <div class="col-sm-5">
        <!-- begin card -->
        <div class="card border-0 text-truncate mb-3 bg-dark text-white">
            <!-- begin card-body -->
            <div class="card-body">
                <!-- begin title -->
                <div class="mb-3 text-grey">
                    <b class="mb-3">VENTAS MENSUALES</b> 
                    <span class="ml-2">{{-- <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Store Sessions" data-placement="top" data-content="" data-original-title="" title=""></i> --}}</span>
                </div>
                <div class="d-flex mb-2">
                    <div class="d-flex align-items-center">
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="text-grey f-s-11"></div>
                        <div class="width-50 text-center pl-2 f-w-600">Entradas</div>
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="text-grey f-s-11"></div>
                        <div class="width-50 text-center pl-2 f-w-600">Salidas</div>
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="text-grey f-s-11"></div>
                        <div class="width-50 text-center pl-2 f-w-600">Total</div>
                    </div>
                </div>
                @foreach($monthly as $month => $data)

                    @php($dentrada = isset($data['DEVOLUCIÓN']['ENTRADA']) ? $data['DEVOLUCIÓN']['ENTRADA'] : 0 )
                    @php($dsalida = isset($data['DEVOLUCIÓN']['SALIDA']) ? $data['DEVOLUCIÓN']['SALIDA'] : 0 )
                
                    @php($entrada = isset($data['ENTRADA']) ? $data['ENTRADA'] : 0)
                    @php($salida = isset($data['SALIDA']) ? $data['SALIDA'] : 0)

                    <div class="d-flex mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-circle text-white f-s-8 mr-2"></i>
                            {{ $month }}
                        </div>
                        <div class="d-flex align-items-center ml-auto">
                            <div class="text-grey f-s-11"></div>
                            <div class="text-right pl-2 f-w-600">$<span data-animation="number" data-value="{{ $entrada + $dentrada }}">0</span></div>
                        </div>
                        <div class="d-flex align-items-center ml-auto">
                            <div class="text-grey f-s-11"></div>
                            <div class="text-right pl-2 f-w-600">$<span data-animation="number" data-value="{{ $salida - $dsalida }}">0</span></div>
                        </div>
                        <div class="d-flex align-items-center ml-auto">
                            <div class="text-grey f-s-11"></div>
                            @php($total = ($salida - $dsalida) - ($entrada + $dentrada))
                            <div class="text-right pl-2 f-w-600 {{ $total > 0 ? 'text-success' : 'text-danger' }}">$<span data-animation="number" data-value="{{ abs( $total) }}">0</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
</div>
        
@endsection