var link = $("[href='"+window.location.href+"']");
if(link.length>0){
	link.parent().addClass("active");
} else {
	$(".linkMenu:nth-child(1)").addClass("active");
}