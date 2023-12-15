@extends('backend.layouts.master', ['pageSlug' => 'permission'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="card-title">{{_('Permission List')}}</h4>
                        </div>
                        <div class="col-md-5 text-right">
                            @include('backend.partials.button', ['routeName' => 'export.permissions', 'className' => 'btn-primary', 'label' => 'Expoert Permissions'])
                            @include('backend.partials.button', ['routeName' => 'um.permission.permission_create', 'className' => 'btn-primary', 'label' => 'Add Permission'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
                        <table class="table tablesorter datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{_('Prefix')}}</th>
                                    <th>{{_('Permisson')}}</th>
                                    <th>{{_('Creation Date')}}</th>
                                    <th>{{_('Creadted By')}}</th>
                                    <th class="text-center">{{_('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key=>$permission)
                                <tr>
                                    <td>{{$permission->prefix}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{date('d M, Y', strtotime($permission->created_at))}}</td>
                                    <td>{{$permission->createdBy->name ?? "System Generated"}}</td>
                                    <td>
                                        @include('backend.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$permission->id],
                                                        'label' => 'View',
                                                        'className' => 'view',
                                                    ],
                                                    [
                                                        'routeName' => 'um.permission.permission_edit',
                                                        'params' => [$permission->id],
                                                        'label' => 'Update',
                                                    ],
                                                ],
                                            ])
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('backend.partials.datatable', ['columns_to_show' => [0,1,2]])

{{-- Permission Details Modal  --}}
<div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ _('Permission Details') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body modal_data">


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
@push('js')
<script>
$(document).ready(function() {
    $('.view').on('click', function() {
        let id = $(this).data('id');
        let url = ("{{ route('um.permission.details.permission_list', ['id']) }}");
        let _url = url.replace('id', id);
        $.ajax({
            url: _url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var result = `
                        <table class="table tablesorter">
                            <tr>
                                <th class="text-nowrap">Prefix</th>
                                <th>:</th>
                                <td>${data.permission.prefix}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Name</th>
                                <th>:</th>
                                <td>${data.permission.name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Guard Name</th>
                                <th>:</th>
                                <td>${data.permission.guard_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created By</th>
                                <th>:</th>
                                <td>${data.permission.created_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated By</th>
                                <th>:</th>
                                <td>${data.permission.updated_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created At</th>
                                <th>:</th>
                                <td>${data.permission.created_date}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated At</th>
                                <th>:</th>
                                <td>${data.permission.updated_date}</td>
                            </tr>
                        </table>
                        `;
                $('.modal_data').html(result);
                $('.view_modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    });
});
</script>
@endpush
