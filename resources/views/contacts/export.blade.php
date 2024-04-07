@extends('layout.app')

@section('title', 'Contact Export')
@section('heading', 'Contacts')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Export Contacts</div>

                <div class="card-body">
                    <form method="GET" action="{{url('contacts/fileExport')}}">
                        <button type="submit" class="btn btn-primary mt-4">Export Contacts</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection