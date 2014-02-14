
(function (window) {
    var view = {
        refreshAll: function () {
            var iw = $('li').width() - $('input[type=checkbox]').width() - 20;
            $('li input[type=text]').width(iw);
        }
    }
    window.xc = {tasks: {view: view}};
})(window);

$(function () {
    var view = window.xc.tasks.view;

    view.refreshAll();

    var newItemFunc = function () {
        var newItem = $('<li> <input type="checkbox"> <input type="text" value=""> </li>');
        console.log(newItem);
        $('ul').append(newItem);
        view.refreshAll();
        newItem.find('input[type=text]').focus();
    };

    var saveItem = function (id, item) {
        var data = {
            id: id,
            name: item.value
        };
        $.post('?', data, function (ret) {
            console.log(ret);
        }, 'json');
    }

    $('input.task-item').on('keyup', function (e) {
        var id = $(this).data('id');
        if (e.keyCode == 13) {
            if (id) {
                saveItem(id, this);
            } else {
                newItemFunc();
            }
        };
    });

    $('input[type=checkbox]').change(function () {
        var that = $(this);
        var input = that.siblings('input[type=text]');
        if (that.prop('checked')) {
            input.addClass('done');
        } else {
            input.removeClass('done');
        }
    });
});
