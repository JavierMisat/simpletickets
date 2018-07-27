function fillSpaces(string){
	string = string.replace(" ", "%20");
	return string;
}

function getDataForDepandantField(parentf, childf, type) {
    if (type == 1) {
        var val = jQuery("select#" + parentf).val();
    } else if (type == 2) {
        var val = jQuery("input[name=" + parentf + "]:checked").val();
    }
    jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'fieldordering', task: 'DataForDepandantField', fvalue: val, child: childf}, function (data) {
        if (data) {
            console.log(data);
            var d = jQuery.parseJSON(data);
            jQuery("select#" + childf).replaceWith(d);
        }
    });
}

function deleteCutomUploadedFile (field1) {
    jQuery("input#"+field1).val(1);
    jQuery("span."+field1).hide();
    
}