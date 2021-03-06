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
                            @method('PUT')
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
                                        @if($task->status === 'assigned' || $task->status === 'created')
                                            <option value="created" class="taskStatus" {{ $task->status === 'created' ? 'selected' : ''}}>Created</option>
                                            <option value="assigned" class="taskStatus assigned" {{ $task->status === 'assigned' ? 'selected' : ''}}>Assigned</option>
                                            <option value="inprogress" class="taskStatus" {{ $task->status === 'inprogress' ? 'selected' : ''}}>In Progress</option>
                                            <option value="done" class="taskStatus" {{ $task->status === 'done' ? 'selected' : ''}}>Done</option>
                                        @elseif($task->status === 'inprogress' || $task->status === 'done')
                                            <option value="done" class="taskStatus" {{ $task->status === 'done' ? 'selected' : ''}}>Done</option>
                                            <option value="inprogress" class="taskStatus" {{ $task->status === 'inprogress' ? 'selected' : ''}}>In Progress</option>
                                        @endif
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row developerName"></div>

                                <div class="form-group row {{ $task->status === 'assigned' ? '' : 'd-none' }}" id="staticDev">
                                    <label for="developer_name" class="col-md-4 col-form-label text-md-right">Search Developer</label>
                                    <div class="col-md-6">
                                        <input type="text" id="developer_name" class="position-relative form-control"
                                               name="developer_name" autocomplete="off">
                                        <div class="row mt-3" id="developers">
                                        @foreach($task->users as $user)
                                            <div class="ml-3 item" data-id="{{ $user->id }}">{{ $user->first_name }}
                                                <i class="fas fa-times ml-2 deleteDeveloper"></i>
                                            </div>
                                        @endforeach
                                        </div>
                                        <div id="developers_id">
                                        @foreach($task->users as $user)
                                            <input type="hidden" class="devs" name="{{ $task->status === 'assigned' ? "developers[]" : '' }}" value="{{ $user->id }}">
                                        @endforeach
                                        </div>
                                        <div class="form-group position-absolute" id="searchSection">
                                            <select multiple class="form-control d-none" id="searchResult"></select>
                                        </div>
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

@push('daterangecss')
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('createupdate')
    <script src="{{ asset('js/createupdate.js') }}" defer></script>
@endpush

@push('moment')
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
@endpush

@push('daterangepicker')
    <script src="{{ asset('js/daterangepicker.js') }}" defer></script>
@endpush