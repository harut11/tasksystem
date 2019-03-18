@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <a class="btn btn-light" href="{{ route('manager.task.create') }}">Create<i class="fas fa-plus-circle ml-2"></i></a>
    <table class="table mt-3">
        <caption>List of tasks</caption>
        <thead>
        <tr>
            <th scope="col">
                <button type="button" class="order bg-transparent border-0" data-attribute="asc">
                    <i class="fas fa-angle-up"></i>
                </button> /
                <button type="button" class="order bg-transparent border-0" data-attribute="desc">
                    <i class="fas fa-angle-down"></i>
                </button> Name
            </th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Developer(s)</th>
            <th scope="col">Deadline</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody id="task">
        @each('manager.task._task', $tasks, 'task', 'manager.task._empty')
        </tbody>
    </table>
    <div class="ml-auto">{{ $tasks->links() }}</div>
@endsection