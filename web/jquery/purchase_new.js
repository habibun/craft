//line delete function
$(document).ready(function(){
    $('.line-delete').live('click', function(){
        if(!confirmDelete())
            return false;

        var parentTr = $(this).closest('tr');
        var id = $(parentTr).attr('class');
        $(parentTr).remove();
        delete addedLines[id];
    });
});

//date picker enable function
$(function() {
   $('.default-date-picker').datepicker({ dateFormat: 'dd-mm-yy' });
});

//delete confirm message
function confirmDelete()
	{
		return confirm('Are you sure you want to delete!!!');
	}

