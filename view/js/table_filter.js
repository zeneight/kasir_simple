/*!
 * zFilter v0.1
 * Simple table filter
 */

var zFilter = (function($){
	var _input;
	var self = {
		setup: function(input, table, index){
			var els = [];
			table.find('tr').each(function(){
				var el = $(this).find('td').eq(index);
				if(el.length)
					els.push(el);
			});
			input.data('els', els);
			input.val('');
			input.keyup(self.startFilter);
			_input = input;
		},
		startFilter: function(){
			var timeoutID = $(this).data('timeoutID');
			if(timeoutID){
				clearTimeout(timeoutID);
			}
			timeoutID = setTimeout( self.filter, 200 );
			$(this).data('timeoutID', timeoutID);
		},
		filter: function(){
			var timeoutID = _input.data('timeoutID');
			var filterText = _input.val().toLowerCase();
			var els = _input.data('els');

			$.each(els,function(){
				text = $(this).text().toLowerCase();
				if(text.indexOf(filterText) >= 0){
					$(this).parent().show();
				}else{
					$(this).parent().hide();
				}
			});
			clearTimeout(timeoutID);
		}
	};
	return self;
})(jQuery);

(function($) {
	$.fn.zFilter = function(table, index) {
		var elTable = $(table);
		zFilter.setup(this, elTable, index);
	};
})(jQuery);