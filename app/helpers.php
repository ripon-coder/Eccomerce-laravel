<?php

if (!function_exists('format_money')) {
    function format_money($amount, $decimal = 2, $currency = '৳') {
        return $currency . number_format($amount, $decimal);
    }
}

if (!function_exists('cart_total_items')) {
    function cart_total_items() {
        return session('cart') ? count(session('cart')) : 0;
    }
}
