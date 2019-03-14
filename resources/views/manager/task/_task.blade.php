<tr>
    <td>{{ $task->name }}</td>
    <td>{{ str_limit($task->description, 10) }}</td>
    <td>{{ $task->status }}</td>
    <td>{{ $task->first_name ? $task->first_name : 'No assigned' }}</td>
    <td>{{ $task->deadline }}</td>
    <td>
        <a class="btn btn-secondary ml-2" href="{{ route('manager.task.edit', $task->id) }}">
            <i class="fas fa-edit float-left"></i>
        </a>
        <form class="float-left" method="post" action="{{ route('manager.task.delete', $task->id) }}">
            @csrf
            <button type="submit" class="btn btn-secondary"><i class="far fa-trash-alt"></i></button>
        </form>
        <a class="btn btn-secondary" href="{{ route('manager.task.show', $task->id) }}"><i class="fas fa-eye"></i></a>
    </td>
</tr>