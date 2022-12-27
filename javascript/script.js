$(document).ready(function(){
    /* MODAL START*/
    $(".modal-container").hide();
    $(".closeModal").click(function(){
        $(".modal-container").hide();
    });
    $("#showLogIn").click(function(){
        $("#modal-login").show();
    });
    $("#showRegister").click(function(){
        $("#modal-register").show();
    });
    $("#insertProduct").click(function(){
        $("#modal-insertProduct").show();
    });
    $("#deleteProduct").click(function(){
        $("#modal-deleteProduct").show();
    });
    $("#updateProduct").click(function(){
        $("#modal-updateProduct").show();
    });
    $("#insertCategory").click(function(){
        $("#modal-insertCategory").show();
    });
    $("#deleteCategory").click(function(){
        $("#modal-deleteCategory").show();
    });
    $("#updateCategory").click(function(){
        $("#modal-updateCategory").show();
    });
    /* MODAL END */

    /* CATEGORY BUTTON */
    $("#modifyCategory").click(function(){
        $(".modify-product").hide();
        $(".modify-category").toggle();
    });
    $("#modifyProduct").click(function(){
        $(".modify-category").hide();
        $(".modify-product").toggle();
    });
    /* CATEGORY BUTTON END*/

    $("#update_cat_id").keyup(function(){
        var cat_defaultVal = $(this).val();
        $.ajax({
            url: 'php/category.php',
            type: 'post',
            data: {cat_defaultVal:cat_defaultVal},
            success: function(response){
                $("#updateCatDiv").html(response);
            }
        });
    });
    $("#update_prod_id").keyup(function(){
        var prod_defaultVal = $(this).val();
        $.ajax({
            url: 'php/product.php',
            type: 'post',
            data: {prod_defaultVal:prod_defaultVal},
            success: function(response){
                $("#updateProdDiv").html(response);
            }
        });
    });
});