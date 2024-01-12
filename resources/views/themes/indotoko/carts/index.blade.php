@extends('themes.indotoko.layouts.app')

@section('content')
<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
    </div>
</section>
<section class="main-content">
    <div class="container">
        <div class="row">
            <section class="col-lg-12 col-md-12 shopping-cart">
                <div class="card mb-4 bg-light border-0 section-header">
                    <div class="card-body p-5">
                        <h2 class="mb-0">Shopping Cart</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        {{ html()->form('PUT', route('carts.update'))->open() }}
                        <ul class="list-group list-group-flush">
                            @foreach ($cart->items as $item)
                            <li class="list-group-item py-3 border-top">
                                <div class="row align-items-center">
                                    <div class="col-6 col-md-6 col-lg-7">
                                        <div class="d-flex">
                                            <img src="{{ asset('img/p1.jpg') }}" alt="Ecommerce" style="height: 70px;">
                                            <div class="ms-3">
                                                <a href="{{ shop_product_link($item->product) }}">
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                </a>
                                                <span>
                                                    @if ($item->product->has_sale_price)
                                                    <small>IDR {{ $item->product->sale_price_label }}</small>
                                                    <small class="text-muted text-decoration-line-through">{{ $item->product->price_label }}</small>
                                                    @else
                                                    <small>IDR {{ $item->product->price_label }}</small>
                                                    @endif
                                                </span>
                                                <div class="mt-2 small lh-1">
                                                    <a href="{{ route('carts.destroy', [$item->id]) }}" onclick="return confirm('Are you sure to delete?')" class="text-decoration-none text-inherit">
                                                        <span class="me-1 align-text-bottom">
                                                            <i class='bx bx-trash'></i>
                                                        </span>
                                                        <span class="text-muted">Remove</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-2">
                                        <input type="number" name="qty[{{ $item->id }}]" value="{{ $item->qty }}" class="form-control" min="1">
                                    </div>
                                    <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                        <span class="fw-bold">IDR {{ $item->sub_total }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-first">Continue Shopping</a>
                            <button type="submit" class="btn btn-second">Update Cart</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="col-12 col-lg-4 col-md-5">
                        <div class="mb-5 card mt-6 shadow">
                            <div class="card-body p-6">
                                <!-- heading -->
                                <h2 class="h5 mb-4">Summary</h2>
                                <div class="card mb-2">
                                    <!-- list group -->
                                    <ul class="list-group list-group-flush">
                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div>Item Subtotal</div>
                                            </div>
                                            <span>{{ $cart->base_total_price_label }}</span>
                                        </li>
                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div>Discount</div>
                                            </div>
                                            <span>{{ $cart->discount_amount_label }}</span>
                                        </li>
                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div class="fw-bold">Subtotal</div>
                                            </div>
                                            <span class="fw-bold">{{ $cart->sub_total_price_label }}</span>
                                        </li>
                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div>Tax</div>
                                            </div>
                                            <span>{{ $cart->tax_amount_label }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-grid mb-1 mt-4">
                                    <!-- btn -->
                                    <a class="btn btn-first btn-lg d-flex justify-content-between align-items-center" href="{{ route('orders.checkout') }}">
                                        Go to Checkout
                                        <span class="fw-bold">{{ $cart->grand_total_label }}</span>
                                    </a>
                                </div>
                                <!-- text -->
                                <p>
                                    <small>
                                        By placing your order, you agree to be bound by the Freshcart
                                        <a href="#!">Terms of Service</a>
                                        and
                                        <a href="#!">Privacy Policy.</a>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection