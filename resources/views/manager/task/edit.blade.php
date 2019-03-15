@extends('layouts.main')
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manager.task.update', $task->id) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ $task->name }}" autocomplete="off">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description"
                                              class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                              name="description" autocomplete="off">{{ $task->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deadline2" class="col-md-4 col-form-label text-md-right">{{ __('Deadline') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="deadline2"
                                           class="form-control{{ $errors->has('deadline') ? ' is-invalid' : '' }}"
                                           name="deadline" value="{{ Carbon\Carbon::parse($task->deadline)->format('Y/m/d h:i A') }}" autocomplete="off">

                                    @if ($errors->has('deadline'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('deadline') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status2" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                <div class="col-md-6">
                                    <select id="status2" class="form-control status" name="status">
                                        <option value="created" class="taskStatus" {{ $task->status === 'created' ? 'selected' : ''}}>Created</option>
                                        <option value="assigned" class="taskStatus assigned" {{ $task->status === 'assigned' ? 'selected' : ''}}>Assigned</option>
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

                            <div class="form-group row developerName">
                                @if ($errors->has('developer_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('developer_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if ($task->status === 'assigned')
                                <div class="form-group row" id="staticDev">
                                    <label for="developer_name" class="col-md-4 col-form-label text-md-right">Developer Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="developer_name" class="position-relative form-control"
                                               name="developer_name" autocomplete="off"
                                               value="@foreach($task->users as $user) {{ $user ? $user->first_name  : '' }} @endforeach">
                                        <input type="hidden" name="developer_id" id="developer_id"
                                               value="@foreach($task->users as $user){{$user ? $user->id . ',' : '' }}@endforeach">
                                        <div class="form-group position-absolute" id="searchSection">
                                            <select multiple class="form-control d-none" id="searchResult"></select>
                                        </div>
                                    </div>
                                </div>
                            @endif

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