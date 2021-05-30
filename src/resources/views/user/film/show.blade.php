@extends('templates.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="film">Film</h5>
            <h2 class="title">{{ $film['title'] }} </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

                <div class="card">
                    <div class="card-header">
                        {{ $film['opening_crawl'] }}
                    </div>
                </div>

            </div>
        </div>
        <
</div>
@endsection

