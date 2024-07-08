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
					<h4 class="card-title mg-b-0">جدول الطلبات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">

			<div class="card-body">
                @can('اضافة طلب')
				<a class="btn ripple btn-warning" data-target="#modaldemo6" data-toggle="modal" href="">إضافة طلب جديد</a>
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

                                        @can('تعديل طلب')
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                           data-id="{{$order->id}}"
                                           data-user_id="{{$order->user_id}}"
                                           data-table_id="{{$order->table_id}}"
                                           data-dishes="{{ json_encode($order->dishes->pluck('id')->toArray()) }}"
                                           data-quantities="{{ json_encode($order->dishes->pluck('pivot.quantity')->toArray()) }}"
                                           data-status="{{$order->status}}"
                                           data-toggle="modal" 
                                           data-target="#exampleModal2"
                                           title="edit">
                                           <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        
                                        
                                    @can('حذف طلب')
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                    data-id="{{$order->id}}"
                                    data-user_id="{{$order->user_id}}"
                                    data-toggle="modal"
                                    href="#modaldemo4"
                                    title="Delete"><i
									class="las la-trash"></i></a>
                                    @endcan
                                    @can('تفاصيل الطلب')
                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-id="{{$order->id}}"
                                        data-toggle="modal"
                                        data-target="#detailsModal{{$order->id}}"
                                        title="تفاصيل الطلبية">تفاصيل الطلبية</a>
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
                    <h3>الطلبات المحذوفة مؤقتا</h3>
                    <table id="example2" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0"> ايميل الزبون</th>
                                <th class="border-bottom-0"> رقم الطاولة</th>
                                <th class="border-bottom-0">الفاتورة</th>
                                <th class="border-bottom-0">حالة الطلب </th>
                                <th class="border-bottom-0">الأدوات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedOrders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->email}}</td>
                                    <td>{{ $order->table_id}}</td>
                                    <td>{{ $order->total_price}}</td>
                                    <td>{{ $order->status}}</td>
                                    <td>
                                        <form action="{{ route('orders.restore', $order->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @can('استعادة طلب')
                                            <button type="submit" class="btn btn-warning">استعادة</button>
                                            @endcan
                                        </form>
                                        <form action="{{ route('orders.forceDelete', $order->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            @can('حذف طلب')
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

                            <label for="dish_quantity">الكمية</label>
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


  <!-- edit modal -->
<!-- Edit modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateOrderForm" method="post" autocomplete="off">
                    @method('PUT')
                    @csrf

                    <input type="hidden" id="updateOrderId" name="order_id" value="">

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
                    <div class="form-group">
                        <label for="status">حالة الطلب</label>
                        @if (!empty($order)) 
                        <select id="status" name="status" class="form-control">
                               
                            <option value="In Queue" {{$order->status == 'In Queue' ? 'selected' : ''}}  >In Queue</option>
                            <option value="Order Received" {{$order->status == 'Order Received' ? 'selected' : ''}} >Order Received</option>
                            <option value="Completed" {{$order->status == 'Completed' ? 'selected': ''}}  >Completed</option>
                            
                        </select>                       
                        @else
                        <div>
                            <p>no data</p>
                        </div>
                            @endif
                       
                       
                    </div>

                    <div id="edit-dishes"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="add-edit-dish">+</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<!-- delete model -->
<div class="modal" id="modaldemo4">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title"> حذف طبق</h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form id="deleteOrderForm" method="post" autocomplete="off">
				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>هل أنت متأكد أنك تريد الحذف؟</p><br>
                    @if(!Empty($order))
					<input type="hidden" id="deleteOrderId" name="order_id" value="">				
					<input class="form-control" name="user_id" id="user_id" value="{{$order->user->name}}" type="text" readonly>
                    @endif
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
					<button type="submit" class="btn btn-danger">حذف</button>
				</div>
		</div>
		</form>
		
	</div>
</div>

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
        var dishes = button.data('dishes')
        var quantities = button.data('quantities')
        var status = button.data('status')

        var modal = $(this)
        modal.find('.modal-body #updateOrderId').val(id);
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #table_id').val(table_id);
        modal.find('.modal-body #status').val(status);

        // Clear existing dish fields
        $('#edit-dishes').empty();

        // Add dish fields with existing values
        for (var i = 0; i < dishes.length; i++) {
            var dishId = dishes[i];
            var quantity = quantities[i];

            var newDishDiv = `
                <div class="form-group dish">
                    <label for="dish_id">اسم الطبق</label>
                    <select name="dishes[${i}][id]" class="form-control">
                        <option value="" disabled></option>
                        @foreach($dishes as $dish)
                            <option value="{{ $dish->id }}" ${dishId == {{ $dish->id }} ? 'selected' : ''}>{{ $dish->name }}</option>
                        @endforeach
                    </select>
                    <label for="dish_quantity">الكمية</label>
                    <input type="number" class="form-control" name="dishes[${i}][quantity]" value="${quantity}" required>
                    <button type="button" class="btn btn-danger remove-dish">إزالة</button>
                </div>
            `;

            $('#edit-dishes').append(newDishDiv);
        }

        // Add event listener for the remove buttons
        document.querySelectorAll('.remove-dish').forEach(function(button) {
            button.addEventListener('click', function() {
                const dishDiv = button.closest('.dish');
                dishDiv.parentNode.removeChild(dishDiv);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let dishIndex = 1;

        document.getElementById('add-edit-dish').addEventListener('click', function() {
            const dishesDiv = document.getElementById('edit-dishes');
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
                <label for="dish_quantity">الكمية</label>
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


<script>
    $('#modaldemo4').on('show.bs.modal', function(event) {
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


@endsection
