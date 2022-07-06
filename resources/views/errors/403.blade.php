@extends('layouts.master2')

@section('title')
    خطأ 403 - لؤي سوفت
@endsection

@section('css')
<!--- Internal Fontawesome css-->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!---Ionicons css-->
<link href="{{URL::asset('assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
<!---Internal Typicons css-->
<link href="{{URL::asset('assets/plugins/typicons.font/typicons.css')}}" rel="stylesheet">
<!---Internal Feather css-->
<link href="{{URL::asset('assets/plugins/feather/feather.css')}}" rel="stylesheet">
<!---Internal Falg-icons css-->
<link href="{{URL::asset('assets/plugins/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection

@section('content')
		<!-- Main-error-wrapper -->
		<div class="main-error-wrapper page page-h ">
			<img src="{{URL::asset('assets/img/media/403.png')}}" class="error-page" alt="error">
			<h2>عذراً , المستخدم ليس لديه الأذونات الصحيحة.</h2>
			<h6>ربما ليس لديك الصلاحية المناسبة أو ربما لم تقم بتسجيل الدخول.</h6><a class="btn btn-rounded btn-primary" href="{{ url('/' . $page='home') }}">العودة للصفحة الرئيسية</a>
		</div>
		<!-- /Main-error-wrapper -->
@endsection

@section('js')
@endsection
