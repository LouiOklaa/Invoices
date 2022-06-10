@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل فاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <td>{{$invoices->invoice_number}}</td>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <td>{{$invoices->invoice_Date}}</td>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <td>{{$invoices->due_date}}</td>
                                                        <th scope="row">القسم</th>
                                                        <td>{{$invoices->section->section_name}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">المنتج</th>
                                                        <td>{{$invoices->product}}</td>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <td>{{$invoices->amount_collection}}</td>
                                                        <th scope="row">مبلغ العمولة</th>
                                                        <td>{{$invoices->amount_commission}}</td>
                                                        <th scope="row">الخصم</th>
                                                        <td>{{$invoices->discount}}</td>
                                                    </tr>


                                                    <tr>
                                                        <th scope="row">نسبة الضريبة</th>
                                                        <td>{{$invoices->rate_VAT}}</td>
                                                        <th scope="row">قيمة الضريبة</th>
                                                        <td>{{$invoices->value_VAT}}</td>
                                                        <th scope="row">الاجمالي مع الضريبة</th>
                                                        <td>{{$invoices->total}}</td>
                                                        <th scope="row">الحالة الحالية</th>
                                                        <td>
                                                            @if ($invoices->value_status == 1)
                                                                <label class="badge badge-success">{{$invoices->status}}</label>
                                                            @elseif($invoices->value_status == 2)
                                                                <label class="badge badge-danger">{{$invoices->status}}</label>
                                                            @else
                                                                <label class="badge badge-warning">{{$invoices->status}}</label>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">ملاحظات</th>
                                                        <td>لا يوجد</td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                       style="text-align:center">
                                                    <thead>
                                                    <tr class="text-dark">
                                                        <th>ID</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>نوع المنتج</th>
                                                        <th>القسم</th>
                                                        <th>حالة الدفع</th>
                                                        <th>تاريخ الدفع</th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الاضافة</th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i=0?>
                                                    @foreach($details as $one)
                                                    <?php $i++?>
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$one->invoice_number}}</td>
                                                            <td>{{$one->product}}</td>
                                                            <td>{{$invoices->section->section_name}}</td>
                                                            <td>
                                                                @if ($one->value_status == 1)
                                                                    <label class="badge badge-success">{{$one->status}}</label>
                                                                @elseif($one->value_status == 2)
                                                                    <label class="badge badge-danger">{{$one->status}}</label>
                                                                @else
                                                                    <label class="badge badge-warning" style="color: white;">{{$one->status}}</label>
                                                                @endif
                                                            </td>
                                                            <td>{{$one->payment_date}}</td>
                                                            <td>{{$one->note}}</td>
                                                            <td>{{$one->created_at}}</td>
                                                            <td>{{$one->user}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--Attachments-->
                                            <div class="card card-statistics">
                                                    <div class="card-body">
                                                        @can('اضافة مرفق')
                                                           <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                           <h5 class="card-title">اضافة مرفقات</h5>
                                                           <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                                 enctype="multipart/form-data">
                                                               {{ csrf_field() }}
                                                               <div class="custom-file">
                                                                   <input type="file" class="custom-file-input" id="customFile"
                                                                          name="file_name" required>
                                                                   <input type="hidden" id="customFile" name="invoice_number"
                                                                          value="{{$one->invoice_number}}">
                                                                   <input type="hidden" id="invoice_id" name="invoice_id"
                                                                          value="{{$one->invoice_id}}">
                                                                   <label class="custom-file-label" for="customFile">حدد
                                                                       المرفق</label>
                                                               </div><br><br>
                                                               <button type="submit" class="btn btn-primary btn-sm "
                                                                       name="uploadedFile">تاكيد</button>
                                                           </form>
                                                        @endcan
                                                    </div>
                                                <br>

                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                           style="text-align:center">
                                                        <thead>
                                                        <tr class="text-dark">
                                                            <th scope="col">م</th>
                                                            <th scope="col">اسم الملف</th>
                                                            <th scope="col">قام بالاضافة</th>
                                                            <th scope="col">تاريخ الاضافة</th>
                                                            <th scope="col">العمليات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($attachments as $one)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <td> {{$i}}</td>
                                                                <td>{{$one->file_name}}</td>
                                                                <td>{{$one->created_by}}</td>
                                                                <td>{{$one->created_at}}</td>
                                                                <td colspan="2">
                                                                    @can('عرض مرفق')
                                                                        <a class="btn btn-success btn-sm" style="color: white;" href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $one->file_name }}" role="button"><i class="fas fa-eye"></i>&nbsp;عرض</a>
                                                                    @endcan
                                                                    @can('تحميل مرفق')
                                                                       <a class="btn btn-info btn-sm" style="color: white;" href="{{ url('Download_file') }}/{{ $invoices->invoice_number }}/{{ $one->file_name }}" role="button"><i class="fas fa-download"></i>&nbsp;تحميل</a>
                                                                    @endcan
                                                                    @can('حذف مرفق')
                                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-file_name="{{ $one->file_name }}" data-invoice_number="{{ $one->invoice_number }}" data-id_file="{{ $one->id }}" data-target="#delete_file">حذف</button>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                </div>
            </div>
            <!-- /div -->
        </div>
    </div>
    <!-- /row -->

    <!-- Start Delete Modal -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('Delete_file') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center"> <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6></p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

    <!-- Container -->
    </div>
    <!-- Container closed -->
    <!-- main-content -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

@endsection
