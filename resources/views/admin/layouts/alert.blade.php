<div id="alert" class="position-absolute top-0 end-0 mx-4 my-5" style="z-index: 1500">
  @isset($errors)
    @foreach ($errors as $error)
      <div class="alert fade show bs-toast toast bg-danger alert-dismissible" role="alert">
        {{ $error ?? '' }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
    @endforeach
  @endisset

  @isset($messages)
    @foreach ($messages as $message)
      <div class="alert fade show bs-toast toast bg-info alert-dismissible" role="alert">
        {{ $message ?? '' }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
    @endforeach
  @endisset
</div>
