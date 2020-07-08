{!! '<?xml version="1.0" encoding="utf-8"?>' !!}
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{{ date('Y-m-d h:m') }}">
    <shop>
        <name>budynak.by</name>
        <company>ИП Солоневич А.Н.</company>
        <url>https://budynak.by/</url>

        <currencies>
            <currency id="BYN" rate="1"/>
        </currencies>
        <categories>
        @foreach($categories as $cat)
            <category id="{{ $cat->id }}">{{ $cat->name }}</category>
        @endforeach
        </categories>
        <delivery-options>
            <option cost="15" days="3-5" order-before="1"/>
        </delivery-options>
        <offers>
        @foreach($products as $key => $prod)
        <offer id="{{ $key }}" type="vendor.model" available="true">
                <url>{{ secure_url($prod->par_alias.'/'.$prod->alias) }}</url>
                <currencyId>BYN</currencyId>
                <categoryId>{{ $prod->catId }}</categoryId>
                <delivery>true</delivery>
                <vendor>{{ $prod->vendor }}</vendor>
                <price>{{ round($prod->price, 2) }}</price>
                <model>{{ $prod->name }}</model>
                <manufacturer_warranty>true</manufacturer_warranty>
            </offer>
        @endforeach
        </offers>
    </shop>
</yml_catalog>