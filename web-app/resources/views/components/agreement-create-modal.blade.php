<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->

    <dialog id="create_agreement_modal" class="modal">
        <div class="modal-box w-11/12 max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            
            <h3 class="font-bold text-lg mb-6">Create New Agreement</h3>
            {{-- {{ route('agreements.store') }} --}}
            <form action="#" method="POST" class="space-y-6">
                @csrf
                
                <!-- Agreement Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Agreement Title</span>
                        </label>
                        <input type="text" name="title" placeholder="Website Redesign Project" 
                               class="input input-bordered" required />
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Total Value</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <span class="text-base-content/60">$</span>
                            <input type="number" name="value" placeholder="5000" class="grow" required />
                        </label>
                    </div>
                </div>
                
                <!-- Client Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Client Name</span>
                        </label>
                        <input type="text" name="client_name" placeholder="TechCorp Inc." 
                               class="input input-bordered" required />
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Client Email</span>
                        </label>
                        <input type="email" name="client_email" placeholder="client@example.com" 
                               class="input input-bordered" required />
                    </div>
                </div>
                
                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Start Date</span>
                        </label>
                        <input type="date" name="start_date" 
                               class="input input-bordered" required />
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Due Date</span>
                        </label>
                        <input type="date" name="due_date" 
                               class="input input-bordered" required />
                    </div>
                </div>
                
                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description" 
                              class="textarea textarea-bordered h-24" 
                              placeholder="Detailed description of the project scope and deliverables..."
                              required></textarea>
                </div>
                
                <!-- Actions -->
                <div class="modal-action">
                    <button type="button" class="btn btn-outline" onclick="create_agreement_modal.close()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
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
    
</div>