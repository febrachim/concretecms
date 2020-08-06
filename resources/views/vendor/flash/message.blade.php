@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert
        alert-{{ $message['level'] }}
        alert-dismissible
        fade
        show"
        role="{{ $message['level'] }}">
            {!! $message['message'] !!}

            @if ($message['important'])
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
