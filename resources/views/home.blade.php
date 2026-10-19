@extends('layout.app')

@section('content')
    <div class="container py-4">
        @if (Session::get('success'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('success') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        </path>
                        <path d="M18.364 5.636l-12.728 12.728"></path>
                        <path d="M5.636 5.636l12.728 12.728"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif


        {{-- Banner --}}
        <div id="banner-carousel" class="carousel slide rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt="Promo buku 1"
                        src="https://img.magnific.com/free-vector/gradient-world-book-day-landing-page-template_23-2149320541.jpg?semt=ais_test_b&w=740&q=80"
                        style="height: 420px; object-fit: cover;" />
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" alt="Promo buku 2"
                        src="https://www.shutterstock.com/image-vector/book-festival-web-banner-design-260nw-2467607305.jpg"
                        style="height: 420px; object-fit: cover;" />
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" alt="Promo buku 3"
                        src="https://www.shutterstock.com/image-vector/book-festival-horizontal-banner-bookstore-260nw-2554793783.jpg"
                        style="height: 420px; object-fit: cover;" />
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" alt="Promo buku 4"
                        src="https://www.shutterstock.com/image-vector/book-fair-festival-horizontal-banner-260nw-2483737645.jpg"
                        style="height: 420px; object-fit: cover;" />
                </div>
            </div>
        </div>
        {{-- Paket Langganan --}}
        <div class="mt-4">
            <div class="d-flex  align-items-center gap-2">
                <span class="badge bg-yellow text-yellow-fg p-2">
                    <i class="fa-solid fa-crown fs-3"></i>
                </span>

                <h2 class="mt-3 text-dark">Paket Langganan</h2>
            </div>

            <div class="row g-4">
                @foreach ($subscriptionPackages as $subscriptionPackage)
                    <div class="col-md-4">
                        <div class="card h-100"
                            style="background: linear-gradient(135deg, #ffffff 0%, {{ $subscriptionPackage->color }} 100%);">
                            <div class="card-body row">
                                <div class="col-4"></div>
                                <div class="col-6 text-center text-dark">
                                    <h2 style="font-weight: bold;">{{ strtoupper($subscriptionPackage->name) }}</h2>
                                    <p class="text-secondary" style="font-weight: bold; margin: 0; !important">PACKAGE</p>
                                    <div>
                                        Rp <span
                                            style="font-size: 2rem;
                                             font-weight: bold;
                                             "
                                            class="text-warning">
                                            {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                                        </span>

                                        <br>
                                        <span
                                            style="font-weight: bold;
                                                margin: 0;
                                                !important"
                                            class="text-secondary">
                                            @if (filled(trim($subscriptionPackage->description ?? '')))
                                                {{ $subscriptionPackage->description }}
                                            @else
                                                PAKET LENGKAP
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Buku Terbaru --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Terbaru</h2>
            </div>
            <div id="wrapper-slider">
                @forelse ($latestBooks as $book)
                    <div class="px-2 h-100 d-flex">
                        <div class="card border-0 shadow-sm package-card h-100 w-100 d-flex flex-column mx-auto">
                            <div class="card-body text-center p-0 d-flex flex-column flex-fill">
                                <div class="p-3 pb-0">
                                    <div class="border rounded d-flex align-items-center justify-content-center overflow-hidden bg-light" style="height: 220px;">
                                        <img class="img-fluid" alt="{{ $book->title }}" src="{{ asset($book->cover) }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="bg-white border-0 text-start p-3 rounded-bottom d-flex flex-column flex-fill">
                                    <div class="d-flex gap-2 mb-3">
                                        <span class="badge bg-secondary text-white"><i
                                                class="fa-solid fa-mobile-screen"></i>
                                            E-Book</span>
                                        <span class="badge bg-primary text-white">3+</span>
                                    </div>
                                    <h5><span style="font-size: 0.8rem;" class="text-secondary">{{ $book->writer }}</span>
                                    </h5>
                                    <h5 style="font-size:1rem;" class="mb-2"><span>{{ $book->title }}</span></h5>
                                    <h6 class="mt-auto pt-2" style="font-size: 1.2rem; font-weight: bold;">Rp
                                        {{ number_format($book->price, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada buku terbaru yang tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- Buku Gratis --}}

        <div class="mt-4">
            <div class="d-flex aligin-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Gratis</h2>
            </div>

            <div class="row g-4">
                @forelse ($freeBooks as $book)
                    <div class="col-4">
                        <div class="card d-flex flex-column h-100">
                            <div class="row row-0 flex-fill">
                                <div class="col-md-4 d-flex align-items-center justify-content-center p-2">
                                    <a href="#" class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset($book->cover) }}"
                                            alt="{{ $book->title }}" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;" />
                                    </a>
                                </div>

                                <div class="col">
                                    <div class="card-body h-100 d-flex flex-column">
                                        <h3 class="card-title">
                                            <div class="badge bg-secondary text-white"><i class="fa-solid fa-mobile me-1"></i>PDF</div>
                                        </h3>
                                        <div class="text-secondary small">
                                            {{ $book->writer }}
                                            <br><span class="text-dark fw-bold">{{ $book->title }}</span>
                                        </div>
                                        <div class="d-flex align-items-center pt-3 mt-auto">
                                            <h3 class="mb-0">
                                                <span class="text-success">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Tidak ada buku gratis yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .slick-prev:before,
        .slick-next:before {
            color: #000;
        }

        #wrapper-slider .slick-track {
            display: flex !important;
        }

        #wrapper-slider .slick-slide {
            height: inherit !important;
            display: flex !important;
        }

        #wrapper-slider .slick-slide > div {
            display: flex;
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#wrapper-slider').slick({
                arrows: true,
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        });
    </script>
@endpush
