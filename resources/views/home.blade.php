@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Note :</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        I'll keep trace Who is unfollow you just wait i'll DM with frequently from My account


                        <a href="https://twitter.com/_A_jamal?ref_src=twsrc%5Etfw" class="twitter-follow-button"
                           data-show-count="false">Follow @_A_jamal</a>


                    </div>
                </div>
            </div>
        </div>
        <br>
        <list-of-not-follow-back></list-of-not-follow-back>
    </div>
@endsection
