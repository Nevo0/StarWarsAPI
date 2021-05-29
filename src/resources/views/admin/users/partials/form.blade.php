@csrf
@isset($superAdmin )
    @if ($name)
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="hidden" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}@isset($name){{$name}} @endisset" required autocomplete="name" >

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    @endif
@endisset
<div class="form-group row mt-1">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }} @isset($user){{$user->email}} @endisset" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

@isset($create)


<div class="form-group row mt-1">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row mt-1">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
</div>
@endisset
<div class="form-group row mt-3">
    @foreach ($roles as $role)
    <div class="form-check">
        <input class="form-check-input" name="roles[]"
        type="checkbox"
        value="{{$role->id}}"
        id="{{$role->name}}"
        @isset($user)
        @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked
        @endif
        @endisset
        >
        <label for="{{$role->name}}" class="form-check-label">
            {{$role->name}}
        </label>
    </div>
@endforeach
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Submit') }}
        </button>
    </div>
</div>
