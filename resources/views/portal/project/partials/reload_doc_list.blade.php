@forelse ($documents as $doc)
    <div class="flex flex-col md:flex-row md:items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
        <div class="flex items-center space-x-3">
            <i data-lucide="file-check-2" class="w-5 h-5 text-green-600"></i>
            <div>
                <p class="font-medium text-gray-800">{{ $doc['title'] }}</p>
                <p class="text-xs text-gray-500">Type: {{ ucfirst($doc['type']) }}</p>
                <p class="text-xs text-gray-500">Shared: {{ \Carbon\Carbon::parse($doc['created_at'])->format('M d, Y') }}</p>

                @if(!empty($doc['file']['status']))
                    <p class="text-xs font-semibold mt-1">
                        Status:
                        <span class="@if($doc['file']['status'] == 'Signed') text-green-700
                                    @elseif($doc['file']['status'] == 'Rejected') text-red-700
                                    @elseif($doc['file']['status'] == 'Pending') text-yellow-800
                                    @elseif($doc['file']['status'] == 'Reviewed') text-blue-600
                                    @elseif($doc['file']['status'] == 'Downloaded') text-purple-600
                                    @else text-gray-700 @endif">
                            {{ ucfirst($doc['file']['status']) }}
                        </span>
                    </p>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-2 mt-2 md:mt-0">
            @if(!empty($doc['file']['file_path']))
                <a href="{{ $doc['file']['file_path'] }}" target="_blank" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="download" class="w-5 h-5"></i>
                </a>
            @endif

            @if(in_array(strtolower($doc['type']), ['nda', 'proposal', 'contract']))
                <button class="px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs hover:bg-purple-100" onclick="openActionModal('{{ $doc['id'] }}','signed')">Upload Signed</button>
                <button class="px-2 py-1 bg-yellow-50 text-yellow-800 rounded-md text-xs hover:bg-yellow-100" onclick="openActionModal('{{ $doc['id'] }}','review')">Review</button>
                <button class="px-2 py-1 bg-red-50 text-red-700 rounded-md text-xs hover:bg-red-100" onclick="openActionModal('{{ $doc['id'] }}','reject')">Reject</button>
            @endif
        </div>
    </div>
@empty
    <p class="text-gray-500">No documents uploaded yet.</p>
@endforelse
