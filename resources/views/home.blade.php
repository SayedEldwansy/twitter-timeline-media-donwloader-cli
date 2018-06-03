@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <list-of-flowers></list-of-flowers>
                    You are logged in!
                </div>
    </div>
</div>
@endsection
