
$(document).ready(function(){
    
    $('#main_champ_table').DataTable({
        "order": [[ 6, "desc" ]],
        "ordering": false,
        "lengthMenu": [[25, 50, -1], [ 25, 50, "All"]]
          
    });
    
    $("#main_champ_table_filter input").attr("placeholder", "champions, dates, ect.");
    
//    $('div.dataTables_filter input').addClass('form-control');
//    $('div.dataTables_length select').addClass('form-control');
//    
//    $( "#main_champ_table_filter label" ).wrap( "<div class='pull-right'></div>" );
//    $('#main_champ_table_length').removeAttr("class").addClass("col-md-4 dataTables_length");
//    
//    $('#main_champ_table_filter').removeAttr("class").addClass("col-md-8");
////    $('#main_champ_table_filter').children('label').addClass("pull-right");
    
    
     
    
 $('[data-toggle="tooltip"]').tooltip();
   $('[data-toggle="popover"]').popover();
    
});