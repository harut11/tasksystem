@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <table class="table mt-3">
        <caption>List of tasks</caption>
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Developer(s)</th>
            <th scope="col">Deadline</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @each('developer.task._task', $tasks, 'task', 'developer.task._empty')
        </tbody>
    </table>
@endsection