@extends('layouts.main')
@include('layouts.navbar')

@section('title')
    Welcome to tasks page!
@endsection

@section('content')
    <a class="btn btn-light" href="{{ route('manager.task.create') }}">Create<i class="fas fa-plus-circle ml-2"></i></a>
    <h3 class="mt-3">No tasks yet</h3>
@endsection