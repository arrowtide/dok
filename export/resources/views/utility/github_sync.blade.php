@extends('statamic::layout')
@section('title', 'Github Sync')

@section('content')
    <header class="mb-6">
        @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])
        <div class="flex items-center justify-between">
            <h1>{{ __('Github Sync') }}</h1>
        </div>
    </header>

    <ul class="grid gap-4">
        @foreach (config('dok.resources') as $name => $resource)
            <li class="card">
                <h2 class="font-bold mb-5"><code>{{ $name }}</code></h2>

                <ul class="text-sm text-dark dark:text-light flex flex-wrap gap-2">
                    <li class="badge-pill p-5" style="min-width: 200px;">
                        <span class="flex font-bold gap-2 p-1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"><path d="M13 21V23.5L10 21.5L7 23.5V21H6.5C4.567 21 3 19.433 3 17.5V5C3 3.34315 4.34315 2 6 2H20C20.5523 2 21 2.44772 21 3V20C21 20.5523 20.5523 21 20 21H13ZM13 19H19V16H6.5C5.67157 16 5 16.6716 5 17.5C5 18.3284 5.67157 19 6.5 19H7V17H13V19ZM19 14V4H6V14.0354C6.1633 14.0121 6.33024 14 6.5 14H19ZM7 5H9V7H7V5ZM7 8H9V10H7V8ZM7 11H9V13H7V11Z"></path></svg>
                            {{ __('Repo') }}
                        </span>
                        <code>{{ $resource['repo'] }}</code>
                    </li>
                    <li class="badge-pill p-5" style="min-width: 200px;">
                        <span class="flex font-bold gap-2 p-1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M7.10508 15.2101C8.21506 15.6501 9 16.7334 9 18C9 19.6569 7.65685 21 6 21C4.34315 21 3 19.6569 3 18C3 16.6938 3.83481 15.5825 5 15.1707V8.82929C3.83481 8.41746 3 7.30622 3 6C3 4.34315 4.34315 3 6 3C7.65685 3 9 4.34315 9 6C9 7.30622 8.16519 8.41746 7 8.82929V11.9996C7.83566 11.3719 8.87439 11 10 11H14C15.3835 11 16.5482 10.0635 16.8949 8.78991C15.7849 8.34988 15 7.26661 15 6C15 4.34315 16.3431 3 18 3C19.6569 3 21 4.34315 21 6C21 7.3332 20.1303 8.46329 18.9274 8.85392C18.5222 11.2085 16.4703 13 14 13H10C8.61653 13 7.45179 13.9365 7.10508 15.2101Z"></path></svg>
                            {{ __('Branch') }}
                        </span>
                        <code>{{ $resource['branch'] }}</code>
                    </li>
                    <li class="badge-pill p-5" style="min-width: 200px;">
                        <span class="flex font-bold gap-2 p-1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H20C20.5523 5 21 5.44772 21 6V9H19V7H11.5858L9.58579 5H4V16.998L5.5 11H22.5L20.1894 20.2425C20.0781 20.6877 19.6781 21 19.2192 21H3ZM19.9384 13H7.06155L5.56155 19H18.4384L19.9384 13Z"></path></svg>
                            {{ __('Content') }}
                        </span>
                        <ul class="flex gap-5">
                            @if (isset($resource['content']))
                                @foreach ($resource['content'] as $content)
                                    <li>
                                        <code>`{{ $content }}`</code>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <code>*</code>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="badge-pill p-5" style="min-width: 200px;">
                        <span class="flex font-bold gap-2 p-1 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 13H20V7H11.5858L9.58579 5H4V19H13V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V13ZM20 17H23V19H20V22.5L15 18L20 13.5V17Z"></path></svg>
                            {{ __('Destination') }}
                        </span>
                        <code>content/docs/{{ $name }}</code>
                    </li>
                </ul>

                <div class="flex items-center w-full mt-10">
                    <form method="POST" action="{{ cp_route('utilities.github-sync.make') }}">
                        @csrf
                        <input hidden name="resource" value="{{ $name }}">
                        <button type="button" class="btn github-sync-button">
                            <svg class="h-5 w-5 mr-2 hidden" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="2" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                            <span style="pointer-events: none">{{ __('Sync') }}</span>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('github-sync-button')) {
                const form = event.target.closest('form');

                if (form) {
                    const formData = new FormData(form);

                    document.querySelectorAll('.github-sync-button').forEach(button => {
                        button.disabled = true;
                    });

                    event.target.querySelector('svg').classList.remove('hidden');
                    event.target.querySelector('span').innerText = `{{ __('Syncing...') }}`;

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token')
                        }
                    })
                    .then(response => response.json())
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        document.querySelectorAll('.github-sync-button').forEach(button => {
                            button.disabled = false;
                        });
                        event.target.querySelector('svg').classList.add('hidden');
                        event.target.querySelector('span').innerText = `{{ __('Sync') }}`;


                        window.location.reload();
                    });
                }
            }
        });
    });
</script>
