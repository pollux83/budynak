/**
 * Created by User on 22.12.2016.
 */
/*$(document).ready(function() {
 $('.add_button').click(function () {
 var button;
 var list;
 button = $(this); // объект кнопка
 $.ajax({
 url: '/get_parameters',
 type: "POST",
 headers: {
 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
 },
 success: function ($list) {
 button.after($list);
 },
 error: function (msg) {
 console.log(msg);
 }
 });
 });
 });*/
$(document).on('click', '.remove_button', function () {
    var block;
    if (confirm('Delete?')) {
        block = $(this).parent().parent().parent();
        console.log(block);
        //block.remove();
    }
});
$(document).on('click', '.option_button', function () {
    var block;
    block = $(this).parent().parent().parent();
    console.log(block);
    //block.remove();
});