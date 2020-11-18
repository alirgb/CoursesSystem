@extends('layouts.app')

@section('template_title')
User
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('My Account') }}
                        </span>

                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body d-flex row ">

                    <div class="col">
                        <div class="card-title mb-5"><img src="images/account_image.png" alt="account image" class="img-thumbnail img-sm"></div>
                        <div class="card-title"><b>Role:  </b> {{ $user->role }}</div>
                        <div class="card-title"><b>Name:  </b> {{ $user->name }}</div>
                        <div class="card-title"><b>E-mail:</b> {{ $user->email }}</div>
                    </div>

                    <div class="col d-flex justify-content-end align-items-end">
                        <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                            <a class="btn btn-sm btn-success" href="{{ route('users.edit',$user->id) }}"><i
                                    class="fa fa-fw fa-edit"></i> Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-fw fa-trash"></i>
                                Delete</button>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
@endsection