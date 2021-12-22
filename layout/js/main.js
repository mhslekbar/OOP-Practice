$(document).ready(function(){

    'use strict';
    
    $(".msg").fadeTo(1000,100).slideDown(300,function(){
        $(this).slideUp();
    });

    // $("#btnlogin").click(function(e){
    //     // e.preventDefault();
    //     $.ajax({
    //         method: "POST",
    //         url: "",
    //         data: $("#login-form").serialize(),
    //         dataType: "text",
    //         success: function(rs){
    //             $("#msgDipslay").text(rs);
    //         },
    //         error: function(xhr,textStatus,err){
    //             $("#msgDipslay").text("eroor");   
    //         }
    //     })
    // });

    $(".btnEdit").click(function(){
        $("#editModal").show();
        var data = $(this).closest("tr").children("td").map(function(){
            return $(this).text();
        }).get();
   
        $("#regNo").val(data[1]);
        $("#fname").val(data[2]);
        $("#phone").val(data[3]);
        $("#addr").val(data[4]);
        $("#img img").attr("src","layout/images/" + data[5]);

    });

    $(".btnDelete").click(function(){        
        $("#regNb").val($(this).data("delete"));
    });


});