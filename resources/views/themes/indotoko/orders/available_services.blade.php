<li class="list-group-item py-3 border-top fw-bold">
    <div class="row align-items-center">
        <div class="col-2 col-md-2 col-lg-2"></div>
        <div class="col-4 col-md-4 col-lg-5">
            Service
        </div>
        <div class="col-3 col-md-2 col-lg-2">
            Estimate
        </div>
        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
            Cost
        </div>
    </div>
</li>
@forelse ($services as $service)
<li class="list-group-item py-3">
    <div class="row align-items-center">
        <div class="col-2 col-md-2 col-lg-2">
            @php
                $serviceName = $service['service'];
                $courier = $service['courier'];
                $addressID = $service['address_id'];
            @endphp
            <input class="form-check-input delivery-package" type="radio" name="delivery_package" id="inlineRadio2" value="{{ $service['service'] }}" onclick="setShippingFee('{{ $serviceName }}', '{{ $courier }}', '{{ $addressID}}')">
        </div>
        <div class="col-4 col-md-4 col-lg-5">
            {{ $service['service'] }} ({{$service['description']}})
        </div>
        <div class="col-3 col-md-2 col-lg-2">
            {{ $service['etd']}}
        </div>
        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
            <span class="fw-bold">IDR {{ $service['cost'] }}</span>
        </div>
    </div>
</li>
@empty
    <li class="list-group-item py-3">
        <span class="text-danger">no delivery service found, try another courier!</span>
    </li>
@endforelse

<script type="text/javascript">
    function setShippingFee(deliveryPackage, courier, addressID) {
        $.ajax({
            url: "/orders/choose-package",
            method: "POST",
            data: {
                delivery_package: deliveryPackage,
                courier: courier,
                address_id: addressID,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (result) {
                $('#shipping-fee').html("IDR " + result.shipping_fee);
                $('#grand-total').html("IDR " + result.grand_total);
            },
            error: function (e) {
                console.log(e);
            }
        })
    }
</script>