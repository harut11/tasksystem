@extends('layouts.main')
@include('layouts.navbar')

@section('title')
    Welcome to show page!
@endsection

@section('content')
    <div class="card w-50 mx-auto">
        <div class="card-header">
            Developer(s) Name:
            @if(count($task->users))
                @foreach($task->users as $user)
                    @php
                        $u[] = $user->first_name;
                    @endphp
                @endforeach
                {{ implode(', ', $u) }}
            @else
                No assigned
            @endif
        </div>
        <div class="card-body">
            <h5 class="card-title">Name: {{ $task->name }}</h5>
            <p class="card-text">Description: {{ $task->description }}</p>
            <p class="card-text">Created At: {{ $task->created_at }}</p>
            <p class="card-text {{ Carbon\Carbon::parse($task->deadline)->diffInDays(\Carbon\Carbon::now()) <= 1 ? 'text-danger' : '' }}">Deadline: {{ $task->deadline }}</p>
            <p class="card-text">Status: {{ $task->status }}</p>
        </div>
    </div>
@endsection