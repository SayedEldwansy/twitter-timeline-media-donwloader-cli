@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Welcome Message</div>

                    <div class="card-body">
                        <form action="{{url('welcome-message')}}" method="post">
                            {{csrf_field()}}

                            <span class="text-justify">
                            This message will be send to every one will follow you :
                            </span>
                            <br>
                            <textarea name="message" class="form-control"></textarea>
                            <br>
                            <input type="submit" value="Save" class="btn btn-primary float-right"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
@endsection