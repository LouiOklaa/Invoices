@extends('layouts.master')

@section('title')
    الفواتير المؤرشفة - لؤي سوفت
@stop

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ أرشيف الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (session()->has('archive'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('archive') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        @can('تصدير EXCEL')
                            <a class="modal-effect btn btn-rounded btn-success btn-block" href="{{ url('Export_Invoices') }}/{{ 5 }}">
                                <i class="fas fa-file-download"></i>&nbsp; تصدير EXCEL</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">ID</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0?>
                                @foreach($invoices as $one)
                                    <?php $i ++?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <a @can('عرض تفاصيل فاتورة') href="{{ url('InvoicesDetails') }}/{{ $one->id }}" @endcan">{{$one->invoice_number}}</a>
                                        </td>
                                        <td>{{$one->invoice_Date}}</td>
                                        <td>{{$one->due_date}}</td>
                                        <td>{{$one->product}}</td>
                                        <td>{{$one->section->section_name}}</td>
                                        <td>{{$one->discount}}</td>
                                        <td>{{$one->rate_VAT}}</td>
                                        <td>{{$one->value_VAT}}</td>
                                        <td>{{$one->total}}</td>
                                        <td>
                                            @if ($one->value_status == 1)
                                                <label class="badge badge-success">{{$one->status}}</label>
                                            @elseif($one->value_status == 2)
                                                <label class="badge badge-danger">{{$one->status}}</label>
                                            @else
                                                <label class="badge badge-warning" style="color: white;">{{$one->status}}</label>
                                            @endif
                                        </td>
                                        @if($one->note == NULL)
                                            <td style="text-align: center; color: #BEC1C8">---</td>
                                        @else
                                            <td style="text-align: center">{{$one->note}}</td>
                                        @endif
                                        <td>
                                            <div class="dropdown ">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-rounded btn-sm btn-primary"
                                                        data-toggle="dropdown" id="dropdownMenuButton" type="button">&nbsp العمليات &nbsp<i class="fas fa-caret-down ml-1"></i></button>
                                                <div  class="dropdown-menu tx-10">
                                                    @can('استعادة الفاتورة')
                                                       <a class="dropdown-item bg-primary text-white" href="#" data-toggle="modal" data-target="#transfer_invoice" data-invoice_id="{{$one->id}}" data-invoice_number="{{$one->invoice_number}}">نقل الى قائمة الفواتير</a>
                                                    @endcan
                                                    @can('حذف فاتورة مؤرشفة')
                                                        <a class="dropdown-item bg-primary text-white" href="#" data-toggle="modal" data-target="#delete_invoice" data-invoice_id="{{$one->id}}" data-invoice_number="{{$one->invoice_number}}">حذف الفاتورة</a>
                                                    @endcan
                                                    @can('طباعةالفاتورة')
                                                        <a class="dropdown-item bg-primary text-white" href="Print_Invoice/{{ $one->id }}">طباعة الفاتورة</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->

    <!-- Start Delete Modal -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('Invoices_Archive.destroy', 'test' ) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-danger">تاكيد</button>
                        <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

    <!-- Start Transfer Modal -->
    <div class="modal fade" id="transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">الغاء ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('Invoices_Archive.update', 'test' ) }}" method="post">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الغاء الارشفة ؟</p>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Transfer Modal -->

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Delete Modal Script -->
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
    <!--Restore Modal Script -->
    <script>
        $('#transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>

@endsection
