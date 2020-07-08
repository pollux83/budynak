var qtyCartview = $('.qtycart');
var sumAmountProd = 0;
if(localStorage['budynak_qty']) {
    sumAmountProd = localStorage.getItem('budynak_qty');
    getQtyProdForCart();
    cartview();
}
function addToCart(){
    var name = [];
    name[0] = $('.prodCat > h1')[0].innerText;
    name[1] = $('#select-option')[0].innerText;
    name.join(', ');
    var checked = $('input:checked');
    var amountOptions = $('div.option').length;

    if(amountOptions > (checked.length)) {
        alert('Вы не выбрали все опции!');
        return;
    }
    var price;
    if($('.price-set').length > 0) price = $('.price-set')[0].innerText.split(' ');
    else price = $('#base')[0].innerText.split(' ');
    price.shift();
    price = price.join(' ');
    var id = $('input[name="id"]').val();

    var idValue = [];
    var data = [];
    qtyProd = Number($('input#qty_value_1').val());
    if(localStorage['budynak_cart']) {
        data = JSON.parse(localStorage.getItem('budynak_cart'));
    } else {
        localStorage.setItem ('budynak_qty', qtyProd);
    }
    for (var i = 0;i < checked.length;i++){
        idValue.push(checked[i].value.split('|')[2]);
    }
    idValue.pop();
    var newDataProd = {
        'id': id,
        'idValue': idValue,
        'qty': qtyProd,
        'price': price,
        'name': name
    };
    data.push(newDataProd);
    localStorage.setItem ('budynak_cart', JSON.stringify(data));
    sumAmountProd = sumAmountProd*1 + qtyProd*1;
    localStorage.setItem ('budynak_qty', sumAmountProd);
    getQtyProdForCart();
    if(data.length <= 1) createNewCartview();
    if(id >= 0) {
        $("#notice-has-product").fadeIn('300');
        setTimeOut(function(){$("#notice-has-product").fadeOut('300').remove();}, 3000)
    }
    addRowToCartview(data, data.length-1);
}
function getQtyProdForCart(){
    for(var j = 0; j <= 1; j++){
        qtyCartview[j].innerText = sumAmountProd;
    }
}
function cartview(){
    var data = JSON.parse(localStorage.getItem('budynak_cart'));
    createNewCartview();
    for (var i=0;i < data.length;i++){
        addRowToCartview(data, i);
    }
}
function createNewCartview(){
    $('#list-empty').remove();
    createNodeListCartview();
}
function addRowToCartview(data, i){
    var html = '';
    html += '<div class="tr">';
    html += '<div class="tc tc-title" style="padding: 0;"><div class="qty"><span class="pr-now">'+(Number(i)+1)+'</span></div></div><div class="tc tc-spc"></div>';
    html += '<div class="tc tc-title" style="padding: 0;"><span style="font-size: 75%; padding-left: 5px;">'+data[i].name+'</span></div><div class="tc tc-spc"></div>';
    html += '<div class="tc tc-price" style="padding: 0;"><span style="font-size: 75%">'+data[i].price+'</span></div><div class="tc tc-spc"></div>';
    html += '<div class="tc tc-title" style="padding: 0;"><div class="qty"><span class="pr-now" style="font-size: 90%">'+data[i].qty+' шт.</span></div></div><div class="tc tc-spc"></div>';
    html += '<div class="tc tc-title" style="padding: 0;"><button style="color: #ffffff;" class="remove-btn tr-a" onclick="removeProduct(null, '+i+');"><i class="fa fa-trash"></i></button></div>';
    html += '</div>';
    html += '<div class="tr tr-spc"><div class="tc"></div><div class="tc"></div><div class="tc"></div><div class="tc"></div><div class="tc"></div><div class="tc"></div></div>';
    $('.list-product').append(html);
}
function deleteToCart() {
    localStorage.removeItem('budynak_qty');
    localStorage.removeItem('budynak_cart');
}
function removeProduct(cart, number){
    if(arrUrl.length == 2 && !cart) {
        alert('На странице "Заказ" удалить товар можно только в "Списке товаров"!');
        return;
    }
    var data = JSON.parse(localStorage.getItem('budynak_cart'));
    var name = data[number].name;
    if(!confirm('Удалить '+name+'?')) return;
    var minusProd = Number(data[number].qty);
    sumAmountProd -= minusProd;
    data.splice(number, 1);
    localStorage.setItem('budynak_cart', JSON.stringify(data));
    localStorage.setItem('budynak_qty', sumAmountProd);
    getQtyProdForCart();
    alert('Товар будет удален из заказа!');
    $('.cartview > .tbl').remove();
    cartview();
    if(sumAmountProd < 1) {
        deleteToCart();
        if(cart) window.location=cart;
        location.reload();
    }
}
function createNodeListCartview(){
    var cart = '<div class="tbl mt20"><div class="tbl mt20 list-product"><div class="tr tr-top"><div class="tc">№</div><div class="tc tc-spc"></div><div class="tc tc-dis"><span>Название товара</span></div><div class="tc tc-spc"></div><div class="tc">Цена</div><div class="tc tc-spc"></div><div class="tc">Количество</div><div class="tc tc-spc"></div><div class="tc">Удалить?</div></div><div class="tc tc-spc"></div>';
    cart += '</div><input type="submit" value="Оформить заказ" class="fr mt20 tr-a"><input type="button" value="Очистить" onclick="deleteToCart(); location.reload();" class="mt20 tr-a">';
    $('.cartview').append(cart);
}
var data = {};
var currentUrl = window.location.href;
var currentName;
if(currentUrl.split('/')[3] == '') currentName = 'Главная';
else currentName = $('h1').text();
var block = $('.visited ul li:last');
if(localStorage['visited']) data = JSON.parse(localStorage.getItem('visited'));
delete data[currentName];
for (var key in data){
    block.append('<li><a href="'+data[key]+'">'+key+'</a> <i class="fa fa-arrows-h"></i></li>');
}
block.append('<li>'+currentName+'</li>');
data[currentName] = currentUrl;
localStorage.setItem ('visited', JSON.stringify(data));