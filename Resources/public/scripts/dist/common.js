function Ajax()
{
    this.notifier = new Notifier;

    this.call = function (url, parameters, method, success, fail) {
        var $this = this;

        $.ajax({
            url: url,
            data: parameters,
            method: method
        }).done(function(data, status, object) {
            $this.notifier.notice(data.message);
            if (typeof success === 'function') {
                success();
            }
        }).fail(function(object, status, error) {
            $this.notifier.error(error);
            if (typeof fail === 'function') {
                fail();
            }
        });
    };

    this.patch = function (url, parameters, success, fail) {
        this.call(url, parameters, 'PATCH', success, fail);
    };

    this.remove = function (url, parameters, success, fail) {
        this.call(url, parameters, 'DELETE', success, fail);
    };
}

function List(selectorActive, selectorActions)
{
    this.selectorActive = selectorActive;
    this.selectorActions = selectorActions;
    this.ajax = new Ajax();

    this.changeState = function(e, activate) {
        e.preventDefault();
        var link = $(e.currentTarget);
        var line = link.parent().parent();
        var active = line.find(this.selectorActive + ' .glyphicon-ok');
        var inactive = line.find(this.selectorActive + ' .glyphicon-remove');
        var activateLink = line.find(this.selectorActions + ' .glyphicon-ok');
        var deactivateLink = line.find(this.selectorActions + ' .glyphicon-remove');

        this.ajax.patch(link.attr('rel'), null, function() {
            if (!activate) {
                inactive.removeClass('hide');
                deactivateLink.addClass('hide');
                active.addClass('hide');
                activateLink.removeClass('hide');
                return;
            }
            active.removeClass('hide');
            activateLink.addClass('hide');
            inactive.addClass('hide');
            deactivateLink.removeClass('hide');
        }.bind(this));
    };

    this.deleteElement = function(e) {
        e.preventDefault();
        var link = $(e.currentTarget);
        var line = link.parent().parent();
        this.ajax.remove(link.attr('rel'), null, function() {
            line.remove();
        }.bind(this));
    }
}

function Notifier()
{
    this.notifications = $('.flash');
    this.prototype = this.notifications.attr('data-prototype');

    this.addNotification = function (type, text) {
        var html = this.prototype.replace('$$TYPE$$', type).replace('$$MESSAGE$$', text);
        this.notifications.append(html);
    };

    this.error = function (text) {
        this.addNotification('danger', text);
    };

    this.notice = function(text) {
        this.addNotification('info', text);
    };
}
