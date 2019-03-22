@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update') }}: {{ $task->name }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('developer.task.update', $task->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="status3" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                <div class="col-md-6">
                                    <select id="status3" class="form-control status3" name="status">
                                        <option value="inprogress" class="taskStatus" {{ $task->status === 'inprogress' ? 'selected' : ''}}>In Progress</option>
                                        <option value="done" class="taskStatus" {{ $task->status === 'done' ? 'selected' : ''}}>Done</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection