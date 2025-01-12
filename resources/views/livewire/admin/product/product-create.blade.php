<div wire:ignore.self class="modal modal-blur fade" id="modal-product-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button wire:click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="example-text-input" placeholder="">
                    @error('sku')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" name="example-text-input" placeholder="">
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select wire:model="type" class="form-select">
                        <option value="">Type</option>
                        <option value="SIMPLE">SIMPLE</option>
                    </select>
                    @error('type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a wire:click="close" href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                </a>
                <button wire:click="save" type="button" class="btn btn-primary ms-auto">Save</button>
            </div>
        </div>
    </div>
</div>