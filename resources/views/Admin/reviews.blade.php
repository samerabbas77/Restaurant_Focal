@extends('layouts.master')
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
							<h4 class="content-title mb-0 my-auto">التقييمات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/إدارة التقييمات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')


<!-- validation  strat -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 <!-- Display session errors -->
 @if (session('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
	 <strong>{{ session('error') }}</strong>
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

<!-- validation  end -->


<!-- row -->
<div class="row">
		<!--div-->
		<div class="col-xl-12">
		<div class="card mg-b-20">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-0">جدول التقييمات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
            
            <div class="card-body">
				</div>
			</div>
		
			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">#N</th>
								<th class="border-bottom-0">التقييم</th>
								<th class="border-bottom-0">اسم الزبون</th>								
								<th class="border-bottom-0">ايميل الزبون</th>								
								<th class="border-bottom-0">التعليق</th>															
								<th class="border-bottom-0">الأدوات</th>								
							</tr>
						</thead>
						<tbody>
							@foreach($reviews as $review)					
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$review->service_rating}}</td>
								<td>{{$review->user->name}}</td>
								<td>{{$review->user->email}}</td>
								<td>{{$review->comments}}</td>
								<td>
                                    @can('حذف تقييم')
									<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										data-id="{{$review->id}}" 
										data-name="{{$review->service_rating}}" 
										data-toggle="modal"
										 href="#modaldemo9" title="Delete"><i
											class="las la-trash"></i></a>
                                    @endcan
								</td>									
							</tr>
							@endforeach
						</tbody>
					</table>	
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
                    <h3>التقييمات المحذوفة مؤقتا</h3>
                    <table id="example2" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">#N</th>
								<th class="border-bottom-0">التقييم</th>
								<th class="border-bottom-0">اسم الزبون</th>
								<th class="border-bottom-0">ايميل الزبون</th>
								<th class="border-bottom-0">التعليق</th>
								<th class="border-bottom-0">الادوات</th>
							</tr>
						</thead>
                        <tbody>
                        @foreach($trachedReviews as $review)
                        <tr>
                            <td>{{$loop->iteration}}</td> 
                            <td>{{ $review->service_rating }}</td>
                            <td>{{ $review->user->name}}</td>
                            <td>{{ $review->user->email}}</td>
                            <td>{{ $review->comments }}</td>
                            <td>
                                    <form action="{{ route('reviews.restore', $review->id) }}" method="POST" style="display:inline-block;">
									    @method('POST')
                                        @csrf
										@can('استعادة تقييم')
                                        <button type="submit" class="btn btn-warning">استعادة</button>
										@endcan
                                    </form>
                                    <form action="{{ route('reviews.forceDelete', $review->id) }}" method="POST" style="display:inline-block;">
                                        @method('DELETE')
                                        @csrf
										@can('حذف تقييم')
                                        <button type="submit" class="btn btn-danger">حذف نهائي </button>
										@endcan
									</form>
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
<!-- /row -->
</div>

<!-- delete model -->
<div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">حذف التقييم</h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			@if ($reviews->isEmpty())
					<p>no reservation data</p>
			@else
			<form id="deleteReviewForm" method="post" autocomplete="off">
				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>هل أنت متأكد أنك تريد الحذف؟</p><br>
					<input type="hidden" id="deleteReviewId" name="review_id" value="">				
					<input class="form-control" name="name" id="name" type="text" readonly>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>
				</div>
			</form>
			@endif
		</div>
	</div>

<!-- end delete model -->

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const modalLinks = document.querySelectorAll('.modal-effect');
	
		modalLinks.forEach(link => {
			link.addEventListener('click', function (event) {
				// Get the data-id value
				const dataId = event.currentTarget.dataset.id;
		
				// Delete Form
				const deleteForm = document.getElementById('deleteReviewForm');
				const deleteHiddenInput = document.getElementById('deleteReviewId');
				deleteHiddenInput.value = dataId;
				deleteForm.action = `{{ route('reviews.destroy', '') }}/${dataId}`;
			});
		});
	});
</script>
@endsection  