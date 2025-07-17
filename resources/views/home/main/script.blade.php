@section('script')
    <script>
        $(document).ready(function () {
            $('#owl-one').owlCarousel({
                stagePadding: 5,
                rtl: true,
                dots: true,
                nav: false,
                autoplay: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: false,
                        loop: false,
                        margin: 20
                    }
                }
            });
            $('#owl-two').owlCarousel({
                stagePadding: 5,
                rtl: true,
                dots: false,
                nav: false,
                autoplay: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: false,
                        loop: false,
                        margin: 20
                    }
                }
            });
            $('#owl-wrestling').owlCarousel({
                stagePadding: 5,
                rtl: true,
                dots: false,
                nav: false,
                autoplay: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: false,
                        loop: false,
                        margin: 20
                    }
                }
            });

            $('.owl-carousel').each(function () {
                $(this).find('.owl-dot').each(function (index) {
                    $(this).attr('aria-label', "owl dot");
                });
            });
        });
    </script>
    <script>

    </script>
@endsection
