@extends('layouts.master')

@section('title')
    الملف الشخصي - لؤي سوفت
@endsection

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / الملف الشخصي</span>
            </div>
        </div>
        <div class="mb-3 mb-xl-0">
            <a class="btn btn-danger-gradient btn-rounded btn-sm" href="{{ url()->previous() }}">رجوع</a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
                    <div class="col-lg-4">
                        <div class="card mg-b-20">
                            <div class="card-body">
                                <div class="pl-0">
                                    <div class="main-profile-overview">
                                        <div class="main-img-user profile-user">
                                            <img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}">
                                        </div>
                                        <div class="justify-content-between mg-b-20">
                                            <div>
                                                <h5 class="main-profile-name">{{Auth::user()->name}}</h5>
                                                <p class="main-profile-name-text">
                                                    {{Auth::user()->role_name}}
                                                </p>
                                            </div>
                                        </div>
                                        <h6>الوصف</h6>
                                        <div class="main-profile-bio text-muted">
                                            يعمل بصلاحية {{Auth::user()->role_name}} لدى لؤي - سوفت لادارة الفواتير
                                        </div><!-- main-profile-bio -->
                                        <label class="main-content-label tx-13 mg-b-20">مواقع التواصل الاجتماعي</label>
                                        <div class="main-profile-social-list">
                                            <div class="media">
                                                <div class="media-icon bg-info-transparent text-dark">
                                                    <i class="icon ion-logo-github"></i>
                                                </div>
                                                <div class="media-body">
                                                    <span>Github</span> <a href="https://github.com/LouiOklaa">www.loui-oklaa.github.com</a>
                                                </div>
                                            </div>
                                            <div class="media">
                                                <div class="media-icon bg-info-transparent text-dark">
                                                    <i class="fab fa-facebook"></i>
                                                </div>
                                                <div class="media-body">
                                                    <span>Facebook</span> <a href="https://www.facebook.com/loui.oklaa/">www.loui-oklaa.facebook.com</a>
                                                </div>
                                            </div>
                                            <div class="media">
                                                <div class="media-icon bg-info-transparent text-dark">
                                                    <i class="icon ion-logo-linkedin"></i>
                                                </div>
                                                <div class="media-body">
                                                    <span>Linkedin</span> <a href="https://www.linkedin.com/in/loui-oklaa/">www.loui-oklaa.linkedin.com</a>
                                                </div>
                                            </div>
                                            <div class="media">
                                                <div class="media-icon bg-info-transparent text-dark">
                                                    <i class="icon ion-logo-twitter"></i>
                                                </div>
                                                <div class="media-body">
                                                    <span>Twitter</span> <a href="https://twitter.com/loui_oklaa">www.loui-oklaa.twitter.com</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- main-profile-overview -->
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-8">
						<div class="row row-sm">
                            <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                                <div class="card bg-info-gradient text-white">
                                    <div class="card-body">
                                        <div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">الفواتير المضافة</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\App\Invoices::withTrashed()->where('created_by' , '=' , Auth::user()->name)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-primary-transparent">
                                                            <i class="ti-stats-up text-info"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card bg-success-gradient text-white">
									<div class="card-body">
										<div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">فواتير تم دفعها</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\App\Invoices_Details::where('user' , '=' , Auth::user()->name)->where('value_status' , '=' , 1)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-success-transparent">
                                                            <i class="icon-rocket text-success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card bg-warning-gradient text-white">
									<div class="card-body">
										<div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">فواتير دفعت جزئيا</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\App\Invoices_Details::where('user' , '=' , Auth::user()->name)->where('value_status' , '=' , 3)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-warning-transparent">
                                                            <i class="ti-pulse text-warning"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                                <div class="card bg-secondary-gradient text-white">
                                    <div class="card-body">
                                        <div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">فواتير تم ارشفتها</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\App\Invoices::onlyTrashed()->where('created_by' , '=' , Auth::user()->name)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-primary-transparent">
                                                            <i class="icon-layers text-secondary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card bg-danger-gradient text-white">
									<div class="card-body">
										<div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">المرفقات المضافة</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\App\Invoices_Attachments::where('created_by' , '=' , Auth::user()->name)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-danger-transparent">
                                                            <i class="ti-pie-chart text-danger"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                                <div class="card bg-purple-gradient text-white">
                                    <div class="card-body">
                                        <div class="counter-status md-mb-0">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="text-right">
                                                        <h5 class="tx-13">صلاحيات تم منحها</h5>
                                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{number_format(\Spatie\Permission\Models\Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$role->id)->count())}}</h2>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-left">
                                                        <div class="counter-icon bg-purple-transparent">
                                                            <i class="fe fe-users text-purple"></i>
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
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection

@section('js')
@endsection
