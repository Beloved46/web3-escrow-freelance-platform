<dialog id="create_agreement_modal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl bg-white border border-gray-200 shadow-xl rounded-2xl p-0">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:text-gray-700">✕</button>
        </form>
        <div class="px-8 pt-8 pb-2">
            <h3 class="font-bold text-2xl text-gray-900 mb-2 flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Create New Agreement
            </h3>
            <p class="text-gray-600 mb-6 text-base">Protect your next deal with on-chain escrow and milestone tracking.</p>
        </div>
        <form action="#" class="space-y-6 px-8 pb-8" id="create-agreement-form">
            <!-- Agreement Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-900">Agreement Title</span>
                    </label>
                    <input type="text" name="title" placeholder="e.g. Website Redesign Project" class="input input-bordered w-full bg-white text-gray-800 placeholder-gray-400 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none" required />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-900">Client Email</span>
                    </label>
                    <input type="email" name="client_email" id="client_email_input" placeholder="client@email.com" class="input input-bordered w-full bg-white text-gray-800 placeholder-gray-400 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none" required />
                    <label class="label">
                        <span class="label-text-alt text-gray-500">Enter the email of the person you want to create an agreement with.</span>
                    </label>
                    <span id="client_email_error" class="text-xs text-red-600 hidden"></span>
                </div>
            </div>
            
            <!-- Creator Information -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-gray-900">Creator's Wallet Address</span>
                </label>
                <input type="text" name="creator_address" id="creator_address_input" class="input input-bordered w-full bg-gray-50 text-gray-800 placeholder-gray-400 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none" placeholder="0x..." readonly required />
                <label class="label">
                    <span id="wallet_address_helper" class="label-text-alt text-gray-500">This will be auto-filled with the creator's wallet address from their email.</span>
                </label>
            </div>
            
            <!-- Project Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-900">Due Date</span>
                    </label>
                    <input type="date" name="due_date" class="input input-bordered w-full bg-white text-gray-800 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none" required />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-900">Project Value (USDC)</span>
                        <span id="eth-price-display" class="label-text-alt text-gray-500">Loading...</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="usdc_value" id="usdc_value_input" step="1" min="0" placeholder="1000" class="input input-bordered w-full bg-white text-gray-800 placeholder-gray-400 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none pr-20" required />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 text-sm font-medium">USDC</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <span id="eth-equivalent" class="font-medium">≈ 0.0000 ETH</span>
                        <span class="text-gray-400 ml-2">(converted automatically)</span>
                    </div>
                    <!-- Hidden field for ETH value -->
                    <input type="hidden" name="value" id="eth_value_hidden" />
                </div>
            </div>
            
            <!-- Description -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-gray-900">Project Description</span>
                </label>
                <textarea name="description" class="textarea textarea-bordered w-full h-24 bg-white text-gray-800 placeholder-gray-400 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none resize-none" placeholder="Detailed project scope and deliverables..." required></textarea>
            </div>
            
            <!-- Error/Feedback Area -->
            <div id="agreement-create-feedback" class="hidden text-sm rounded-lg px-4 py-3"></div>
            
            <!-- Actions -->
            <div class="modal-action flex justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
                <button type="button" class="btn btn-outline text-gray-700 border-gray-300 hover:bg-gray-50 px-6" onclick="create_agreement_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 border-0 hover:from-indigo-700 hover:to-blue-700 shadow-lg px-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Agreement
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

