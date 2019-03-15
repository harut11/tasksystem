<tr class="{{ strtotime('1 day ago') < strtotime($task->deadline) ? 'text-danger' : '' }}">
    <td>{{ $task->name }}</td>
    <td>{{ str_limit($task->description, 10) }}</td>
    <td>{{ $task->status }}</td>
    <td>
        @if(sizeof($task->users) !== 0)
            @foreach($task->users as $user)
                {{ $user->first_name . ', ' }}
            @endforeach
        @else
            No assigned
        @endif
    </td>
    <td>{{ $task->deadline }}</td>
    <td>
        <a class="btn btn-secondary" href="{{ route('developer.task.show', $task->id) }}"><i class="fas fa-eye"></i></a>
    </td>
</tr>