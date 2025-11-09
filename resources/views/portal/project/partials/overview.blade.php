<div id="overview" class="tab-pane">
  <div class="grid md:grid-cols-2 gap-8">
    <div>
      <h3 class="text-xl font-bold mb-4">Client Information</h3>
      <div class="space-y-3 text-sm">
        <div><p class="text-gray-500">Client Name</p><p class="font-medium text-gray-800">{{ $project->customer->firstname ?? '' }} {{ $project->customer->lastname ?? '' }}</p></div>
        <div><p class="text-gray-500">Email</p><p class="font-medium text-gray-800">{{ $project->customer->email ?? '' }}</p></div>
        <div><p class="text-gray-500">Phone</p><p class="font-medium text-gray-800">{{ $project->customer->phone ?? '' }}</p></div>
      </div>
    </div>

    <div>
      <h3 class="text-xl font-bold mb-4">Project Summary</h3>
      @php
        $totalPaid = $project->invoices->sum('total') - $project->invoices->sum('remaining_balance');
        $totalBalance = $project->invoices->sum('remaining_balance');
        $totalBudget = $project->invoices->sum('total');
      @endphp
      <div class="space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-gray-600">Total Budget</span><span class="font-medium">₦{{ number_format($totalBudget) }}</span></div>
        <div class="flex justify-between"><span class="text-gray-600">Paid</span><span class="font-medium">₦{{ number_format($totalPaid) }}</span></div>
        <div class="flex justify-between font-semibold"><span>Balance</span><span>₦{{ number_format($totalBalance) }}</span></div>
      </div>
    </div>
  </div>
</div>
