@if ($errors->any())
    <div class="dash-highlight">
        <strong>Please fix these fields</strong>
        <p>{{ $errors->first() }}</p>
    </div>
@endif
