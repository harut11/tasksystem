<tr class="{{ strtotime('-1 day') < strtotime($task->deadline) ? 'text-danger' : '' }}">
    <td>{{ $task->name }}</td>
    <td>{{ str_limit($task->description, 10) }}</td>
    <td>{{ $task->status }}</td>
    <td>
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
    </td>
    <td>{{ $task->deadline }}</td>
    <td>
        {{--<button type="button" class="btn btn-secondary mr-2 float-left editTask" data-toggle="modal" data-target="#exampleModal">--}}
            {{--<i class="fas fa-edit"></i>--}}
        {{--</button>--}}
        <a class="btn btn-secondary mr-2 float-left editTask" href="{{ route('manager.task.edit', $task->id) }}">
            <i class="fas fa-edit"></i>
        </a>
        <form class="float-left" method="post" action="{{ route('manager.task.delete', $task->id) }}">
            @csrf
            <button type="submit" class="btn btn-secondary"><i class="far fa-trash-alt"></i></button>
        </form>
        <a class="btn btn-secondary ml-2" href="{{ route('manager.task.show', $task->id) }}">
            <i class="fas fa-eye"></i>
        </a>
    </td>
</tr>
