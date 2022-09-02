@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-75 m-auto row">
                <div class="card-header d-flex justify-content-between">
                    Dashboard

                    <div class="col-lg-1 offset-9 ">
                        <i class="fa-solid fa-bell fa-2x text-primary"></i>
                    </div>

                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(auth()->user()->is_admin)
                        @forelse($notifications as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] User {{ $notification->data['name'] }}
                                ({{ $notification->data['email'] }}) has just ordered.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>

                            @if($loop->last)
                                <a href="#" id="mark-all">
                                    Mark all as read
                                </a>
                            @endif
                        @empty
                            There are no new notifications
                        @endforelse
                    @else
                        You are logged in!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- -------real time notification----------  --}}

{{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}
{{-- <script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('7063aabca6822bc36fc8', {
    cluster: 'ap1'
  });

  var channel = pusher.subscribe('online_shopping');
  channel.bind('order', function(data) {
    iziToast.info({
    title: 'Hello',
    message: data.m,
});
  });
</script> --}}
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    // Echo.private('events')
    // .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message));

    Echo.private('App.Models.User.1')
    .notification((notification) => {
        alert(notification.message);
        console.log(notification.message);
    });
</script>




@endsection
@section('scripts')
@parent

@if(auth()->user()->is_admin)
    <script>

    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('admin.markNotification') }}", {
            method: 'POST',
            data: {
                _token,
                id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
            })
        });
    });
    </script>
@endif
@endsection


