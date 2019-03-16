@extends('layouts.main')
@include('layouts.navbar')

@section('title')
    Welcome to show page!
@endsection

@section('content')
    <div class="card w-50 mx-auto">
        <div class="card-header">
            Developer(s) Name:
            @foreach($task->users as $user)
                {{ $user ? $user->first_name . ', ' : 'No assigned' }}
            @endforeach
        </div>
        <div class="card-body">
            <h5 class="card-title">Name: {{ $task->name }}</h5>
            <p class="card-text">Description: {{ $task->description }}</p>
            <p class="card-text">Deadline: {{ $task->deadline }}</p>
            <p class="card-text">Status: {{ $task->status }}</p>
        </div>
    </div>
@endsection