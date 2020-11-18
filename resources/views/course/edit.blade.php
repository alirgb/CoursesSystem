@extends('layouts.app')

@section('template_title')
    Update Course
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Course</span>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('courses.index') }}"> Back</a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('courses.update', $course->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('course.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
