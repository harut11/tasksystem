@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <table class="table mt-3">
        <caption>List of tasks</caption>
        <thead>
        <tr>
            <th scope="col" class="dev">
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
            <th scope="col" class="dev">
                <button type="button" class="order bg-transparent border-0" data-name="deadline" data-attribute="asc">
                    <i class="fas fa-angle-up"></i>
                </button> /
                <button type="button" class="order bg-transparent border-0" data-name="deadline" data-attribute="desc">
                    <i class="fas fa-angle-down"></i>
                </button> Deadline
            </th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody class="task">
        @each('developer.task._task', $tasks, 'task', 'developer.task._empty')
        </tbody>
    </table>
    <div class="ml-auto">{{ $tasks->links() }}</div>
@endsection

@push('paginateorder')
    <script src="{{ asset('js/paginateorder.js') }}" defer></script>
@endpush