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


                        <a href="https://twitter.com/_Blue_Helper_?ref_src=twsrc%5Etfw" class="twitter-follow-button"
                           data-show-count="false">Follow @_Blue_Helper_</a>


                    </div>
                </div>
            </div>
        </div>
        <br>
        <twett-my-me></twett-my-me>

    </div>
@endsection
