
(function($) {
Drupal.behaviors.search_form = {
  attach: function (context, settings) {
		
	$("#edit-keys").attr("value", "RECHERCHER");
	$('#edit-keys').click(function() {
      if (this.value == 'RECHERCHER') {
        this.value = '';
      }		
	}) 
	$('#edit-keys').blur(function() {
      if (this.value == '') {
        this.value = 'RECHERCHER';
      }		
	})
  }  
}
  
})(jQuery);