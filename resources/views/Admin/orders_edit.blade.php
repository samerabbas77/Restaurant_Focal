@extends('layouts.master')

@section('css')

@endsection

@section('page-header')
<!-- breadcrumb -->

<!-- /breadcrumb -->
@endsection

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
            <label for="user_id">ايميل الزبون</label>
            <select id="user_id" name="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>
                        {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="orders">
            @foreach($order->dishes as $index => $dish)
                <div class="form-group dish"> <!-- Adding class 'dish' here -->
                    <label for="dish_id_{{ $index }}">اسم الطبق</label>
                    <select id="dish_id_{{ $index }}" name="dishes[{{ $index }}][id]" class="form-control">
                        @foreach($dishes as $dishOption)
                            <option value="{{ $dishOption->id }}" {{ $dishOption->id == $dish->id ? 'selected' : '' }}>
                                {{ $dishOption->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="dish_quantity_{{ $index }}">الكمية</label>
                    <input type="number" id="dish_quantity_{{ $index }}" name="dishes[{{ $index }}][quantity]" class="form-control" value="{{ $dish->pivot->quantity }}" required>
                </div>
            @endforeach
        </div>
        
        <div class="form-group">
            <label for="status">حالة الطلب</label>
            <select id="status" name="status" class="form-control">
                <option value="accepted" {{ $order->status == 'accept' ? 'selected' : '' }}>Accepted</option>
                <option value="not_accepted" {{ $order->status == 'not_accepted' ? 'selected' : '' }}>Not Accepted</option>
            </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="addOrder">Add New Order</button>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
            <a href="{{ route('order.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection


@section('js')
<script>
    $(document).ready(function(){
        var orderIndex = {{ count($order->dishes) }};
        
        $('#addOrder').click(function(){
            var newOrder = $('.dish:first').clone();
            newOrder.find('select').each(function(){
                var newIndex = orderIndex++;
             
            });
            newOrder.find('input[type="number"]').each(function(){
                var newIndex = orderIndex++;
             
            });
            $('#orders').append(newOrder);
        });
        $('#addOrder').on('click', function() {
            orderIndex++;
        });
    });
</script>

@endsection
