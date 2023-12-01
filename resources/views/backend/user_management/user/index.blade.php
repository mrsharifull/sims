@extends('layouts.app', ['pageSlug' => 'user'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <span class="alert alert-success d-block">{{session('success')}}</span>
            @endif
            @if(session('error'))
                <span class="alert alert-danger d-block">{{session('error')}}</span>
            @endif
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">User List</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.user.create')}}" class="btn btn-sm btn-primary">{{__('Add User')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Creation Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{date('d M, Y', strtotime($user->created_at))}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                                x-placement="top-end"
                                                style="position: absolute; transform: translate3d(-57px, -60px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item" href="{{route('um.user.edit',$user->id)}}">Update</a>
                                                <a class="dropdown-item" onclick="alert('Are you sure?')" href="{{route('um.user.delete',$user->id)}}">Delete</a>
                                            </div>
                                        </div>
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
