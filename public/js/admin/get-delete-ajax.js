$('document').ready(function()
{
    $('.del').click(function()
    {
        parent=$(this).parent().parent();//получаем родителя нашего span. parent будет содержать объект tr (строку нашей таблицы)
        id=parent.children().first().html(); //id будет содержать id нашей категории, которое берется из первой ячейки строки
        val_url=$(this).parent()[0].baseURI;
        name = parent[0].children[1].innerText;
        confirm_var=confirm('Delete ' + name + '?');//запрашиваем подтверждение на удаление
        if (!confirm_var) return false;
        $.ajax({
            url: val_url+'/'+id, //url куда мы мы передаем delete запрос
            method: 'DELETE',
            data: {'_token':"{{csrf_token()}}" }, //не забываем передавать токен, или будет ошибка.
            success: function(msg)
            {
                parent.remove(); // удаляем строчку tr из таблицы
                alert('Object '+msg+' destroy');
            },
            error: function(msg)
            {
                console.log(msg); // в консоле  отображаем информацию об ошибки, если они есть
            }
        });
    });
});