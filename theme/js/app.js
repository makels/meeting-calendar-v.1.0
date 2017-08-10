/**
 * Created by ZERG on 09.08.2017.
 */
var App = function() {

    this.calendar = null;

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
                            },
                            error: function() {
                                scope.alert("Email already exist");
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
        this.initUsersList();
        this.setCurrentMonthEvents([]);
    }

    this.initMask = function() {
        $('.zmask').height($(window).height());
    }

    this.initUsersList = function() {
        var scope = this;
        $(".ulist_body").find("input").change(function() {
            scope.setCurrentMonthEvents();
        });
    }

    this.initCalendar = function() {
        var scope = this;
        this.calendar = $('#calendar').fullCalendar({
            theme: true,
            customButtons: {
                add_event: {
                    text: 'Add Event',
                    click: function() {
                        appEvent.addEvent();
                    }
                }
            },
            header: {
                left: 'prev,next today add_event',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultDate: moment().format('YYYY-MM-DD'),
            navLinks: true,
            editable: true,
            eventLimit: true,
            events: [],
            eventClick: function(calEvent) {
                appEvent.openEvent(calEvent.id);
            },
            eventDrop: function(event) {
                appEvent.moveEvent(event, function() {
                    scope.setCurrentMonthEvents();
                });
            },
            eventResize: function(event) {
                appEvent.moveEvent(event, function() {
                    scope.setCurrentMonthEvents();
                });
            }
        });
    }

    this.setCurrentMonthEvents = function() {
        var scope = this;
        var owners = this.getOwners();
        var start = moment().add(1, 'months').date(0).format('YYYY-MM-01 00:00');
        var end = moment().add(1, 'months').date(0).format('YYYY-MM-DD 23:59');
        $.ajax({
            url: "/api/getEvents",
            type: "post",
            dataType: "json",
            data: {
                start: start,
                end: end,
                owners: owners
            },
            success: function(res) {
                if(res.events && res.events.length > 0) {
                    scope.calendar.fullCalendar('removeEventSources');
                    scope.calendar.fullCalendar('addEventSource', res.events);
                    scope.calendar.fullCalendar('refetchEvents');
                }
            }
        });
    }

    this.getOwners = function() {
        var owners = [];
        $.each($(".ulist_body").find("input"), function() {
           if($(this).is(":checked") === true) owners.push($(this).attr("user_id"));
        })
        return owners;
    }
}

var app = new App();

$(function() {
    app.init();
});