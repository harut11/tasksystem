@extends('layouts.main')
@include('layouts.navbar')

@section('content')
<table class="table w-75 mx-auto">
    <caption>List of users</caption>
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
    </tr>
    </thead>
    <tbody>
    @each('manager.task._task', $tasks, 'task', 'manager.task._empty')
    </tbody>
</table>
@endsection