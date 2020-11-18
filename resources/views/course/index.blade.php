@extends('layouts.app')

@section('template_title')
Course
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Courses') }}
                        </span>
                        
                        @if(auth()->user()->role === 'teacher')
                        <div class="float-right">
                            
                            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Create New Course') }}
                            </a>
                            
                        </div>
                        @endif
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Course</th>
                                    @if(auth()->user()->role === 'student')
                                    <th>Teacher</th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $course->name }}</td>
                                    @if(auth()->user()->role === 'student')
                                    <td>{{ $course->user->name }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary "
                                            href="{{ route('courses.show',$course->id) }}"><i
                                                class="fa fa-fw fa-eye"></i>Show</a>

                                        <a class="btn btn-sm btn-success {{ auth()->user()->courses_st->contains($course->id) ? 'disabled' : '' }}"
                                            href="{{ route('courses.enroll',$course->id) }}"><i
                                                class="fa fa-fw fa-eye"></i>Enroll</a>


                                    </td>

                                    @else
                                    <td>
                                        <form action="{{ route('courses.destroy',$course->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary "
                                                href="{{ route('courses.show',$course->id) }}"><i
                                                    class="fa fa-fw fa-eye"></i> Show</a>
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('courses.edit',$course->id) }}"><i
                                                    class="fa fa-fw fa-edit"></i> Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-fw fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $courses->links() !!}
        </div>
    </div>
</div>
@endsection