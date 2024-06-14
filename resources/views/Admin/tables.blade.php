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
							<h4 class="content-title mb-0 my-auto">الطاولات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارةالطاولات</span>
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
 <!-- Display Restore,ForceDelet  -->
 @if (session('success'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
	 <strong>{{ session('success') }}</strong>
	 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		 <span aria-hidden="true">&times;</span>
	 </button>
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
					<h4 class="card-title mg-b-0">جدول الطاولات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">

			<div class="card-body">
				@can('اضافة طاولة')
				<a class="btn ripple btn-warning" data-target="#modaldemo6" data-toggle="modal" href="{{ route('tables.create') }}">إضافة طاولة جديدة</a>
				@endcan
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">ID</th>
								<th class="border-bottom-0">رقم الطاولة</th>
								<th class="border-bottom-0">عدد المقاعد</th>
                                <th class="border-bottom-0">حالة الطاولة</th>
								<th class="border-bottom-0">الأدوات</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($tables as $table)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td> {{$table->Number}}</td>
								<td> {{$table->chair_number}}</td>
								<td> {{$table->Is_available}}</td>
								<td>
								@can('تعديل طاولة')
								<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                    data-id="{{ $table->id }}"
                                    data-number="{{ $table->Number }}"
                                    data-chair_number="{{ $table->chair_number }}"
                                    data-is_available="{{ $table->Is_available }}"
                                    data-toggle="modal"
                                    href="#exampleModal2" title="edit"><i class="las la-pen"></i></a>
								@endcan
								@can('حذف طاولة')
									<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										data-id="{{$table->id}}"
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
                    <h3>الطاولات المحذوفة مؤقتا</h3>
                    <table id="example2" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">ID</th>
								<th class="border-bottom-0">رقم الطاولة</th>
								<th class="border-bottom-0">عدد المقاعد</th>
                                <th class="border-bottom-0">حالة الطاولة</th>
								<th class="border-bottom-0">الأدوات</th>
							</tr>
						</thead>
                        <tbody>
                        @foreach($trachedTables as $table)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $table->Number }}</td>
                            <td>{{ $table->chair_number }}</td>
                            <td>{{ $table->Is_available }}</td>
                            <td>
                                    <form action="{{ route('tables.restore', $table->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
										@can('استعادة طاولة')
                                        <button type="submit" class="btn btn-warning">استعادة</button>
										@endcan
                                    </form>
                                    <form action="{{ route('tables.forceDelete', $table->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
										@can('حذف طاولة')
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
		<!--/div-->
</div>
<!-- /row -->


<!-- Add modal -->
		<div class="modal" id="modaldemo6">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة طاولة جديدة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{ route('tables.store') }}" method="post">
							@csrf
							<div class="form-group">
								<label for="exampleInputEmail1">رقم الطاولة</label>
								<input type="number" class="form-control" id="" name="Number">
                            </div>
                            <div class="form-group">
								<label for="exampleInputEmail1">عدد الكراسي</label>
								<input type="number" class="form-control" id="" name="chair_number">
                            </div>
                            <div class="form-group">
								<label for="exampleInputEmail1">حالة الطاولة</label>
                                <select name="Is_available" class="form-control" required>
                                    <option value="available">available</option>
                                    <option value="unavailable"> unavailable</option>
                                </select>

							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-success">إضافة</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<!--End Add modal -->


<!-- </div> -->
<!-- edit modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل الطاولة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				@if($tables->isEmpty())
					<p> No Table Found!</p>
				@else
                <form  method="post" autocomplete="off" id="updateTableForm" >
                @csrf
                @method('PUT')
                <div class="form-group">

                <input type="hidden" id="updateTableId" name="id" >
                    <label for="exampleInputEmail1">رقم الطاولة</label>
                    <input type="number" class="form-control" id="number" name="Number" value="{{$table->Number}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">عدد الكراسي</label>
                    <input type="number" class="form-control" id="chair_number" name="chair_number" value="{{$table->chair_number}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">حالة الطاولة</label>
                    <select name="Is_available" class="Is_available" id="updateIsAvailable" required>
                        <option value="available">available</option>
                        <option value="unavailable"> unavailable</option>
                    </select>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            </div>
            </form>

        </div>
    </div>
</div>
</div>
<!-- end edit model -->


<!-- delete model -->
<div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title"> Delete Table </h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form  method="post" id="deleteTableForm">

				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>هل أنت متأكد أنك تريد الحذف؟</p><br>
                    <input type="hidden" id="deleteTableId" name="id" autocomplete="off">

					<input type="hidden" name="id" id="deleteTableId" autocomplete="off" >

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>

		</form>
	@endif
	</div>
</div>
</div>

<!-- end delete model -->




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
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var number = button.data('number');
    var chair_number = button.data('chair_number');
    var is_available = button.data('is_available');

    var modal = $(this);
    modal.find('.modal-body #updateTableId').val(id);
    modal.find('.modal-body #number').val(number);
    modal.find('.modal-body #chair_number').val(chair_number);
    modal.find('.modal-body #is_available').val(is_available);
});

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
			const updateForm = document.getElementById('updateTableForm');
			const updateHiddenInput = document.getElementById('updateTableId');
			updateHiddenInput.value = dataId;
			updateForm.action = `{{ route('tables.update', '') }}/${dataId}`;

			// Delete Form
			const deleteForm = document.getElementById('deleteTableForm');
			const deleteHiddenInput = document.getElementById('deleteTableId');
			deleteHiddenInput.value = dataId;
			deleteForm.action = `{{ route('tables.destroy', '') }}/${dataId}`;
		});
	});
});

</script>



@endsection
