@extends('layouts.backend.backend-app')

@section('title','Dashboard')

@push('css')
@endpush

@section('content')
    <h1>Welcome TO Admin Dashboard</h1>
@endsection


@push('js')

    <script src="{{asset('/')}}assets/backend/js/pages/index.js"></script>
@endpush
