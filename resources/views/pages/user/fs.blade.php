@extends('layouts.user.main')
@section('content')

<!-- Start Flash Sale Banner Area -->
<section class="banner-area" style="background-image: url('{{ asset('assets/templates/user/img/banner/banner-bg.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="banner-content">
                    <h1>Flash Sale - Up to 50% OFF!</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Flash Sale Banner Area -->

<!-- Start Product Area -->
<section class="section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Flash Sale Products</h1>
                    <p>Get the best deals while they last! Hurry up and grab your favorites.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Single Product -->
            @forelse ($products as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="single-product">
                        <img class="img-fluid" src="{{ asset('images/' . $item->image) }}" alt="">
                        <div class="product-details">
                            <h6>{{ $item->name }}</h6>
                            <div class="price">
                                @if($item->discount > 0)
                                    <h6><del>{{ $item->price }} Points</del></h6>
                                    <h6>{{ $item->price - ($item->price * $item->discount / 100) }} Points</h6>
                                @else
                                    <h6>{{ $item->price }} Points</h6>
                                @endif
                            </div>
                            <div class="prd-bottom">
                                <a class="social-info" href="javascript:void(0);" onclick="confirmPurchase('{{ $item->id }}', '{{ Auth::user()->id }}')">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Beli</p>
                                </a>
                                <a href="{{ route('user.detail.product', $item->id) }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">Detail</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12 col-md-12">
                    <div class="single-product">
                        <h3 class="text-center">Tidak ada produk flash sale saat ini.</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- End Product Area -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmPurchase(productId, userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan membeli produk ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Beli!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/product/purchase/' + productId + '/' + userId;
            }
        });
    }
</script>

@endsection