@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h4 class="float-left">
                        Welcome <b>{{auth()->user()->name }}</b> !
                    </h4>

                </div>


                @if( auth()->user()->role==='student' )

                @if( !auth()->user()->courses_st->isEmpty())

                <div class="card mt-2">
                    <div class="card-header">My Enrolled Courses</div>
                    @foreach(auth()->user()->courses_st as $course)
                    <div class="card mt-1 bg-light">
                        <div class="card-body">
                            <h4 class="card-title">{{ $course->name }}</h4>
                            <h6 class="card-subtitle mb-3 text-muted">Enrolled at {{$course->created_at}}</h6>
                            <p class="card-text">
                                Content: {{$course->content}}
                            </p>
                            <div class="float-right">
                                <a class="btn btn-info" href="{{ route('courses.show',$course->id) }}">Give Feedback</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-title"></div>
                        <p class="card-text">You haven't enrolled in any Courses yet</p>
                    </div>
                </div>
                @endif

                @endif
            </div>
        </div>
    </div>
</div>
@endsection