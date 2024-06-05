@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->

@section('content')
<div class="container">
    <h1>تعديل الطلب</h1>
    <form action="{{ route('order.update', $order->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="table_id">رقم الطاولة</label>
            <select id="table_id" name="table_id" class="form-control">
                @foreach($tables as $table)
                    <option value="{{ $table->id }}" {{ $table->id == $order->table_id ? 'selected' : '' }}>
                        {{ $table->Number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">Customer Email</label>
            <select id="user_id" name="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>
                        {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="dishes">
            @foreach($order->dishes as $index => $dish)
                <div class="form-group dish">
                    <label for="dish_id_{{ $index }}">اسم الطبق</label>
                    <select id="dish_id_{{ $index }}" name="dishes[{{ $index }}][id]" class="form-control">
                        @foreach($dishes as $dishOption)
                            <option value="{{ $dishOption->id }}" {{ $dishOption->id == $dish->id ? 'selected' : '' }}>
                                {{ $dishOption->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="dish_quantity_{{ $index }}">Quantity</label>
                    <input type="number" class="form-control" name="dishes[{{ $index }}][quantity]" value="{{ $dish->pivot->quantity }}" required>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
            <a href="{{ route('order.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection
				<!-- row -->
				<div class="row">

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection