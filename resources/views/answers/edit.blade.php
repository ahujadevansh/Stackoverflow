@extends('layouts.app')

@section('styles')
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
                        <div class="d-flex"></div>
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
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Your Answer</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id] ) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input id="body" type="hidden" name="body" value="{{ old('body', $answer->body) }}">
                            <trix-editor input="body"></trix-editor>
                            @error('body')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection
