@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Cliente #{{ $cliente->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/clientes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/clientes/' . $cliente->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('clientes.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
