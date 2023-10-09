@extends('layouts.front.layout')
@section('title')
    Home Page
@endsection
@push('head')
    <style>
        #carouselExampleCaptions img {
            height: 550px !important;
            object-fit: cover
        }

        .accordion-button {
            line-height: 1.8;
        }
    </style>
@endpush
@section('content')
    <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner main-carousel">
            <div class="carousel-item active">
                <img src="https://c4.wallpaperflare.com/wallpaper/932/198/361/dubai-united-arab-emirates-skyscrapers-city-buildings-lot-wallpaper-preview.jpg"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://c4.wallpaperflare.com/wallpaper/590/219/821/5bd374a6c6ba8-wallpaper-preview.jpg"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://e1.pxfuel.com/desktop-wallpaper/542/730/desktop-wallpaper-what-is-osint-and-how-is-it-used-osint.jpg"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    {{-- Slider end --}}
    <h1 class="text-center text-danger my-3">FREQUENTLY ASKED QUESTIONS</h1>
    <div class="container">
        <div class="row mb-3">
            <div class="col-10 mx-auto">
                <div class="row">
                    <div class="col-lg-6"><button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Post Question</button></div>
                    <div class="col-lg-6">
                        <form class="d-flex justify-content-between h-100 align-items-center" method="get" action="{{ route('search') }}">
                            <div class=" w-100">
                                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search here" class="form-control"
                                    id="exampleInputsearch-bar1" aria-describedby="search-barHelp">
                            </div>
                            <button type="submit" class="btn px-4  btn-primary"><i class="fa fa-search"
                                    aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion mb-3" id="accordionExample">

            @foreach ($questions as $question)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $question->id }}" aria-expanded="false" aria-controls="collapseTwo">
                            {!! Str::limit($question->title, 80, ' ...') !!}
                            <br>
                            Posted at :{{ $question->created_at->format('d-m-Y') }}

                            {{-- {{ $question->title }} --}}
                        </button>
                    </h2>
                    <div id="collapse{{ $question->id }}" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
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
            @endforeach

        </div>
        {!! $questions->links('pagination::bootstrap-5') !!}
    </div>
    {{-- {{ $questions->links() }} --}}








    {{-- Modal --}}


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('question/add') }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Question's Title Here"
                                id="title" aria-describedby="emailHelp">
                         </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="image" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Description</label>
                            {{-- <input type="text" class="" id="exampleInputPassword1"> --}}
                            <textarea  id="" class="form-control" cols="20"  name="description" rows="4"
                                placeholder="Enter Discription Abou Question"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn mx-auto w-100 btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
