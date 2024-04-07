@extends('layouts.master')

@section('title')
    تعديل مستخدم - لؤي سوفت
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
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / تعديل مستخدم</span>
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
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="">
                        <div class="row mg-b-20">
                            <div class="col-md-6">
                                <label>اسم المستخدم :</label>
                                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                            </div>

                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label>البريد الالكتروني :</label>
                                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label>كلمة المرور :</label>
                            {!! Form::password('password', array('class' => 'form-control')) !!}
                        </div>

                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label>تاكيد كلمة المرور :</label>
                            {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label class="form-label">حالة المستخدم</label>
                            @if ($user->role_name !== 'Owner')
                                <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="{{ $user->status}}">{{ $user->status}}</option>
                                        @if($user->status == "غير مفعل")
                                        <option value="مفعل">مفعل</option>
                                        @else
                                        <option value="غير مفعل">غير مفعل</option>
                                        @endif
                                </select>
                            @else
                                {!! Form::text('status', null, array('class' => 'form-control nice-select  custom-select disabled')) !!}
                            @endif
                        </div>

                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <div class="form-group">
                                <label class="form-label">نوع المستخدم</label>
                                @if ($user->role_name !== 'Owner')
                                 {!! Form::select('role_name', $roles ,$userRole, array('class' => 'form-control nice-select  custom-select'))!!}
                                @else
                                 {!! Form::select('role_name', $roles ,$userRole, array('class' => 'form-control nice-select  custom-select disabled'))!!}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mg-t-30 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                    </div>
                    {!! Form::close() !!}
                </div>
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
