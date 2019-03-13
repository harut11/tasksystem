<tr>
    <td>{{ $task->name }}</td>
    <td>{{ str_limit($task->description, 10) }}</td>
    <td>{{ $task->status }}</td>
    <td>{{ $task->developer_name }}</td>
    <td>{{ $task->deadline }}</td>
    <td>
        <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
    </td>
</tr>