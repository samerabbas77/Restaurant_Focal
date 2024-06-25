@extends('layouts.master')
@section('css')
<!-- Include Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
@endsection
@section('page-header')



				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<span class="text-muted mt-1 tx-18 mr-2 mb-0"> {{Auth::user()->name}}/</span><h3 class="content-title mb-0 my-auto">Welcome</h3>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						{{-- <div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div> --}}
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row" >
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-primary-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon">
										<i class="icon icon-people"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">المستخدمين</h5>
										<h2 class="counter mb-0 text-white">{{$users}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="card bg-info-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-warning">
										<i class="fas fa-chair"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3"> الطاولات</h5>
										<h2 class="counter mb-0 text-white">{{$tables}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-danger-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-primary">
										<i class="fas fa-clipboard-check"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3"> الطاولات المتاحة</h5>
										<h2 class="counter mb-0 text-white">{{$ava_tables}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-danger-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fas fa-ban"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3"> الطاولات غير المتاحة</h5>
										<h2 class="counter mb-0 text-white">{{$unava_tables}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class=" card bg-info-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-calendar-check icon-reservation"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">الحجوزات</h5>
										<h2 class="counter mb-0 text-white">{{$reservation}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class=" bg-success-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-check-circle icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">Done</h5>
										<h2 class="counter mb-0 text-white">{{$done_reserv}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class=" bg-success-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-sign-in-alt icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">Checked In</h5>
										<h2 class="counter mb-0 text-white">{{$checkedin_reserv}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class=" bg-success-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-sign-out-alt icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">Checked Out</h5>
										<h2 class="counter mb-0 text-white">{{$checkedout_reserv}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<hr>
				<div class="row">	
					<div class="col-lg-3 col-md-6">
						<div class="card bg-info-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fas fa-shopping-cart"></i>									
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">الطلبات</h5>
										<h2 class="counter mb-0 text-white">{{$orders}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-warning-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-check-circle icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">المكتملة</h5>
										<h2 class="counter mb-0 text-white">{{$completed_order}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-warning-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-truck icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">Received</h5>
										<h2 class="counter mb-0 text-white">{{$received_order}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card  bg-warning-gradient">
							<div class="card-body">
								<div class="counter-status d-flex md-mb-0">
									<div class="counter-icon text-success">
										<i class="fa fa-hourglass-half icon-status"></i>
									</div>
									<div class="mr-auto">
										<h5 class="tx-18 tx-white-8 mb-3">Queue</h5>
										<h2 class="counter mb-0 text-white">{{$queue_order}}</h2>
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
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Counters -->
<script src="{{URL::asset('assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counterup.min.js')}}"></script>
<!--Internal Time Counter -->
<script src="{{URL::asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counter.js')}}"></script>
@endsection