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
                            <a href="{{route('um.user.user_create')}}" class="btn btn-sm btn-primary">{{__('Add User')}}</a>
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
                                        <span class="badge {{$user->status ==1 ? 'badge-success' : 'badge-warning' }}">{{$user->status ==1 ? 'Active' : 'Disabled' }}</span>
                                    </td>
                                    <td>{{date('d M, Y', strtotime($user->created_at))}}</td>
                                    <td> {{ $user->created_user->name ?? 'system' }} </td>
                                    <td>
                                        @include('backend.partials.action_buttons', [
                                            'menuItems' => [
                                                ['routeName' => '', 'label' => 'View'],
                                                ['routeName' => 'um.user.status.user_edit',   'params' => [$user->id], 'label' => $user->getBtnStatus()],
                                                ['routeName' => 'um.user.user_edit',   'params' => [$user->id], 'label' => 'Update'],
                                                ['routeName' => 'um.user.user_delete', 'params' => [$user->id], 'label' => 'Delete', 'delete' => true],
                                            ]
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
@include('backend.partials.datatable', ['columns_to_show' => [0,1,2,3,4,5]])