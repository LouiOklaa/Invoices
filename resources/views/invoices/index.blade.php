@extends('layouts.master')
@section('title')
    قائمة الفواتير
@endsection

@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('status_update'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('status_update') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete_invoice'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('delete_invoice') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit_invoice'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('edit_invoice') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('restore_invoice'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('restore_invoice') }}</strong>
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
                        <a class="modal-effect btn btn-primary btn-block" href="invoices/create"><i
                                class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
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
                                    <a href="{{ url('InvoicesDetails') }}/{{ $one->id }}">{{$one->invoice_number}}</a>
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
                                        <label class="badge badge-warning">{{$one->status}}</label>
                                    @endif
                                </td>
                                <td>{{$one->note}}</td>
                                <td>
                                    <div class="dropdown ">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-rounded btn-sm btn-primary"
                                                data-toggle="dropdown" id="dropdownMenuButton" type="button">&nbsp العمليات &nbsp<i class="fas fa-caret-down ml-1"></i></button>
                                        <div  class="dropdown-menu tx-10">
                                            <a class="dropdown-item bg-primary text-white" href="{{url('edit_invoice')}}/{{$one->id}}">تعديل الفاتورة</a>
                                            <a class="dropdown-item bg-primary text-white" href="#" data-toggle="modal" data-target="#delete_invoice" data-invoice_id="{{$one->id}}" >حذف الفاتورة</a>
                                            <a class="dropdown-item bg-primary text-white" href="{{ URL::route('status_show', [$one->id]) }}" >تغيير حالة الدفع</a>
                                            <a class="dropdown-item bg-primary text-white" href="#" data-toggle="modal" data-target="#transfer_invoice" data-invoice_id="{{$one->id}}" >نقل الى الارشيف</a>
                                            <a class="dropdown-item bg-primary text-white" href="Print_Invoice/{{ $one->id }}">طباعة الفاتورة</a>
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
                <form action="{{ route('invoices.destroy', 'test' ) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        هل انت متاكد من عملية الحذف ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('invoices.destroy', 'test' ) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        هل انت متاكد من عملية الارشفة ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="hidden" name="page_id" id="page_id" value="2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Transfer Modal -->

@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
