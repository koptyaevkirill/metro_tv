//actions model with ajax
function actionModel(obj) {
    loadState('on');
    $('#actions-modal').find('#actions-modal-content').load(obj.data('url'), function(response) {
        $('#actions-modal').find('.modal-header h3').html(obj.attr('title'));
        $('#actions-modal').modal('show');
        loadState('off');
    });
}

function doubleClick(obj) {
    actionModel(obj);
}

function actionMultiple(action, selector_grid, selector_buttons) {
    var keys = $(selector_grid).yiiGridView('getSelectedRows');
    var obj = $(selector_buttons).find('button.button-'+action);
    var actions = {
        add: function () {
            $.post(obj.data('url'), {keys: keys});
        },
        update: function () {
            var data = $('#actions-modal form').serializeArray();
            data.push({'name': 'keys', 'value': keys});
            $.post(obj.data('url'), data);
        },
        delete: function () {
            $.post(obj.data('url'), {keys: keys});
        }
    };
    if (actions[action]) {
        return actions[action].apply();
    }
}
function loadState(status){
    if(status == 'on'){
        jQuery('.overlay-loader').css('opacity','1').css('visibility','visible');
    } else if(status == 'off') {
        jQuery('.overlay-loader').css('opacity','0').css('visibility','hidden');
    }
}

jQuery(document).ready(function($) {
    $('.update-model').on('click',function() {
        actionModel($(this));
    });
    $('.create-model').on('click',function() {
        actionModel($(this));
    });
    $('.view-model').on('click',function() {
        actionModel($(this));
    });
    $("#actions-modal").on('hide.bs.modal', function(){
        $(this).find('#actions-modal-content').children().remove();
    });
});
