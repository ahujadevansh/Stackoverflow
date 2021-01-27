@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $question->title }}</h1>
                    </div>
                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between mr-3">
                            <div class="d-flex">
                                <div>
                                    @can('vote', $question)
                                        <form action="{{ route('questions.upvote', [$question->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn {{ auth()->user()->hasQuestionUpVote($question) ? 'text-dark': 'text-black-50' }}">
                                                <i class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" title="Up Vote" class="vote-up d-block text-center text-black-50">
                                            <i class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                    <h4 class="votes-count text-muted text-center m-0">{{ $question->votes_count }}</h4>
                                    @can('vote', $question)
                                        <form action="{{ route('questions.downvote', [$question->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn {{ auth()->user()->hasQuestionDownVote($question) ? 'text-dark': 'text-black-50' }}">
                                                <i class="fa fa-caret-down fa-3x" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" title="Up Vote" class="vote-up d-block text-center text-black-50">
                                            <i class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                </div>
{{--
                                <div class="ml-5 mt-2">
                                    <a href="" title="Mark as favorite" class="favorite d-block text-center mb-2">
                                        <i class="fa fa-star fa-2x text-dark" aria-hidden="true"></i>
                                    </a>
                                    <h4 class="votes-count m-0 text-center">123</h4>
                                </div> --}}

                                <div class="ml-5 mt-2 {{ $question->is_favourite ? 'text-warning' : 'text-black-50'}}">
                                    @can('markAsFavourite', $question)
                                        @if ($question->is_favourite)
                                            <form action="{{ route('questions.unfavourite', $question) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn text-warning" type="submit">
                                                    <i class="fa fa-star fa-2x" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('questions.favourite', $question) }}" method="POST">
                                                @csrf
                                                <button class="btn text-black-50" type="submit">
                                                    <i class="fa fa-star-o fa-2x" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn text-black-50">
                                            <i class="fa fa-star-o fa-2x" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                    <h4 class="votes-count m-0 text-center">{{ $question->favourites_count }}</h4>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="text-muted mb-2 text-right">
                                    Asked {{ $question->created_date }}
                                </div>
                                <div class="d-flex mb-2">
                                    <div>
                                        <img src="{{ $question->owner->avatar }}" alt="">
                                    </div>
                                    <div class="mt-2 ml-2">
                                        {{ $question->owner->name }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('answers._index')
        @include('answers._create')


    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection

