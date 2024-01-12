@extends('themes.indotoko.layouts.app')

@section('content')
<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('products') }} ">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="product-images" class="carousel slide" data-ride="carousel">
                    <!-- slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active"> <img src="{{ asset('img/1.jpg') }}" alt="Product 1"> </div>
                        <div class="carousel-item"> <img src="{{ asset('img/2.jpg') }}" alt="Product 2"> </div>
                        <div class="carousel-item"> <img src="{{ asset('img/3.jpg') }}" alt="Product 3"> </div>
                        <div class="carousel-item"> <img src="{{ asset('img/4.jpg') }}" alt="Product 4"> </div>
                    </div> <!-- Left right -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#product-images" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#product-images" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <!-- Thumbnails -->
                    <ol class="carousel-indicators list-inline">
                        <li class="list-inline-item active"> <a id="carousel-selector-0" class="active" data-bs-slide-to="0" data-bs-target="#product-images"> <img src="{{ asset('img/1.jpg') }}" class="img-fluid"> </a> </li>
                        <li class="list-inline-item"> <a id="carousel-selector-1" data-bs-slide-to="1" data-bs-target="#product-images">
                                <img src="{{ asset('img/2.jpg') }}" class="img-fluid"> </a> </li>
                        <li class="list-inline-item"> <a id="carousel-selector-2" data-bs-slide-to="2" data-bs-target="#product-images">
                                <img src="{{ asset('img/3.jpg') }}" class="img-fluid"> </a> </li>
                        <li class="list-inline-item"> <a id="carousel-selector-3" data-bs-slide-to="3" data-bs-target="#product-images">
                                <img src="{{ asset('img/4.jpg') }}" class="img-fluid"> </a> </li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-detail mt-6 mt-md-0">
                    <h1 class="mb-1">{{ $product->name }}</h1>
                    <div class="mb-3 rating">
                        <small class="text-warning">
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star-half"></i>
                        </small>
                        <a href="#" class="ms-2">(30 reviews)</a>
                    </div>
                    <div class="price">
                        @if ($product->hasSalePrice)
                            <span class="active-price text-dark">IDR {{ $product->sale_price_label }}</span>
                            <span class="text-decoration-line-through text-muted ms-1">{{ $product->price_label }}</span>
                            <span><small class="discount-percent ms-2 text-danger">{{ $product->discount_percent }}% Off</small></span>
                        @else
                            <span class="active-price text-dark">IDR {{ $product->price_label }}</span>
                        @endif
                    </div>
                    <hr class="my-6">
                    <div class="product-select mt-3 row justify-content-start g-2 align-items-center">
                        @include ('themes.indotoko.shared.flash')
                        {{ html()->form('post', route('carts.store'))->open() }}
                        <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                        <div class="row">
                            <div class="col-md-2 col-2">
                                <input type="number" name="qty" value="1" class="form-control" min="1" />
                            </div>
                            <div class="col-xxl-4 col-lg-4 col-md-5 col-5 d-grid">
                                <button type="submit" class="btn btn-add-cart"><i class="bx bx-cart-alt"></i> Add to cart</button>
                            </div>
                            <div class="col-md-4 col-4">
                                <a class="btn btn-light" href="shop-wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Wishlist"><i class="bx bx-heart"></i></a>
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    <hr class="my-6">
                    <div class="product-info">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>SKU:</td>
                                    <td>{{ $product->sku}}</td>
                                </tr>
                                <tr>
                                    <td>Availability:</td>
                                    <td>{{ $product->stock_status_label }}</td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td>Fruits</td>
                                </tr>
                                <tr>
                                    <td>Shipping:</td>
                                    <td><small>01 day shipping.<span class="text-muted">( Free pickup today)</span></small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <p>{!! $product->excerpt !!}</p>
                    <hr class="my-6">
                    <div class="product-share">
                        <ul>
                            <li><a href="#"><i class="bx bxl-facebook-circle"></i></a></li>
                            <li><a href="#"><i class="bx bxl-pinterest"></i></a></li>
                            <li><a href="#"><i class="bx bxl-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-description pt-5">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-product-details-tab" data-bs-toggle="tab" data-bs-target="#nav-product-details" type="button" role="tab" aria-controls="nav-product-details" aria-selected="true">Details</button>
                        <button class="nav-link" id="nav-product-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-product-reviews" type="button" role="tab" aria-controls="nav-product-reviews" aria-selected="false">Reviews</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active p-3" id="nav-product-details" role="tabpanel" aria-labelledby="nav-product-details-tab">
                        <div class="my-8">
                        <p>{!! $product->body !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="nav-product-reviews" role="tabpanel" aria-labelledby="nav-product-reviews-tab">
                        <div class="review-form">
                            <h3>Write a review</h3>
                            <form>
                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Your Review</label>
                                    <textarea cols="4" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection