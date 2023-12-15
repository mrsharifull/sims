@extends('backend.layouts.master', ['pageSlug' => 'user'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">User List</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', [
                                'routeName' => 'um.user.user_create',
                                'className' => 'btn-primary',
                                'label' => 'Add User',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
                        <table class="table tablesorter datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{ _('Name') }}</th>
                                    <th>{{ _('Email') }}</th>
                                    <th>{{ _('Role') }}</th>
                                    <th>{{ _('Status') }}</th>
                                    <th>{{ _('Creation date') }}</th>
                                    <th>{{ _('Created by') }}</th>
                                    <th>{{ _('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td>
                                        <td> {{ $user->role->name }} </td>
                                        <td>
                                            <span
                                                class="badge {{ $user->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $user->status == 1 ? 'Active' : 'Disabled' }}</span>
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($user->created_at)) }}</td>

                                        <td> {{ $user->createdBy->name ?? 'system' }} </td>
                                        <td>
                                            @include('backend.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$user->id],
                                                        'label' => 'View',
                                                        'className' => 'view',
                                                    ],
                                                    [
                                                        'routeName' => 'um.user.status.user_edit',
                                                        'params' => [$user->id],
                                                        'label' => $user->getBtnStatus(),
                                                    ],
                                                    [
                                                        'routeName' => 'um.user.user_edit',
                                                        'params' => [$user->id],
                                                        'label' => 'Update',
                                                    ],
                                                    [
                                                        'routeName' => 'um.user.user_delete',
                                                        'params' => [$user->id],
                                                        'label' => 'Delete',
                                                        'delete' => true,
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

    {{-- User Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _('User Details') }}</h5>
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

      
@endsection
@include('backend.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('um.user.details.user_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.user.status = 1 ? 'Active' : 'Deactive';
                        let statusClass = data.user.status = 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table tablesorter">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.user.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.user.email}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Role</th>
                                        <th>:</th>
                                        <td>${data.user.role.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.user.created_user}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.user.updated_user}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.user.created_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.user.updated_date}</td>
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
