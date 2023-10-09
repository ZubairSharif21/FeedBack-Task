@extends('layouts.front.layout')
@section('title')
    {{ Auth::user()->name }} | Profile
@endsection
@push('head')
    <style>
        body {
            background: rgb(224, 222, 222);
        }

        .cont {
            margin-top: 20px;
            min-height: 400px;
            display: flex;
            align-items: center;
        }
    </style>
@endpush
@section('content')
    <div class="container cont bg-light p-5">
        <div class="col-lg-8 mx-auto">
            <h3 class="text-center">User Info</h3>

            <form method="POST" action="{{ route('edit-profile') }}">
                @csrf
                <div class="form-group pb-3">
                    <label for="Username">UserName</label>
                    <input type="text" class="form-control" name="name" id="Username" aria-describedby="emailHelp"
                        value="{{ $user->name }}">
                </div>
                <div class="form-group pb-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                        aria-describedby="emailHelp" value="{{ $user->email }}">
                </div>
                <hr>
                <div class="row pb-4">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Password">
                        </div>

                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputCPassword1">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="exampleInputCPassword1" placeholder="Password">
                        </div>

                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-50">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container cont bg-light p-5">
        <div class="col-lg-8 mx-auto">
            <h3 class="text-center">Question Posted</h3>

            @foreach ($questions as $question)
                <div class="d-flex align-items-center justify-content-around">
                    <div class="accordion-item w-75">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $question->id }}" aria-expanded="false"
                                aria-controls="collapseTwo">
                                {!! Str::limit($question->title, 80, ' ...') !!}
                                <br>
                                Posted at :{{ $question->created_at->format('d-m-Y') }}

                                {{-- {{ $question->title }} --}}
                            </button>
                        </h2>
                        <div id="collapse{{ $question->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>
                                    <div class="row align-items-center justify-content-around">
                                        <div class="col-10">
                                            {!! Str::limit($question->description, 120, ' ...') !!}

                                        </div>
                                        <div class="col-2">
                                            <a href="question/{{ $question->id }}/details">View Details</a>
                                        </div>
                                    </div>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <a class="btn btn-danger" href="question/{{ $question->id }}/delete"><i class="fa fa-trash"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="pt-3 w-75 mx-auto">
                {!! $questions->links('pagination::bootstrap-5') !!}
            </div>

        </div>
    </div>
@endsection
