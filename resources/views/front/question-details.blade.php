@extends('layouts.front.layout')
@section('title')
    Question | Detals
@endsection
@push('head')
    <script src="https://cdn.tiny.cloud/1/jiz33btxn4zvqly7i2xgw4pntj86c3zvgnjwwuuiipt5522g/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <style>
        @media (max-width: 768px) {
            .tinymce-container {
                width: 100%;
                height: 400px;
            }
        }

        .question-image img {
            width: 100%;
            height: 400px;
        }

        /* Basic styles (customize as needed) */
        .vote-button {
            cursor: pointer;
        }

        .visually-hidden {
            position: absolute;
            clip: rect(1px, 1px, 1px, 1px);
            padding: 0;
            border: 0;
            height: 1px;
            width: 1px;
            overflow: hidden;
            white-space: nowrap;
        }


        .vote-input:checked+.vote-button {
            color: #3498db;
            /* Change color when selected */
        }


        .vote-count {
            font-size: 24px;
            margin: 0;
            text-align: center;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="question-image">
            @if ($question->image)
                <img src="{{ asset('storage/' . $question->image) }}" alt="{{ $question->image }}">
                {{-- {{$question->image}} --}}
            @else
                <img src="https://media.istockphoto.com/id/1409329028/vector/no-picture-available-placeholder-thumbnail-icon-illustration-design.jpg?s=612x612&w=0&k=20&c=_zOuJu755g2eEUioiOUdz_mHKJQJn-tDgIAhQzyeKUQ="
                    alt="">
            @endif
        </div>
        <div class="row">
            <div class="col-lg-6">
                <strong class="ps-5">AuthorName : {{ $question->user->name }}</strong>
            </div>

            <br>

            <div class="col-lg-6 text-end">
                <span class="pe-5">Posted at : {{ $question->created_at->format('d-m-Y') }}</span>
                <span class="pe-5">Comments : {{ count($comments) }}</span>
            </div>
        </div>
        <h2 class="mt-4 ps-4">{!! Str::limit($question->title, 100, ' ...') !!} </h2>

        <p class="ps-4 fs-5">{{ $question->description }}</p>
        <hr>
        <section class="ps-3">

            <h5 class="text-center">Comments Section</h5>
            @if (!empty($comments->isNotEmpty()))
                @foreach ($comments as $comment)
                    <div class="d-flex pb-3 align-items-center">
                        <div class="d-flex justify-content-between">
                            <div class="rating-options">
                                <form class="voting-form d-flex flex-column">
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    <button class="btn btn-link vote-button upvote" data-vote-type="upvote">
                                        <i class="fa-solid fa-chevron-up fs-2"></i>
                                    </button>
                                    <p class="text-center fs-4" id="upvote-count-{{ $comment->id }}">
                                        {{ $comment->vote->where('vote_type', 'upvote')->count() }}
                                    </p>


                                    <button class="btn btn-link vote-button downvote" data-vote-type="downvote">
                                        <i class="fa-solid fa-chevron-down fs-2"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex">
                                <div class="voting-count">
                                    <span class="total-votes">{{ $comment->total_votes }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card w-100">
                            <div class="card-header">
                                <h6>Author : {{ $comment->user->name }}</h6>

                            </div>
                            <div class="card-body">
                                {!! $comment->comment !!}

                            </div>
                            <div class="card-footer">

                                <div class="d-flex justify-content-between">
                                    <div class="rating-options">
                                        <form class="rating-form">
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <label class="radio-label ps-3">
                                                <input type="radio" name="rating" value="excelent" class="auto-submit">
                                                <span class="rating-option">Excellent</span>
                                            </label>
                                            <label class="radio-label ps-3">
                                                <input type="radio" name="rating" value="good" class="auto-submit">
                                                <span class="rating-option">Good</span>
                                            </label>
                                            <label class="radio-label ps-3">
                                                <input type="radio" name="rating" value="bad" class="auto-submit">
                                                <span class="rating-option">Bad</span>
                                            </label>
                                        </form>

                                    </div>
                                    @php
                                        $excellentPercent = 0;
                                        $goodPercent = 0;
                                        $badPercent = 0;
                                        $comment = App\Models\Comment::find($comment->id);
                                        $totalReviews = $comment->reviews()->count();
                                        $excellentCount = $comment
                                            ->reviews()
                                            ->where('reviews', 'excelent')
                                            ->count();
                                        $goodCount = $comment
                                            ->reviews()
                                            ->where('reviews', 'good')
                                            ->count();
                                        $badCount = $comment
                                            ->reviews()
                                            ->where('reviews', 'bad')
                                            ->count();

                                        if ($totalReviews) {
                                            $excellentPercent = ($excellentCount / $totalReviews) * 100;
                                            $goodPercent = ($goodCount / $totalReviews) * 100;
                                            $badPercent = ($badCount / $totalReviews) * 100;
                                        }

                                    @endphp

                                    <div class="d-flex">
                                        <div class="rating-percent">
                                            <span>Excellent:</span>
                                            <span id="excellentPercent-{{ $comment->id }}">
                                                @if ($excellentPercent)
                                                    {{ $excellentPercent }}
                                            </span> %
                                        @else
                                            0 %
                @endif
    </div>
    <div class="rating-percent">
        <span>Good:</span>
        <span id="goodPercent-{{ $comment->id }}">
            @if ($goodPercent)
                {{ $goodPercent }}
        </span> %
    @else
        0 %
        @endif

    </div>
    <div class="rating-percent">
        <span>Bad:</span>
        <span id="badPercent-{{ $comment->id }}">
            @if ($badPercent)
                {{ $badPercent }}
        </span> %
    @else
        0 %
        @endif
    </div>
    </div>
    </div>
    </div>

    </div>

    </div>
    @endforeach
@else
    <h3 class="p-5 text-center" style="background: skyblue">No Comments Yet</h3>
    @endif
    <div class="mx-end  ps-5">
        {!! $comments->links('pagination::bootstrap-5') !!}
    </div>
    <h4 class="text-center">Add Your Comment</h4>
    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('add-comment') }}">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <textarea name="comment" rows="3" cols="100"></textarea>
            <br>
            <button class=" btn btn-primary my-1" type="submit">Add Comment</button>
        </form>

    </div>

    </section>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea[name="comment"]', // Target the textarea by name attribute
            height: 300,
            width: 900,
            plugins: 'autoresize link',
            toolbar: 'undo redo | bold italic | link',
            menu: {
                file: {
                    title: 'File',
                    items: ''
                },
                insert: {
                    title: 'insert',
                    items: ''
                },
                format: {
                    title: 'format',
                    items: ''
                },
                edit: {
                    title: 'Edit',
                    items: ''
                },
                view: {
                    title: 'View',
                    items: ''
                },
            },

            branding: false, // Disable the TinyMCE branding
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.voting-form').submit(function(e) {
                e.preventDefault();

                const commentId = $(this).find('input[name="comment_id"]').val();
                const voteType = $(this).find('button.clicked').data('vote-type');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('add-vote') }}',

                    data: {
                        _token: '{{ csrf_token() }}',
                        comment_id: commentId,
                        vote_type: voteType
                    },
                    success: function(data) {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                        console.log(data.upvote_count)
                        $('#upvote-count-' + commentId).text(data.upvote_count);

                    },
                    error: function(error) {
                        console.error('An error occurred:', error);
                    }
                });
            });
            $('.vote-button').click(function() {
                const voteType = $(this).data('vote-type');
                const form = $(this).closest('form');
                const upvoteButton = form.find('.upvote');
                const downvoteButton = form.find('.downvote');

                if ($(this).hasClass('clicked')) {
                    $(this).removeClass('clicked');
                } else {
                    $(this).addClass('clicked');
                    if (voteType === 'upvote') {
                        downvoteButton.removeClass('clicked');
                    } else {
                        upvoteButton.removeClass('clicked');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.auto-submit').change(function() {
                const form = $(this).closest('form');
                const commentId = form.find('input[name="comment_id"]').val();
                const rating = form.find('input[name="rating"]:checked').val();

                $.ajax({
                    type: 'POST',
                    url: '/add-rating',
                    data: {
                        _token: '{{ csrf_token() }}',
                        commentId: commentId,
                        rating: rating
                    },
                    success: function(data) {
                        // alert(commentId)
                        document.getElementById('excellentPercent-' + commentId).textContent =
                            data.excellent_percent.toFixed(0);
                        document.getElementById('goodPercent-' + commentId).textContent = data
                            .good_percent.toFixed(2);
                        document.getElementById('badPercent-' + commentId).textContent = data
                            .bad_percent.toFixed(2);

                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.error) {
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'error',
                                title: error.responseJSON.error
                            });
                        } else {
                            console.error('An error occurred:', error);
                        }
                    }
                });
            });
        });
    </script>
@endsection
