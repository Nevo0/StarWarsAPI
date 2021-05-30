@extends('templates.main')



@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="">All Movies Where Your Hero Is</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($films as $film)
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('showfilm',  $film['id']) }}">{{$film['title']}} </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <h2 class="">Your The Hero Is From</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('showplanet', $planetsid) }}">{{$planets['name']}} </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

