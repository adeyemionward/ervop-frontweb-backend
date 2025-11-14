<div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
    <p class="text-gray-700">{{ $note['content'] }}</p>
    <p class="text-xs text-gray-500 mt-2">— {{ $note['author'] }}, {{ \Carbon\Carbon::parse($note['created_at'])->format('M d, Y') }}</p>
</div>
