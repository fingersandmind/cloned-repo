 $(function(){



             $('#enable').click(function() {

                $("#upload-submit").editable('toggleDisabled');

                 $('#settings .settings').editable('toggleDisabled');

                  $('#enable').text(function(i, text){

                     return text === "Enable edit mode" ? "Disable edit mode" : "Enable edit mode";

                });

            });



        $.fn.editable.defaults.mode = 'popup';

        $.fn.editable.defaults.params = function (params) {

            params._token = $("meta[name=csrf-token]").attr("content");

            params.pk = 1;

           
            return params;

        };



        $('.settings').editable({

            validate: function(value) {

                if($.trim(value) == '') 

                    return 'Value is required.';

        },        

        type: 'text',

        url:'/admin/updateappsettings', 

        placement: 'top', 

        send:'always',

        disabled:true,

        ajaxOptions: {

        dataType: 'json'

        },

        success: function(response, newValue) {

            $(this).html(newValue);

            }        

     });

     });