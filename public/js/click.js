$('.tc-title').click(function(){
    var input = $(this).children();
    if(input[0].localName == 'input' && input[0].checked){
        if($('empty')){
            $('.empty').attr('class', 'data-calc')
        }
        var valArr = input.val().split('|');
        var priceValue = valArr[1];
        var price = '';
        var newPrice;
        var nameValue = valArr[0].trim();
        var nodes = $(this).parents().prev().prev();
        for(var i = 0; i < nodes.length; i++){
            if(nodes[i].className == 'tr option'){
                var nameOption = $(nodes[i])[0].innerText.trim();
            }
        }
        var nodeOptionSetArr = $('.name-option');
        var action = '';
        var nameOptionSet;
        var nodeNameOptionSet;
        var nameValueSet;
        var priceValueSet;
        var priceSetArr;
        var priceSet;
        var nodePriceNewArr;
        var nodeNewOption;
        var nodeNewPrice;
        var amountProduct = $('#qty_value_1').val();
        if(nodeOptionSetArr.length > 0){
            for(var j = 0; j < nodeOptionSetArr.length; j++){
                nodeNameOptionSet = nodeOptionSetArr[j].innerText.split(':');
                nameOptionSet = nodeNameOptionSet[0].trim();
                if(nameOptionSet == nameOption){
                    action = 'option_selected';
                    nameValueSet = nodeNameOptionSet[1].trim();
                    if(nameValue !== nameValueSet){
                        priceSet = getpriceset();
                        priceValueSet = nodeOptionSetArr[j].childNodes[1].value;
                        newPrice = priceSet - priceValueSet * amountProduct + Number(priceValue) * amountProduct;
                        nodeOptionSetArr[j].innerHTML = nameOption+': '+nameValue+'<input type="hidden" value="'+priceValue+'">';
                        getnumbersarr(newPrice);
                    }
                }
            }
            if(action !== 'option_selected'){
                $('#select-option')[0].innerHTML += '\r\n<br><span class="name-option">'+nameOption+': '+nameValue+'<input type="hidden" value="'+priceValue+'"></span>';
                priceSet = getpriceset();
                newPrice = Number(priceSet) + priceValue * amountProduct;
                getnumbersarr(newPrice);
            }
        } else {
            var nodePrice = $('#base')[0].innerText;
            var nodePriceArr = nodePrice.split(' ');
            price = nodePriceArr[1]+'.'+nodePriceArr[3];
            newPrice = Number(price) + priceValue  * amountProduct;
            getnumbersarr(newPrice);
            nodeNewOption = '<span class="name-option">'+nameOption+': '+nameValue+'<input type="hidden" value="'+priceValue+'"></span>';
            $('#select-option').html(nodeNewOption);
            $('#base').hide();
        }
    }
    function getnumbersarr(newPrice){
        var numbersArr = (newPrice).toString().split('.');
        if(numbersArr.length > 1 && numbersArr[1].length < 2){
            numbersArr[1] += '0';
        }
        if(numbersArr.length == 1) numbersArr[1] = 0;
        nodeNewPrice = '<span class="price-set">Цена: '+numbersArr[0]+' руб. '+numbersArr[1]+' коп.</span>';
        $('#new-price').html(nodeNewPrice);
    }
    function getpriceset(){
        nodePriceNewArr = $('.price-set');
        priceSetArr = nodePriceNewArr[0].innerText.split(' ');
        return priceSetArr[1]+'.'+priceSetArr[3];
    }
});
function qtyProd(qtyAction,qtyBox)
{
    qtyValue = document.getElementById(qtyBox);
    var select;
    if($('.empty')[0]) select = '#base';
    else select = '.price-set';
    var priceProdArr = $(select)[0].innerText.split(' ');
    var priceProd = Number(priceProdArr[1]+'.'+priceProdArr[3]);
    var b = 1;
    if(qtyAction == "minus" && qtyValue.value>1)
    {
        b = (qtyValue.value-1)/qtyValue.value;
        qtyValue.value--;
    }
    else if(qtyAction == "plus")
    {
        b = (Number(qtyValue.value)+1)/qtyValue.value;
        qtyValue.value++;
    }
    priceProd *= b;
    var string = priceProd.toString();
    priceProd = string.split('.');
    priceProdArr[1] = priceProd[0];
    if(priceProd.length > 1) {
        if(priceProd[1].length < 2) priceProd[1] += '0';
        priceProdArr[3] = priceProd[1];
    } else priceProdArr[3] = 0;
    $(select)[0].innerText = priceProdArr.join(' ')
}