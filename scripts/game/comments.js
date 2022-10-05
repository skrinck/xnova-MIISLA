$(document).ready(function(){
  var form = $('form');
  var submit = $('#submit');

  form.on('submit', function(e) {
    // prevent default action
    e.preventDefault();
    // send ajax request
    $.ajax({
      url: 'ajax_comment.php',
      type: 'POST',
      cache: false,
      data: form.serialize(), //form serizlize data
      beforeSend: function(){
        // change submit button value text and disabled it
        submit.val('Enviando...').attr('disabled', 'disabled');
      },
      success: function(data){
        submit.val('Comentario Publicado').removeAttr('disabled');
        $('.comment-block').append(data);

        // reset form and button
        form.trigger('reset');
      },
      error: function(e){
        console.log(e);
      }
    });
  });
  
  
  // like and unlike click
$(".like").click(function(){
  var id = this.id;   // Getting Button id
  var split_id = id.split("_");

  var text = split_id[0];
  var postid = split_id[1];  // postid

  // Finding click type
  var type = 0;
  if(text == "like"){
    type = 1;
  }else{
    type = 0;
  }

// AJAX Request
$.ajax({
  url: 'likeunlike.php',
  type: 'post',
  data: {postid:postid,type:type},
  dataType: 'json',
  success: function(data){
    var likes = data.likes;
    var typeO = data.type;

    $("#likes_"+postid).text(likes);        // setting likes
    //$("#unlikes_"+postid).text(unlikes);    // setting unlikes

    if(typeO == 1){
      $("#immagine_"+postid).css("opacity","1");
     // $("#unlike_"+postid).css("color","lightseagreen");
    }

    if(typeO === 0){
      $("#immagine_"+postid).css("opacity","0.3");
      //$("#like_"+postid).css("color","lightseagreen");
    }
 },
 error: function(data){
   alert("error : " + JSON.stringify(data));
 }
});

});
  

$('.delete').click(function(e){

  var em = $(this);
  var id=em.data('id');
  

  $.ajax({
  url: 'deleteMessage.php',
  type: 'post',
  data: {id:id},
  dataType: 'json',
  success: function(data){
    // comm_{$COMMENT.commendId}
    if(data.status == 'success')
      {
        $('#comm_'+id).fadeOut('slow',function(){
          $(this).remove();
        });
        alert(data.msg)
      }
      else
      {
        alert(data.msg) 
      }
 },
 error: function(data){
   alert("error : " + JSON.stringify(data));
 }
});
})

});