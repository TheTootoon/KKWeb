var $j = jQuery.noConflict();		
function equalHeight(one,two) {
	var tallest = 0;
	if (one.height() > two.height())
		two.height( one.height() );
	else
		one.height( two.height() );
}	
$j(document).ready(function(){
	$j(".panel-button").click(function(){
		$j("#panel").slideToggle("slow");
		$j(this).toggleClass("active"); return false;
	});
	
	equalHeight($j(".sidebar"), $j("#main-content"));
});

stepcarousel.setup({
galleryid: 'featured',
beltclass: 'content-belt',
panelclass: 'entry',
panelbehavior: {speed:300, wraparound:true, persist:true},
autostep: {enable:true, moveby:1, pause:3000},
defaultbuttons: {enable: false},
contenttype: ['inline']
});
stepcarousel.setup({
galleryid: 'products',
beltclass: 'products-belt',
panelclass: 'products-panel',
panelbehavior: {speed:300, wraparound:true, persist:true},
defaultbuttons: {enable: false},
contenttype: ['inline']
});

/*

WebFontConfig = {
	google: { families: [ 'Arimo' ] }
};
(function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);
})();
*/