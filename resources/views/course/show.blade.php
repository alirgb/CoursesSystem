@extends('layouts.app')

@section('template_title')
    {{ $course->name ?? 'Show Course' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Course</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $course->name }}
                        </div>
                        <div class="form-group">
                            <strong>Content:</strong>
                            {{ $course->content }}
                        </div>
                        <div class="form-group">
                            <strong>Duration:</strong>
                            {{ $course->duration }}
                        </div>

                        <div class="form-group">
                            <strong>Teacher:</strong>
                            {{ $course->user->name }}
                        </div>

                        <hr />

                        <h4>Course Feedback</h4>

                        {{-- display feedback for teacher and student --}}
                        
                        @foreach($course->students as $student)
                        @if ($student->pivot->feedback!='')
                        <div class="card mb-2 bg-light">
                            <div class="card-body">
                            <div class="card-title mb-1"><b>Student:</b> {{$student->name}}</div>
                                <div class="card-text">
                                    {{$student->pivot->feedback}}
                                </div>
                                <div class="float-right">
                                    @if($student->id==auth()->user()->id)
                                    <form method="post" action="{{ route('courses.deleteFeedback') }}">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}" />
                                        <input type="hidden" name="user_id" value="{{ $student->id }}" />
                                        <input type="submit" class="btn btn-danger" value="Delete Feedback" />
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        {{-- add feedback for students only and enrolled in a course--}}
                        {{-- @if(auth()->user()->role === 'student' && auth()->user()->courses_st->contains($course->id)) --}}
                        @if($course->students->find(auth()->user()))
                        <form method="post" action="{{ route('courses.storeFeedback') }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control{{($errors->has('feedback') ? ' is-invalid' : '')}}" name="feedback"></textarea>
                                {!! $errors->first('feedback', '<div class="invalid-feedback">:message</p>') !!}
                                <input type="hidden" name="course_id" value="{{ $course->id }}" />
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                            </div>
                            
                            <div class="form-group">
                            <input type="submit" class="btn btn-{{ $course->students->find(auth()->user())->pivot->feedback=='' ? 'success' : 'info'}}" value="{{ $course->students->find(auth()->user())->pivot->feedback=='' ? 'Add' : 'Update'}} Feedback" />
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
