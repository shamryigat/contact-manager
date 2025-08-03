<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activity History') }}
            </h2>
        </x-slot>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
            <a href="{{ route('history.download') }}"
               class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 w-full sm:w-auto text-center">
                Export to Excel
            </a>
        </div>

        @if($logs->isEmpty())
            <div class="bg-white shadow rounded-lg p-6 text-center text-gray-600">
                No history yet
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Action</th>
                            <th class="p-3 text-left">Old Data</th>
                            <th class="p-3 text-left">New Data</th>
                            <th class="p-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 font-medium text-gray-800">{{ $log->action }}</td>

                                <td class="p-3 text-gray-600">
                                    @if(!empty($log->details['old']))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($log->details['old'] as $key => $value)
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                                    {{ ucfirst($key) }}: {{ $value }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="p-3 text-gray-600">
                                    @if(!empty($log->details['new']))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($log->details['new'] as $key => $value)
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                                    {{ ucfirst($key) }}: {{ $value }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="p-3 text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
