<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Product
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/products" wire:navigate class="btn btn-white">
                                Back
                            </a>
                        </span>
                        <button wire:click="update" class="btn btn-primary d-none d-sm-inline-block" type="button">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Save Changes
                        </button>
                        <button class="btn btn-primary d-sm-none btn-icon" aria-label="Create new product">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-8">
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-warning">
                                    <div class="alert-title">Whoops!</div>
                                    There are some problems with your input.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label required">SKU</label>
                                    <div>
                                        <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" />
                                        <small class="form-hint">
                                            Unique code for product.
                                        </small>
                                        @error('sku')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Name</label>
                                    <div>
                                        <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" />
                                        <small class="form-hint">
                                            slug : /product/{{ $product->slug }}
                                        </small>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi Singkat</label>
                                    <textarea wire:model="excerpt" class="summernote form-control @error('excerpt') is-invalid @enderror"></textarea>
                                    @error('excerpt')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Detail</label>
                                    <textarea wire:model="body" class="summernote form-control @error('body') is-invalid @enderror"></textarea>
                                    @error('body')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Setting</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <div>
                                    <select wire:model="status" class="form-control @error('status') is-invalid @enderror">
                                        <option disabled>-- Status --</option>
                                        <option value="INACTIVE">Inactive</option>
                                        <option value="ACTIVE">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Price Setting</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Price</label>
                                <div>
                                    <input wire:model="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sale Price</label>
                                <div>
                                    <input wire:model="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" />
                                    <small class="form-hint">
                                        Sale price (optional)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>