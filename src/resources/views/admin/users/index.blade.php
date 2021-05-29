@extends('templates.main')

@section('content')
<div class="row">
    <div class="col-12 mt-3">
            <h1 class="float-left">Users</h1>
            <a href="{{ route('admin.users.create'  )}}" class="btn btn-sm btn-success float-right">Create</a>
        </div>
</div>


    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <th scope="row">{{$user->name}}</th>
                    <th scope="row">{{$user->email}}</th>
                    <th scope="row">
                        <a href="{{ route('admin.users.edit' , $user->id )}}" class="btn btn-sm btn-primary">Edit</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('admin.users.destroy' , $user->id ) }}"
                            onclick="event.preventDefault();
                            document.getElementById('destroy-form-{{ $user->id}}').submit();"
                        >
                            Delete
                        </a>
                        <form id="destroy-form-{{ $user->id}}" action="{{route('admin.users.destroy' , $user->id ) }}" method="POST" class="d-none">
                            @csrf
                            @method("DELETE")
                        </form>

                    </th>

                </tr>
                @endforeach

            </tbody>
        </table>
        {{ $users->links()}}
    </div>
@endsection

