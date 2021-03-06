@extends('layouts.master')

@section('title')
    اضافة مستخدم - لؤي سوفت
@stop

@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة مستخدم</span>
            </div>
        </div>
        <div class="mb-3 mb-xl-0">
            <a class="btn btn-danger-gradient btn-rounded btn-sm" href="{{ url()->previous() }}">رجوع</a>
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

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('users.store','test')}}" method="post" autocomplete="off">
                        {{csrf_field()}}
                        <div class="">
                            <div class="row mg-b-20">
                                <div class="col-md-6">
                                    <label>اسم المستخدم :</label>
                                    <input class="form-control mg-b-20" name="name" type="text">
                                </div>

                                <div class="col-md-6 mg-t-20 mg-md-t-0">
                                    <label>البريد الالكتروني :</label>
                                    <input class="form-control mg-b-20" name="email" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>كلمة المرور : </label>
                                <input class="form-control mg-b-20" name="password" type="password">
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> تاكيد كلمة المرور :</label>
                                <input class="form-control mg-b-20" name="confirm-password" type="password">
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label class="form-label">حالة المستخدم</label>
                                <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="مفعل">مفعل</option>
                                    <option value="غير مفعل">غير مفعل</option>
                                </select>
                            </div>

                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <div class="form-group">
                                    <label class="form-label"> صلاحية المستخدم</label>
                                    {!! Form::select('role_name', $roles,[], array('class' => 'form-control nice-select  custom-select')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection
