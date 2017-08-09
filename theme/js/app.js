/**
 * Created by ZERG on 09.08.2017.
 */
var App = function() {

    this.alert = function(text) {
        var wnd = new ZWindow({
            title: "<span class='fa fa-warning'>&nbsp;</span> Attention",
            text: text,
            buttons: [
                {
                    text: "Ok",
                    click: function() {
                        wnd.hide();
                    }
                }
            ]
        });
        wnd.show();
    }

    this.confirm = function(text, callback) {
        var wnd = new ZWindow({
            title: "<span class='fa fa-question-circle'>&nbsp;</span> Question",
            text: text,
            buttons: [
                {
                    text: "No",
                    click: function() {
                        if(typeof(callback) != 'undefined') callback(false);
                        wnd.hide();
                    }
                },
                {
                    text: "Yes",
                    click: function() {
                        wnd.hide();
                        if(typeof(callback) != 'undefined') callback(true);
                    }
                }
            ]
        });
        wnd.show();
    }

    this.invite = function() {
        var scope = this;
        var wnd = new ZWindow({
            title: "<span class='fa fa-question-circle'>&nbsp;</span> Invite",
            text: "<label for='invite'>Enter email address for user invite</label><br><input type='email' id='invite' />",
            buttons: [
                {
                    text: "Cancel",
                    click: function() {
                        wnd.hide();
                    }
                },
                {
                    text: "Invite",
                    click: function() {
                        wnd.hide();
                        var email = $('#invite').val();
                        if(email == "") {
                            scope.alert("You must enter email address");
                            return false;
                        }
                        $.ajax({
                            url: "/auth/invite",
                            type: "post",
                            dataType: "json",
                            data: {
                              "email": email
                            },
                            success: function() {
                                scope.alert("The invite sent successfully");
                            }
                        });
                    }
                }
            ]
        });
        wnd.show();
    }

    this.init = function() {
        this.initMask();
        this.initCalendar();
    }

    this.initMask = function() {
        $('.zmask').height($(window).height());
    }

    this.initCalendar = function() {
        $('#calendar').fullCalendar({
            theme: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultDate: moment().format('YYYY-MM-DD'),
            navLinks: true,
            editable: true,
            eventLimit: true,
            events: []
        });
    }
}

var app = new App();

$(function() {
    app.init();
});