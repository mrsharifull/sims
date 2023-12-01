@extends('layouts.app', ['pageSlug' => 'user'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Create User')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.user.index')}}" class="btn btn-sm btn-primary">{{__('Back')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('um.user.create')}}">
                    @csrf
                    <div class="form-group">
                        
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{old('name')}}">
                      @error('name')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{old('email')}}">
                      @error('email')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" placeholder="Enter new password">
                      @error('password')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection