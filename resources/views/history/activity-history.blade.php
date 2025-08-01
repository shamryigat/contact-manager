<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('History') }}
            </h2>
        </x-slot>

        <a href="{{ route('history.download') }}" 
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
            Export to Excel
        </a>

        <table class="w-full bg-white shadow rounded-lg overflow-hidden mt-4">
            <thead class="bg-white">
                <tr>
                    <th class="p-3 text-left">Action</th>
                    <th class="p-3 text-left">Old Data</th>
                    <th class="p-3 text-left">New Data</th>
                    <th class="p-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr class="border-t">
                        <td class="p-3">{{ $log->action }}</td>

                        <!-- Old Data -->
                        <td class="p-3">
                            @if(!empty($log->details['old']))
                                @foreach($log->details['old'] as $key => $value)
                                    [{{ ucfirst($key) }}: {{ $value }}]
                                @endforeach
                            @else
                                -
                            @endif
                        </td>

                        <!-- New Data -->
                        <td class="p-3">
                            @if(!empty($log->details['new']))
                                @foreach($log->details['new'] as $key => $value)
                                    [{{ ucfirst($key) }}: {{ $value }}]
                                @endforeach
                            @else
                                -
                            @endif
                        </td>

                        <td class="p-3">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
