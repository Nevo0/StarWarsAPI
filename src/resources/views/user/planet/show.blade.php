@extends('templates.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="planet">Planet</h5>
            <h2 class="title">{{ $planet['name'] }} </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

                <div class="card">
                    <div class="card-header">
                        <div class="mt-1"><span class="bold">Climat:</span> {{ $planet['climate'] }}</div>
                      <div class="mt-1"><span class="bold">Area:</span> {{ $planet['terrain'] }}</div>
                      <div class="mt-1"><span class="bold">Gravity:</span> {{ $planet['gravity'] }}</div>
                      <div class="mt-1"><span class="bold">Population:</span> {{ $planet['population'] }}</div>
                      <div class="mt-1"><span class="bold">Size:</span> {{ $planet['diameter'] }}</div>
                    </div>
                </div>

            </div>
        </div>
        <
</div>
@endsection

