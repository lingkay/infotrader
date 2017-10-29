var Template = function () {
    var initSelect = function(){
         $('.select_2').select2(); // styling selects
    }

	var initTypeahead = function(){
       $('.typeahead').each(function(){
        var auto = $(this);
        auto.typeahead({
            ajax: auto.data('path'),
            onSelect : function(item){
                auto.prev('input').val(item.value)
            }
        });
       });       

	}
  return {
        //main function to initiate the module
        init: function () {
            initSelect();
        	initTypeahead();
        }
    };
}();