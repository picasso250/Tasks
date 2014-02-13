var d = function (arg) {
    console.log(arg);
};

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

    $('form').submit(function () {
        var total = $('li').length;
        var curInput = $('input[type=text]:focus');
        var cur = curInput.parents('li').index();
        var isLast = (total === (cur + 1));
        var isEmpty = (curInput.val() === '');
        d(isLast);
        d(isEmpty);
        if (isLast && !isEmpty) {
            var newItem = $('<li> <input type="checkbox"> <input type="text" value=""> </li>');
            $('ul').append(newItem);
            view.refreshAll();
            newItem.find('input[type=text]').focus();
        }
        return false;
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
