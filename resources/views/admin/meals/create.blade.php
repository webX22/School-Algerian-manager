@extends('layouts.admin')

@section('title', 'Add Meal')

@section('content')

<div class="page-header">
    <div>
        <h1>Add Meal</h1>
        <p>Create a new meal for the school restaurant.</p>
    </div>

    <a href="{{ route('meals.index') }}" class="btn btn-secondary">
        ← Back to Meals
    </a>
</div>

<div class="card">

    <form method="POST" action="{{ route('meals.store') }}">

        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label for="name">Meal Name *</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Example: Couscous with Chicken"
                >

                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="meal_type">Meal Type *</label>

                <select id="meal_type" name="meal_type" required>
                    <option value="">Select Meal Type</option>

                    <option value="breakfast" @selected(old('meal_type') === 'breakfast')>
                        Breakfast
                    </option>

                    <option value="lunch" @selected(old('meal_type') === 'lunch')>
                        Lunch
                    </option>

                    <option value="snack" @selected(old('meal_type') === 'snack')>
                        Snack
                    </option>

                    <option value="dinner" @selected(old('meal_type') === 'dinner')>
                        Dinner
                    </option>
                </select>

                @error('meal_type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cost">Estimated Cost (DA) *</label>

                <input
                    type="number"
                    id="cost"
                    name="cost"
                    value="{{ old('cost', '0.00') }}"
                    min="0"
                    step="0.01"
                    required
                    placeholder="0.00"
                >

                @error('cost')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Describe the meal and its contents..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="form-group checkbox-group">

            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    checked
                >

                Meal is active
            </label>

        </div>

        <div class="form-actions">

            <a href="{{ route('meals.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Create Meal
            </button>

        </div>

    </form>

</div>

@endsection