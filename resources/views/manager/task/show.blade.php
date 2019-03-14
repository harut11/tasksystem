@extends('layouts.main')
@include('layouts.navbar')

@section('title')
    Welcome to show page!
@endsection

@section('content')
    <div class="card w-50 mx-auto">
        <div class="card-header">
            Developer(s) Name: {{ $task->first_name ? $task->first_name : 'No Assigned'}}
        </div>
        <div class="card-body">
            <h5 class="card-title">Task Name: {{ $task->name }}</h5>
            <p class="card-text">Task Description: {{ $task->description }}</p>
        </div>
    </div>
@endsection