var Template = function () {
    var initSelect = function(){
         $('.select_2').select2(); // styling selects
    }
  return {
        //main function to initiate the module
        init: function () {
            initSelect();
        }

    };
}();