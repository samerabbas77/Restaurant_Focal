@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@section('title')
تعديل مستخدم 
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>
                <div class="modal-body">

                    <form action="{{route('users.update',$user->id)}}" method="post" autocomplete="off">
                    @method('PUT')
                    @csrf
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المستخدم</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">الايميل</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{$user->password}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تاكيد كلمة المرور</label>
                        <input type="password" class="form-control" id="password" name="password_confirmation" value="{{$user->password}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">الدور</label>
                        <select name="role[]" class="form-control" multiple>
                            @foreach($roles as $id => $role)
                                <option value="{{ $id }}" {{ in_array($id, $userRole) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
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
</div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection