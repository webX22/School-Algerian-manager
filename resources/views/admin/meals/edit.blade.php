@extends('layouts.admin')

@section('title', 'Edit Meal')

@section('content')

<div class="page-header">
    <div>
        <h1>Edit Meal</h1>
        <p>Update the meal information.</p>
    </div>

    <a href="{{ route('meals.index') }}" class="btn btn-secondary">
        ← Back to Meals
    </a>
</div>

<div class="card">

    <form method="POST" action="{{ route('meals.update', $meal) }}">

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label for="name">Meal Name *</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $meal->name) }}"
                    required
                >

                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="meal_type">Meal Type *</label>

                <select id="meal_type" name="meal_type" required>

                    <option value="">Select Meal Type</option>

                    <option
                        value="breakfast"
                        @selected(old('meal_type', $meal->meal_type) === 'breakfast')
                    >
                        Breakfast
                    </option>

                    <option
                        value="lunch"
                        @selected(old('meal_type', $meal->meal_type) === 'lunch')
                    >
                        Lunch
                    </option>

                    <option
                        value="snack"
                        @selected(old('meal_type', $meal->meal_type) === 'snack')
                    >
                        Snack
                    </option>

                    <option
                        value="dinner"
                        @selected(old('meal_type', $meal->meal_type) === 'dinner')
                    >
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
                    value="{{ old('cost', $meal->cost) }}"
                    min="0"
                    step="0.01"
                    required
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
                    placeholder="Describe the meal..."
                >{{ old('description', $meal->description) }}</textarea>

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
                    @checked(old('is_active', $meal->is_active))
                >

                Meal is active
            </label>

        </div>

        <div class="form-actions">

            <a
                href="{{ route('meals.show', $meal) }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection