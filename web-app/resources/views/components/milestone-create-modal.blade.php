<dialog id="create_milestone_modal" class="modal">
    <div class="modal-box w-11/12 max-w-lg bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 shadow-xl rounded-2xl p-0">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:text-blue-600">✕</button>
        </form>
        <div class="px-8 pt-8 pb-2">
            <h3 class="font-bold text-2xl text-blue-900 mb-2 flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add New Milestone
            </h3>
            <p class="text-blue-700 mb-6 text-base">Break your agreement into clear, actionable steps.</p>
        </div>
        <form action="#" class="space-y-8 px-8 pb-8" id="create-milestone-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control md:col-span-2">
                    <label class="label font-semibold text-blue-900">Milestone Title</label>
                    <input type="text" name="title" placeholder="e.g. Initial Design Mockups" class="input input-bordered input-lg bg-white/80 focus:bg-white" required />
                </div>
                <div class="form-control md:col-span-2">
                    <label class="label font-semibold text-blue-900">Description</label>
                    <textarea name="description" class="textarea textarea-bordered textarea-lg bg-white/80 focus:bg-white h-20" placeholder="Describe the deliverable for this milestone..." required></textarea>
                </div>
                <div class="form-control">
                    <label class="label font-semibold text-blue-900">Value (ETH)</label>
                    <input type="number" name="value" min="0" step="0.0001" placeholder="0.5" class="input input-bordered input-lg bg-white/80 focus:bg-white" required />
                </div>
                <div class="form-control">
                    <label class="label font-semibold text-blue-900">Due Date</label>
                    <input type="date" name="due_date" class="input input-bordered input-lg bg-white/80 focus:bg-white" required />
                </div>
            </div>
            <!-- Error/Feedback Area -->
            <div id="milestone-create-feedback" class="hidden text-sm rounded-lg px-4 py-3 mb-2"></div>
            <!-- Actions -->
            <div class="modal-action flex justify-end gap-3 pt-4 border-t border-blue-100">
                <button type="button" class="btn btn-outline btn-lg" onclick="create_milestone_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-600 border-0 hover:from-indigo-600 hover:to-blue-700 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Milestone
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog> 