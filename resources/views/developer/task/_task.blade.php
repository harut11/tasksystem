<tr class="{{ Carbon\Carbon::parse($task->deadline)->diffInDays(\Carbon\Carbon::now()) <= 1 ? 'text-danger' : '' }}">
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
        <a class="btn btn-secondary" href="{{ route('developer.task.show', $task->id) }}">
            <i class="fas fa-eye"></i>
        </a>
        @if(count($task->users))
            @foreach($task->users as $user)
                @if($user->id === auth()->id())
                <a class="btn btn-secondary ml-2" href="{{ route('developer.task.edit', $task->id) }}">
                <i class="fas fa-edit float-left"></i>
                </a>
                @endif
            @endforeach
        @endif
    </td>
</tr>