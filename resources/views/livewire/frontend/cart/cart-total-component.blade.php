<div class="col-md-5 ml-auto">
    <div class="cart-page-total pt-0">
        @if ($cartTotal != 0)
            <h2>Total Carrinho</h2>
            <ul>
                <li>Subtotal<span>R$ {{ $cartSubTotal }}</span></li>
                @if (session()->has('coupon'))
                    <li>
                        Desconto
                        <small>({{ getNumbersOfCart()->get('discountCode') }})</small>
                        <span>R$ {{ $cartDiscount }}</span>
                    </li>
                @endif
                @if (session()->has('shipping'))
                    <li>
                        Entrega
                        <small>({{ getNumbersOfCart()->get('shippingCode') }})</small>
                        <span>R$ {{ $cartShipping }}</span>
                    </li>
                @endif
                <li>Taxa(0%)<span>R$ {{ $cartTax }}</span></li>
                <li>Total<span>R$ {{ $cartTotal }}</span></li>
            </ul>
            <div class="coupon-all">
                <div class="coupon">
                    @if (!session()->has('coupon'))
                        <form wire:submit.prevent="applyDiscount()">
                            <input type="text" wire:model="couponCode" class="input-text" placeholder="Codigo do Cupom"
                                required>
                            <input class="button" value="Aplicar Cupom" type="submit">
                        </form>
                    @endif
                    @if (session()->has('coupon'))
                        <input type="button" wire:click.prevent="removeCoupon()" class="button" value="Remove coupon">
                    @endif
                </div>
            </div>
        @endif

      
    </div>
</div>
