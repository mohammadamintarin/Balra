<script>
    function toggleModal() {
        document.getElementById('modal').classList.toggle('hidden')
    };
    $('.province-select').change(function () {
        var provinceID = $(this).val();
        if (provinceID) {
            $.ajax({
                type: "GET",
                url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                success: function (res) {
                    if (res) {
                        $(".city-select").empty();

                        $.each(res, function (key, city) {
                            console.log(city);
                            $(".city-select").append('<option value="' + city.id + '">' +
                                city.name + '</option>');
                        });

                    } else {
                        $(".city-select").empty();
                    }
                }
            });
        } else {
            $(".city-select").empty();
        }
    });
    $('#address-input').val($('#address-select').val());
    $('#address-select').change(function () {
        $('#address-input').val($(this).val());
    });
    $('#date-input').val($('.date').find(":selected").text());
    $('.date').change(function () {
        $('#date-input').val($(this).val());
    });

    $(document).ready(function () {
        if ($('#zarinpal').prop('checked', true)) {
            let total = $('#temp').text();
            let cashback = $('#cashback').text().replace(',' , '');
            let discountAmount = $('#onlineDiscountAmount').text(number_format(total * 5 / 100));
            // $('#total').text(number_format(total - total * 10 / 100));
            $('.discount').fadeIn();
            $('.final').text(number_format( total - total * 5 / 100 - cashback.replace(',' , '') ));
        }else{

        }
    });
    function onlineDiscount() {
        location.reload();
    }
    function snappay(amount)
    {
        $('.discount').fadeOut();
        $('#total').text(number_format(amount));
        $('#onlineDiscountAmount').text(0);
        let copoun = $('.copoun').text().replace(',' , '');
        $('.final').text(number_format( amount - copoun ));

    }


</script>
