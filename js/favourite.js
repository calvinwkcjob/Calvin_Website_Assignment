$(document).ready(function(){
    
    $.getJSON("../drugs/favourite-api.php", function(data){
        if(data!=""){
             $("#content").html("<h2 class='main-title text-center dark-blue-text' style='font-size:56px;'>Favourite List</h2><table width='100%'>");
            $.each(data, function(i, row){
                $("#content").append("<tr><td width='70%'>Center Name: </td><td>" + row.dname + "</td></tr>"
                + "<tr><td></td><td><a href='javascript:void(0)' onclick='favourite.delete(\""+row.dname+"\") '>delete</a></td></tr>"
                ); 
            $("#content").append("</table>"); 
            }) ;
            
        }else{
         $("#content").html("<p style='text-align:center;'>You have no item in favourite list!</a>");
       }
    });
    
    favourite = {
        delete: function(dname){
            var myData = {"dname": dname};
            $.ajax({
            url: "../drugs/favourite-api.php",
            type:"DELETE",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                if(msg=='true'){
                    alert("Removed for Favourite list!");
                    location.reload();
                }else{
                    alert(msg);
                }
            }
        });
         }
    }
    
    
    
});