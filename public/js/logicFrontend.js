$(".like").css("cursor", "pointer");
$(".dislike").css("cursor", "pointer");

var url = "http://localhost/proyectos_php/instagram/public/";

function like(){ 
   $(".like").unbind("click").click(function(){
       $(this).attr("src", url+"img/black-heart.png");
       $(this).addClass("dislike").removeClass("like");

        $.ajax({
            url: url+"dislike/"+$(this).data("id"),
            type: "GET",
            success: function(response){
                if(response.like){
                    console.log("Has dado dislike");
                }
                else{
                    console.log("error dislike");
                }
               // console.log("likes "+ response.likes);
               //  $(this).parent().find(".likes").innerhtml = "response.likes";

            }
        });

       dislike();

   });
}

function dislike(){ 
   $(".dislike").unbind("click").click(function(){
        $(this).attr("src", url+"img/red-heart.png");
        $(this).addClass("like").removeClass("dislike");
      
        $.ajax({
            url: url+"like/"+$(this).data("id"),
            type: "GET",
            success: function(response){
                if(response.like){
                    console.log("Has dado like");
                }
                else{
                    console.log("error like");
                }
               // console.log("likes "+response.likes);
                // $(this).parent().find(".likes").innerhtml = "response.likes";
            }
        });

        like();
    });
   
}
like();
dislike();

$("#formSearch").submit(function(){
    $(this).attr("action", url+"people/"+$("#formSearch #search").val());
});
