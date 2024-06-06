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
							<h4 class="content-title mb-0 my-auto">الطلبات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الطلبات</span>
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
					<h4 class="card-title mg-b-0">جدول الطلبات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
		
			<div class="card-body">
				<a class="btn ripple btn-warning" data-target="#modaldemo6" data-toggle="modal" href="">إضافة طلب جديد</a>
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
								<th class="border-bottom-0">الفاتورة</th>
								<th class="border-bottom-0">حالة الطلب</th>
								<th class="border-bottom-0">الأدوات</th>								
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
							  <tr>
								    <td>{{$loop->iteration}}</td>
								    <td>{{$order->user->email}}</td>
								    <td>{{$order->table_id}}</td>
								    <td>{{$order->total_price}}</td>
								    <td>{{$order->status}}</td>
								    <td>
                                       
                                    <a  href="{{ route('order.edit', $order->id) }}" class="btn btn-primary" title="edit"><i class="las la-pen"></i></a>
								
                                  
                                           <form action="{{route('order.destroy',$order->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button>delete</button>
                                        </form>

                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-id="{{$order->id}}"
                                        data-toggle="modal"
                                        data-target="#detailsModal{{$order->id}}" 
                                        title="تفاصيل الطلبية">تفاصيل الطلبية</a>

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



<!-- Add modal -->
<div class="modal" id="modaldemo6">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">إضافة طلب جديد</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="table_id">رقم الطاولة</label>
                        <select id="table_id" name="table_id" class="form-control">
                            <option value="" disabled selected></option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->Number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Customer Email</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="" disabled selected></option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="dishes">
                        <div class="form-group dish">
                            <label for="dish_id">اسم الطبق</label>
                            <select id="dish_id" name="dishes[0][id]" class="form-control">
                                <option value="" disabled selected></option>
                                @foreach($dishes as $dish)
                                    <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                                @endforeach
                            </select>

                            <label for="dish_quantity">Quantity</label>
                            <input type="number" class="form-control" name="dishes[0][quantity]" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="add-dish">+</button>
                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Add modal -->



@foreach($orders as $order)
<!--start detils modal -->
<div class="modal fade" id="detailsModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{$order->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel{{$order->id}}">تفاصيل الطلبية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>الطبق</th>
                            <th>الكمية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->dishes as $dish)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $dish->name }}</td>
                            <td>{{ $dish->pivot->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!--end detils modal -->
@endforeach

</div>
<!-- edit modal -->
<!-- <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل الطلب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($orders->isEmpty())
                <p>No order data</p>
                @else
                <div class="modal-body">
                <form id="updateOrderForm" method="post" autocomplete="off">
                    @csrf

                    <div class="form-group">
                        <input type="hidden" id="updateOrderId" name="order_id" value="">
                        
                        <label for="table_id">رقم الطاولة</label>
                        <select id="table_id" name="table_id" class="form-control">
                            <option value="" disabled selected></option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->Number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Customer Email</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="" disabled selected></option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="dishes">
                        <div class="form-group dish">
                            <label for="dish_id">اسم الطبق</label>
                            <select id="dish_id" name="dishes[0][id]" class="form-control">
                                <option value="" disabled selected></option>
                                @foreach($dishes as $dish)
                                    <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                                @endforeach
                            </select>

                            <label for="dish_quantity">Quantity</label>
                            <input type="number" class="form-control" name="dishes[0][quantity]" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="add-dish">+</button>
                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
</div> -->
<!-- end edit model -->



<!-- delete model -->

<!-- <div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">حذف الطلب</h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form id="deleteOrderForm" method="post" autocomplete="off" autocomplete="off">
				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>Are you sure you want to delete?</p><br>
					<input type="hidden" id="deleteOrderId" name="Order_id" value="">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>
		</div>
		</form>
		@endif
	</div>
</div> -->

<!-- end delete model -->



<!--  -->
</div>
<!-- /row -->



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

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #table_id').val(table_id);
        modal.find('.modal-body #start_date').val(start_date);
        modal.find('.modal-body #end_date').val(end_date);
       // modal.find('.modal-body #photo').val(photo);									
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
                const dataId = event.currentTarget.dataset.id;

                // Update Form
				const updateForm = document.getElementById('updateOrderForm');
				const updateHiddenInput = document.getElementById('updateOrderId');
				updateHiddenInput.value = dataId;
				updateForm.action = `{{ route('order.update', '') }}/${dataId}`;

                const deleteForm = document.getElementById('deleteOrderForm');
				const deleteHiddenInput = document.getElementById('deleteOrderId');
				deleteHiddenInput.value = dataId;
				deleteForm.action = `{{ route('order.destroy', '') }}/${dataId}`;
            });
        });
    });
</script>





<script>
document.addEventListener('DOMContentLoaded', function() {
    let dishIndex = 1;

    document.getElementById('add-dish').addEventListener('click', function() {
        const dishesDiv = document.getElementById('dishes');
        const newDishDiv = document.createElement('div');
        newDishDiv.classList.add('form-group', 'dish');

        newDishDiv.innerHTML = `
            <label for="dish_id">اسم الطبق</label>
            <select name="dishes[${dishIndex}][id]" class="form-control">
                <option value="" disabled selected></option>
                @foreach($dishes as $dish)
                    <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                @endforeach
            </select>

            <label for="dish_quantity">Quantity</label>
            <input type="number" class="form-control" name="dishes[${dishIndex}][quantity]" required>

            <button type="button" class="btn btn-danger remove-dish">إزالة</button>
        `;

        dishesDiv.appendChild(newDishDiv);

        newDishDiv.querySelector('.remove-dish').addEventListener('click', function() {
            dishesDiv.removeChild(newDishDiv);
        });

        dishIndex++;
    });

    document.querySelectorAll('.remove-dish').forEach(function(button) {
        button.addEventListener('click', function() {
            const dishDiv = button.closest('.dish');
            dishDiv.parentNode.removeChild(dishDiv);
        });
    });
});
</script>

@endsection