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
							<h4 class="content-title mb-0 my-auto">الحجوزات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الحجوزات</span>
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


<!-- Display session errors ends -->
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

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
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
					<h4 class="card-title mg-b-0">جدول الحجوزات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">

			<div class="card-body">
				@can('اضافة حجز')
				<a class="btn ripple btn-warning" data-target="#modaldemo6" data-toggle="modal" href="">إضافة حجز جديد</a>
				@endcan
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">ID</th>
								<th class="border-bottom-0">ايميل الزبون</th>
								<th class="border-bottom-0">رقم الطاولة</th>
								<th class="border-bottom-0">تاريخ البداية</th>
								<th class="border-bottom-0">تاريخ النهاية</th>
								<th class="border-bottom-0">حالة الحجز</th>
								<th class="border-bottom-0">الأدوات</th>
							</tr>
						</thead>
						<tbody>
							@foreach($reservations as $reservation)
							  <tr>
								    <td>{{$loop->iteration}}</td>
								    <td>{{$reservation->user->name}}</td>
								    <td>{{$reservation->table->Number}}</td>
								    <td>{{$reservation->start_date}}</td>
								    <td>{{$reservation->end_date}}</td>
								    <td>{{$reservation->status}}</td>
								    <td>
										@can('تعديل حجز')
									   <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
										   data-id="{{$reservation->id}}"
										   data-user_id="{{$reservation->user->id}}"
										   data-table_id="{{$reservation->table->Number}}"
										   data-start_date="{{$reservation->start_date}}"
										   data-end_date="{{$reservation->end_date}}"
										   data-status="{{$reservation->status}}"
										   data-toggle="modal"
										   href="#exampleModal2" title="edit"><i class="las la-pen"></i></a>
										@endcan

										@can('حذف حجز')
									    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										   data-id="{{$reservation->id}}"
										   data-toggle="modal" href="#modaldemo9" title="delete"><i
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
                    <h3>الحجوزات المحذوفة مؤقتا</h3>
                    <table id="example2" class="table key-buttons text-md-nowrap">
                        <thead>
							<tr>
								<th class="border-bottom-0">ID</th>
								<th class="border-bottom-0">ايميل الزبون</th>
								<th class="border-bottom-0">رقم الطاولة</th>
								<th class="border-bottom-0">تاريخ البداية</th>
								<th class="border-bottom-0">تاريخ النهاية</th>
								<th class="border-bottom-0">الأدوات</th>
							</tr>
						</thead>
                        <tbody>
                            @foreach($trashedReservations as $reservation)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$reservation->user->name}}</td>
                                <td>{{$reservation->table->Number}}</td>
                                <td>{{$reservation->start_date}}</td>
                                <td>{{$reservation->end_date}}</td>
                                <td>
                                    <form action="{{ route('reservations.restore', $reservation->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
										@can('استعادة حجز')
                                        <button type="submit" class="btn btn-warning">استعادة</button>
										@endcan
                                    </form>
                                    <form action="{{ route('reservations.forceDelete', $reservation->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
										@can('حذف حجز')
                                        <button type="submit" class="btn btn-danger">حذف نهائي</button>
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
		<!--/div-->
</div>
<!-- /row -->

<!-- Add modal -->
		<div class="modal" id="modaldemo6">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة حجز جديد</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{route('reservation.store')}}" method="post">
							@method('POST')
							@csrf
							<div class="form-group">
							<label for="exampleInputEmail1">ايميل الزبون</label>
								<select id="user_id" name="user_id" class="form-control">
									<option value="" disabled selected></option>
									@foreach($users as $user)
										<option value="{{ $user->id }}">{{ $user->email }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
							<label for="exampleInputEmail1">رقم الطاولة</label>
								<select id="table_id" name="table_id" class="form-control">
									<option value="" disabled selected></option>
									@foreach($tables as $table)
										<option value="{{ $table->id }}">{{ $table->Number }}</option>
									@endforeach
								</select>
							</div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">تاريخ البداية</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">تاريخ النهاية</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                            </div>


							<div class="modal-footer">
								<button type="submit" class="btn btn-success" >إضافة</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<!--End Add modal -->


</div>
    <!-- edit modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل التصنيف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					@if ($reservations->isEmpty())
					<p>no reservation data</p>
					@else
					<form id="updateReservationForm" method="post" autocomplete="off" autocomplete="off">
						@method('PUT')
						@csrf
							<div class="form-group">
							    <input type="hidden" id="updateReservationId" name="reservation_id" value="">

								<label for="exampleInputEmail1">ايميل الزبون</label>
								<select id="user_id" name="user_id" class="form-control">
									<option value="" disabled selected></option>
									@foreach($users as $user)
										<option value="{{ $user->id }}">{{ $user->email }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">رقم الطاولة</label>
								<select id="table_id" name="table_id" class="form-control">
									<option value="" disabled selected></option>
									@foreach($tables as $table)
										<option value="{{ $table->id }}">{{ $table->Number }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">تاريخ البداية</label>
								<input type="datetime-local" class="form-control" id="start_date" name="start_date">
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">تاريخ النهاية</label>
								<input type="datetime-local" class="form-control" id="end_date" name="end_date">
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">حالة الحجز</label>
								<select id="status" name="status" class="form-control">
									<option value="checkedout" {{ $reservation->status == 'checkedout' ? 'selected' : '' }}>checkedout</option>
									<option value="checkedin" {{ $reservation->status == 'checkedin' ? 'selected' : '' }}>checkedin</option>
									<option value="done" {{ $reservation->status == 'done' ? 'selected' : '' }}>done</option>
								</select>
							</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<!-- end edit model -->


<!-- delete model -->
<div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">حذف الحجز</h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form id="deleteReservationForm" method="post" autocomplete="off" autocomplete="off">
				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>هل أنت متأكد أنك تريد الحذف؟</p><br>
					<input type="hidden" id="deleteReservationId" name="reservation_id" value="">
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
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var user_id = button.data('user_id')
        var table_id = button.data('table_id')
        var start_date = button.data('start_date')
        var end_date = button.data('end_date')
        var status = button.data('status')


        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #table_id').val(table_id);
        modal.find('.modal-body #start_date').val(start_date);
        modal.find('.modal-body #end_date').val(end_date);
        modal.find('.modal-body #status').val(status);
	})
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })

</script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const modalLinks = document.querySelectorAll('.modal-effect');

		modalLinks.forEach(link => {
			link.addEventListener('click', function (event) {
				// Get the data-id value
				const dataId = event.currentTarget.dataset.id;

				// Update Form
				const updateForm = document.getElementById('updateReservationForm');
				const updateHiddenInput = document.getElementById('updateReservationId');
				updateHiddenInput.value = dataId;
				updateForm.action = `{{ route('reservation.update', '') }}/${dataId}`;

				// Delete Form
				const deleteForm = document.getElementById('deleteReservationForm');
				const deleteHiddenInput = document.getElementById('deleteReservationId');
				deleteHiddenInput.value = dataId;
				deleteForm.action = `{{ route('reservation.destroy', '') }}/${dataId}`;
			});
		});
	});
	</script>

@endsection
