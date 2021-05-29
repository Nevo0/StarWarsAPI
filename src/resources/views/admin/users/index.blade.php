@extends('templates.main')

@section('content')
<div class="row">
    <div class="col-12 mt-3">
            <h1 class="float-left">Users</h1>
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


                    </th>

                </tr>
                @endforeach

            </tbody>
        </table>
        {{ $users->links()}}
    </div>
@endsection

