function qtyProd(qtyAction,qtyBox)
{
    qtyValue = document.getElementById(qtyBox);

    if(qtyAction == "minus" && qtyValue.value>0)
    {
        qtyValue.value--;
    }
    else if(qtyAction == "plus")
    {
        qtyValue.value++;
    }
//updateTotals();
}

function updateTotals()
{
    var boxCount = $('#boxCount').val();
    boxCount = eval(boxCount);
    boxCount = boxCount+1;
    var Total = 0;
    for (i=1; i<boxCount; i++)
    {
        var boxValue = $('#qty_value_'+i).val();
        var prodPrice = $('#prodPrice_'+i).val();
        var subTotal = (boxValue*prodPrice);
        Total = Total + subTotal;
    }
    Total = roundNumber(Total,2);
    $('#subTotalJS').html(Total.toFixed(2));
    $('#subTotalJS2').html(Total.toFixed(2));
    $('#cartTotalValue').val(Total);
    //alert (Total);
}

function roundNumber(num, dec) {
    var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
    return result;
}

function submitcart2()
{
    document.cart.submit();
}

function submitcart()
{
    var Total = $('#cartTotalValue').val();
    Total = eval(Total);

    if(Total != 0)
    {
        document.cart.submit();
    }
    else
    {
        alert("Please select a Quantity first");
    }
}