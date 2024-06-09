@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    صلاحيات المستخدمين    
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                صلاحيات المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


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




<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                                @can('اضافة صلاحية')
                                <a class="btn ripple btn-warning" href="{{ route('roles.create') }}">اضافة دور</a>
                                @endcan
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                            @can('عرض صلاحية')
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('roles.show', $role->id) }}">عرض</a>
                                            @endcan
                                            
                                            @if($role->name!=='Admin' && $role->name!=='Customer')
                                            <a class="btn btn-primary btn-sm"
                                            @can('تعديل صلاحية')
                                                href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                            @endcan
                                            @endif
                                           
                                            @if($role->name!=='Admin' && $role->name!=='Customer')
                                            @can('حذف صلاحية')
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" 
                                            data-target="#deleteRoleModal" data-role_id="{{ $role->id }}" 
                                            data-rolename="{{ $role->name }}" title="حذف">
                                            <i class="las la-trash"></i>
                                            </button>
                                            @endcan
                                            @endif
                                            
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
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" 
     aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteRoleForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="role_id" id="role_id" value="">
                    <input class="form-control" name="rolename" id="rolename" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    $(document).ready(function(){
        $('#deleteRoleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var role_id = button.data('role_id'); 
            var rolename = button.data('rolename'); 

            var modal = $(this);
            modal.find('.modal-body #role_id').val(role_id);
            modal.find('.modal-body #rolename').val(rolename);

            // Update the form action
            var formAction = "{{ route('roles.destroy', ':id') }}";
            formAction = formAction.replace(':id', role_id);
            modal.find('#deleteRoleForm').attr('action', formAction);
        });
    });
</script>

@endsection