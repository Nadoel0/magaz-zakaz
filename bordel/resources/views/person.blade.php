@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <h2>Create person</h2>
        <form action="{{ route('person.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Name</label>
                <input name="name" class="form-control" placeholder="Enter name">

                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Surname</label>
                <input name="surname" class="form-control" placeholder="Enter surname">

                @error('surname')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-outline-secondary">Create</button>
        </form>
    </div>
@endsection
