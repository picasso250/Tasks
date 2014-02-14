
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

    var newItemFunc = function (item) {
        var data = {
            action: 'add',
            name: item.value
        };
        $.post('?', data, function (ret) {
            if (ret.code != 0) {
                alert('error');
            } else {
                $(item).data('id', ret.data.id);
                nextLine(item);
            }
        }, 'json');
    };

    var saveItem = function (id, item) {
        var data = {
            action: 'edit',
            id: id,
            name: item.value
        };
        $.post('?', data, function (ret) {
            if (ret.code != 0) {
                alert('error');
            } else {
                nextLine(item);
            }
        }, 'json');
    };

    var nextLine = function (item) {
        var total = $('li').length;
        var curInput = $(item);
        var cur = curInput.parents('li').index();
        var isLast = (total === (cur + 1));
        var isEmpty = (curInput.val() === '');
        if (isLast && !isEmpty) {
            var newItem = $('<li>'+$('#itemTpl').html()+'</li>');
            $('ul').append(newItem);
            view.refreshAll();
            newItem.find('input[type=text]').focus().on('keyup', keyupFunc);
        }

    };

    var keyupFunc = function (e) {
        var id = $(this).data('id');
        if (e.keyCode == 13) {
            if (id) {
                saveItem(id, this);
            } else {
                newItemFunc(this);
            }
        };
    };

    $('input.task-item').on('keyup', keyupFunc);

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
