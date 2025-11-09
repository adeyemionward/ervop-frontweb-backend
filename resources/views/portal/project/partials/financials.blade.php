<div id="invoices" class="tab-pane hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- ======== QUOTATIONS HISTORY ======== --}}
                <div>
                    <h4 class="text-lg font-semibold mb-3">Quotations History</h4>
                    <div class="space-y-3">
                        @forelse ($project->quotations as $quotation)
                            @php
                                $today = \Carbon\Carbon::now();
                                $validUntil = \Carbon\Carbon::parse($quotation->valid_until);

                                if (strtolower($quotation->status) === 'accepted') {
                                    $status = 'Accepted';
                                    $statusColor = 'text-green-700 bg-green-100';
                                } elseif (strtolower($quotation->status) === 'rejected') {
                                    $status = 'Rejected';
                                    $statusColor = 'text-red-700 bg-red-100';
                                } elseif ($validUntil->isPast() && strtolower($quotation->status) !== 'accepted') {
                                    $status = 'Expired';
                                    $statusColor = 'text-gray-700 bg-gray-200';
                                } else {
                                    $status = ucfirst($quotation->status ?? 'Pending');
                                    $statusColor = 'text-yellow-800 bg-yellow-200';
                                }
                            @endphp

                            {{-- CLICKABLE CARD --}}
                            <div
                                onclick="openQuoteModal('{{ $quotation->quotation_no }}')"
                                class="cursor-pointer p-4 bg-gray-50 rounded-lg border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between hover:bg-gray-100 transition"
                            >
                                <div class="mb-2 md:mb-0">
                                    <p class="font-medium text-gray-800">{{ $quotation->quotation_no }}</p>
                                    <p class="text-xs text-gray-500">Subtotal: ₦{{ number_format($quotation->subtotal, 2) }}</p>
                                    <p class="text-xs text-gray-500">Discount: ₦{{ number_format($quotation->discount, 2) }}</p>
                                    <p class="text-xs text-gray-500">Tax: ₦{{ number_format($quotation->tax_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500 font-semibold">Total: ₦{{ number_format($quotation->total, 2) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Valid Until: {{ \Carbon\Carbon::parse($quotation->valid_until)->format('M d, Y') }}</p>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColor }}">{{ $status }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500">No quotations yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ======== INVOICE HISTORY ======== --}}
                <div>
                    <h4 class="text-lg font-semibold mb-3">Invoice History</h4>
                    <div class="space-y-3">
                        @forelse ($project->invoices as $invoice)
                            @php
                                $amountPaid = $invoice->total - $invoice->remaining_balance;
                                $balance = $invoice->remaining_balance;
                                $today = \Carbon\Carbon::now();
                                $dueDate = \Carbon\Carbon::parse($invoice->due_date);

                                if ($balance <= 0) {
                                    $status = 'Paid';
                                    $statusColor = 'text-green-700 bg-green-100';
                                } elseif ($amountPaid > 0 && $balance > 0) {
                                    $status = 'Partially Paid';
                                    $statusColor = 'text-blue-800 bg-blue-200';
                                } elseif ($balance > 0 && $dueDate->isPast()) {
                                    $status = 'Overdue';
                                    $statusColor = 'text-red-700 bg-red-100';
                                } elseif ($amountPaid == 0 && $balance == $invoice->total) {
                                    $status = 'Not Paid';
                                    $statusColor = 'text-gray-700 bg-gray-200';
                                } else {
                                    $status = 'Pending';
                                    $statusColor = 'text-yellow-800 bg-yellow-200';
                                }
                            @endphp

                            {{-- CLICKABLE CARD --}}
                            <div
                                onclick="openInvoiceModal('{{ $invoice->invoice_no }}')"
                                class="cursor-pointer p-4 bg-gray-50 rounded-lg border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between hover:bg-gray-100 transition"
                            >
                                <div class="mb-2 md:mb-0">
                                    <p class="font-medium text-gray-800">{{ $invoice->invoice_no }}</p>
                                    <p class="text-xs text-gray-500">Total: ₦{{ number_format($invoice->total) }}</p>
                                    <p class="text-xs text-gray-500">Paid: ₦{{ number_format($amountPaid) }}</p>
                                    <p class="text-xs text-gray-500">Balance: ₦{{ number_format($balance) }}</p>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColor }}">{{ $status }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500">No invoices yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ======== MODALS ======== --}}
            {{-- === QUOTATION MODAL === --}}
            <div id="quotationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative shadow-lg">
                    <button onclick="closeQuoteModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Quotation Details</h3>
                        <a href="#" class="flex items-center text-purple-700 text-sm hover:underline">
                            <i data-lucide="download" class="w-4 h-4 mr-1"></i> Download PDF
                        </a>
                    </div>

                    {{-- Dummy Quotation Data --}}
                    <div>
                        <p class="text-sm text-gray-700"><strong>Quotation No:</strong> QUO-0001</p>
                        <p class="text-sm text-gray-700"><strong>Date:</strong> Oct 30, 2025</p>
                        <p class="text-sm text-gray-700 mb-3"><strong>Client:</strong> John Doe</p>

                        <table class="w-full text-sm border-t border-gray-200 mt-2">
                            <thead>
                                <tr class="text-left text-gray-600">
                                    <th class="py-1">Item</th>
                                    <th class="py-1 text-right">Qty</th>
                                    <th class="py-1 text-right">Price</th>
                                    <th class="py-1 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Logo Design</td><td class="text-right">1</td><td class="text-right">₦500</td><td class="text-right">₦500</td></tr>
                                <tr><td>Business Card</td><td class="text-right">2</td><td class="text-right">₦250</td><td class="text-right">₦500</td></tr>
                            </tbody>
                        </table>

                        <div class="border-t border-gray-200 mt-3 pt-2 text-right text-sm">
                            <p>Subtotal: ₦1,000</p>
                            <p>Discount: ₦0</p>
                            <p>Tax: ₦0</p>
                            <p class="font-bold">Total: ₦1,000</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === INVOICE MODAL === --}}
            <div id="invoiceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative shadow-lg">
                    <button onclick="closeInvoiceModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Invoice Details</h3>
                        <a href="#" class="flex items-center text-purple-700 text-sm hover:underline">
                            <i data-lucide="download" class="w-4 h-4 mr-1"></i> Download PDF
                        </a>
                    </div>

                    {{-- Dummy Invoice Data --}}
                    <div>
                        <p class="text-sm text-gray-700"><strong>Invoice No:</strong> INV-0005</p>
                        <p class="text-sm text-gray-700"><strong>Issue Date:</strong> Nov 01, 2025</p>
                        <p class="text-sm text-gray-700 mb-3"><strong>Client:</strong> Jane Smith</p>

                        <table class="w-full text-sm border-t border-gray-200 mt-2">
                            <thead>
                                <tr class="text-left text-gray-600">
                                    <th class="py-1">Item</th>
                                    <th class="py-1 text-right">Qty</th>
                                    <th class="py-1 text-right">Price</th>
                                    <th class="py-1 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Website Design</td><td class="text-right">1</td><td class="text-right">₦700</td><td class="text-right">₦700</td></tr>
                                <tr><td>Hosting (1 Year)</td><td class="text-right">1</td><td class="text-right">₦300</td><td class="text-right">₦300</td></tr>
                            </tbody>
                        </table>

                        <div class="border-t border-gray-200 mt-3 pt-2 text-right text-sm">
                            <p>Subtotal: ₦1,000</p>
                            <p>Discount: ₦0</p>
                            <p>Tax: ₦0</p>
                            <p class="font-bold">Total: ₦1,000</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======== SCRIPT ======== --}}
            <script>
                function openQuoteModal(id) {
                    document.getElementById('quotationModal').classList.remove('hidden');
                }
                function closeQuoteModal() {
                    document.getElementById('quotationModal').classList.add('hidden');
                }
                function openInvoiceModal(id) {
                    document.getElementById('invoiceModal').classList.remove('hidden');
                }
                function closeInvoiceModal() {
                    document.getElementById('invoiceModal').classList.add('hidden');
                }
            </script>

