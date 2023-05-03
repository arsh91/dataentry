function updateUserActivity(id){
    $.ajax({
        url:"../action.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
      
        }
       });
    }