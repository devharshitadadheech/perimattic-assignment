@extends('layout.app')

@section('title', 'Contact Import')
@section('heading', 'Contacts')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Contacts</div>
                <div class="card-body">
                    <form action="{{url('contacts/fileImport')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose CSV File:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".csv">
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection