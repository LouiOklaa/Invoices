@extends('layouts.master')

@section('title')
    كل الاشعارات - لؤي سوفت
@endsection

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex"><h4 class="content-title mb-0 my-auto">الاشعارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كل الاشعارات</span></div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
        <div class="col-xl-12">
            <div class="card">
                <div class="main-content-body main-content-body-mail card-body">
                    <div class="main-mail-header">
                        <button class="btn btn-rounded btn-primary btn-block">كل الاشعارات</button>
                    </div><!-- main-mail-list-header -->
                    <div class="main-mail-options">
                        <label></label>
                        <div class="btn-group">
                            <p class="text-gray" style="margin-top: 20px;">لديك <i class="rounded-circle bg-danger-gradient text-white">&nbsp &nbsp{{ auth()->user()->unreadNotifications->count() }}&nbsp &nbsp</i> اشعارات غير مقروءة</p>
                        </div><!-- btn-group -->
                    </div><!-- main-mail-options -->
                    <div class="main-mail-list">
                        @foreach (auth()->user()->Notifications as $one)
                            @if($one->read_at == NULL)
                                <a class="main-mail-item" href="/MarkAsRead">
                                    <div class="">
                                        <img alt="user-img" class="avatar avatar-md" src="{{URL::asset('assets/img/faces/6.jpg')}}">
                                    </div>
                                    <div class="main-mail-body">
                                        <div class="main-mail-from">
                                            {{ $one->data['user'] }} <i class="badge badge-danger">جديد</i>
                                        </div>
                                        <div class="main-mail-subject">
                                            <strong>قام باضافة فاتورة جديدة</strong> <br><span> لؤي سوفت - لادارة الفواتير </span>
                                        </div>
                                    </div>
                                    <div class="main-mail-date">
                                        {{$one->created_at->format('d/m/Y')}}
                                    </div>
                                    <div class="mr-auto" style="margin-top: 20px;">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
                            @else
                                <a class="main-mail-item" href="{{ url('InvoicesDetails') }}/{{ $one->data['id'] }}">
                                    <div class="">
                                        <img alt="user-img" class="avatar avatar-md" src="{{URL::asset('assets/img/faces/6.jpg')}}">
                                    </div>
                                    <div class="main-mail-body">
                                        <div class="main-mail-from">
                                            {{ $one->data['user'] }}
                                        </div>
                                        <div class="main-mail-subject">
                                            <strong>قام باضافة فاتورة جديدة</strong> <br><span> لؤي سوفت - لادارة الفواتير </span>
                                        </div>
                                    </div>
                                    <div class="main-mail-date">
                                        {{$one->created_at->format('d/m/Y')}}
                                    </div>
                                    <div class="mr-auto" style="margin-top: 20px;">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div><!-- container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--- Internal Check-all-mail js -->
    <script src="{{URL::asset('assets/js/check-all-mail.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
@endsection
