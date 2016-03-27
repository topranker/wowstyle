
function getProductId (id){
	if (confirm('Are you sure you want to delete this product from the database?')) {
    document.del_edit_form.hidden.value = id;
	document.forms["del_edit_form"].submit();
} else {
    // Do nothing!
}
	
}

function post_hidden_value(id ){
	
	document.del_edit_form.edit.value = id;
	
	document.forms['del_edit_form'].submit();

}

function confirm_it(value,message){
	if(confirm(message)){
	document.location.replace(value);
}
}
function redirect_to(url)
{
  document.location.replace(url);
}

function SelectName(path) {
	var popup;
        popup = window.open(path, "Popup", "width=300,height=100");
        popup.focus();
	
        return false
    }
