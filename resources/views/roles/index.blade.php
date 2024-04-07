@extends('layouts.master')

@section('title')
    صلاحيات المستخدمين - لؤي سوفت
@stop

@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / صلاحيات المستخدمين</span>
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

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>&nbsp &nbsp &nbsp &nbsp{{ session()->get('Delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                @can('اضافة صلاحية')
                                    <a class="btn btn-rounded btn-primary btn-block" href="{{ route('roles.create') }}"><i class="fas fa-plus"></i>&nbsp; اضافة صلاحية</a>
                                @endcan
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>الاسم</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0?>
                                @foreach ($roles as $key => $role)
                                    <?php $i ++?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('عرض صلاحية')
                                                <a class="btn btn-rounded btn-success btn-sm"
                                                   href="{{ route('roles.show', $role->id) }}">عرض</a>
                                            @endcan

                                            @if ($role->name !== 'Owner')
                                                @can('تعديل صلاحية')
                                                    <a class="btn btn-rounded btn-info btn-sm"
                                                       href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                                @endcan

                                                @can('حذف صلاحية')
                                                    <button class="btn btn-rounded btn-sm btn btn-danger" data-role_id="{{ $role->id }}" title="حذف" data-role_name="{{ $role->name }}" href="#delete_modal" data-toggle="modal">حذف</button>
                                                @endcan
                                            @endif
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

        {{--  Start Delete Modal  --}}
        <div class="modal fade" id="delete_modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف الصلاحية</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="roles/destroy" method="post">
                        {{method_field('delete')}}
                        {{csrf_field()}}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="role_id" id="role_id" value="">
                            <input class="form-control" name="role_name" id="role_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-danger">تاكيد</button>
                            <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--  End Delete Modal  --}}

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    {{--  Delete Modal Script  --}}
    <script>
        $('#delete_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var role_id = button.data('role_id')
            var role_name = button.data('role_name')
            var modal = $(this)
            modal.find('.modal-body #role_id').val(role_id);
            modal.find('.modal-body #role_name').val(role_name);
        })
    </script>
@endsection
