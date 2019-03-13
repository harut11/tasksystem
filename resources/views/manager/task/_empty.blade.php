@extends('layouts.main')
@include('layouts.navbar')

@section('title')
    <h3>Welcome to tasks page!</h3>
@endsection

@section('content')
    <a class="btn btn-light" href="{{ route('create') }}">Create<i class="fas fa-plus-circle ml-2"></i></a>
    <h3 class="mt-3">No tasks yet</h3>
@endsection