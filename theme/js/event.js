/**
 * Created by ZERG on 10.08.2017.
 */
var Event = function() {

    this.screen = {
        width: $(window).width(),
        height: $(window).height()
    }

    this.position = {
        left: 0,
        top: 0
    }

    this.init = function() {
        var scope = this;
        this.initDateTimePicker();
        this.initColorPicker();
        this.setCenterPosition();
        this.initScreenResize();
        $('#event_cancel').click(function() {
            scope.hide();
        });

        $('#event_close').click(function() {
            scope.hide();
        });

        $('#event_save').click(function() {
            var data = scope.getData();

            if(data.su == 1) {
                scope.saveEvent(data, function () {
                    scope.hide();
                });
                return;
            }

            if(data.owner_id == data.user_id) scope.saveEvent(data, function() {
                scope.hide();
            });

        });

        $("#event_delete").click(function() {
            var id = $("#event_id").val();
            scope.hide();
            app.confirm("Do you want to delete this event ?", function(answer) {
                if(answer === true) {
                    $.ajax({
                        url: "/api/deleteEvent",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: id
                        },
                        success: function() {
                            app.setCurrentMonthEvents();
                        }
                    });
                } else {
                    app.setCurrentMonthEvents();
                }
            })
        });
    }

    this.initDateTimePicker = function() {
        jQuery.datetimepicker.setLocale('en');
        $('.datetimepicker').datetimepicker({
            format:'Y-m-d H:i'
        });
    }

    this.initColorPicker = function() {
        var options = {
            color: "#ECC",
            showInput: true,
            className: "full-spectrum",
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            maxSelectionSize: 10,
            preferredFormat: "hex",
            localStorageKey: "spectrum.demo",
            palette: [
                ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
                    "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
                ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                    "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
                ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                    "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                    "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                    "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                    "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                    "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                    "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                    "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                    "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                    "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
            ]
        };

        $("#event_color").spectrum(options);
        $("#event_color_text").spectrum(options);
    }

    this.addEvent = function() {
        $("#event_owner_id").val($("#user_id").val());
        this.clearData();
        this.show();
    }

    this.openEvent = function(id) {
        var scope = this;
        $.ajax({
            url: '/api/getEvent',
            type: 'post',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(res) {
                if(res.event) {
                    scope.setData(res.event);
                    scope.show();
                }
            }
        });
    }

    this.saveEvent = function(data, success) {
        var data = this.getData();
        $.ajax({
            url: "/api/saveEvent",
            type: "post",
            dataType: "json",
            data: { form_data: data },
            success: function() {
                success();
            }
        });
    }

    this.moveEvent = function(event) {
        var scope = this;
        $.ajax({
            url: "/api/moveEvent",
            type: "post",
            dataType: "json",
            data: {
                id: event.id,
                start: event.start != null ? event.start.format("YYYY-MM-DD HH:mm") : "",
                end: event.end != null ? event.end.format("YYYY-MM-DD HH:mm") : "",
            },
            success: function() {
                app.setCurrentMonthEvents();
            }
        });
    }

    this.initScreenResize = function() {
        var scope = this;
        $(window).resize(function() {
            scope.screen = {
                width: $(window).width(),
                height: $(window).height()
            };
            scope.setCenterPosition();
        });
    }

    this.setCenterPosition = function() {
        this.position.left = (this.screen.width / 2) - ($('#event_wnd').width() / 2);
        this.position.top = this.screen.height / 2 - ($('#event_wnd').height() / 2);
        $('#event_wnd').css('left', this.position.left);
        $('#event_wnd').css('top', this.position.top);
    }

    this.show = function() {
        $('.zmask').show();
        $('#event_wnd').show();
    }

    this.hide = function() {
        $('.zmask').hide();
        app.setCurrentMonthEvents();
        $('#event_wnd').hide();
    }

    this.setData = function(data) {
        var readonly = true;

        $("#event_id").val(data.id);
        $("#event_owner_id").val(data.owner_id);
        if(data.display_name != "") {
            $("#event_owner").val(data.display_name);
        }

        if($("#user_su").val() == "1" || $("#user_id").val() == $("#event_owner_id").val()) {
            $(".event-wrapper").find(".buttons-wrapper.writable").show();
            $(".event-wrapper").find(".buttons-wrapper.readonly").hide();
            $(".event_colors").show();
            readonly = false;
        } else {
            $(".event_colors").hide();
            $(".event-wrapper").find(".buttons-wrapper.writable").hide();
            $(".event-wrapper").find(".buttons-wrapper.readonly").show();
        }

        $("#event_title").val(data.title).attr("disabled", readonly);
        $("#event_start").val(data.start).attr("disabled", readonly);
        $("#event_end").val(data.end).attr("disabled", readonly);
        $("#event_status").val(data.status).attr("disabled", readonly);

        $("#event_color").val(data.color).attr("disabled", readonly);
        $('#event_color').spectrum('set', data.color)

        $("#event_color_text").val(data.color_text).attr("disabled", readonly);
        $('#event_color_text').spectrum('set', data.color_text)

        $("#event_description").val(data.description).attr("disabled", readonly);


    }

    this.getData = function() {
        return {
            id: $("#event_id").val(),
            user_id: $("#user_id").val(),
            su: $("#user_su").val(),
            display_name: $("#user_display_name").val(),
            owner_id: $("#event_owner_id").val(),
            title: $("#event_title").val(),
            start: $("#event_start").val(),
            end: $("#event_end").val(),
            status: $("#event_status").val(),
            color: $("#event_color").val(),
            color_text: $("#event_color_text").val(),
            description: $("#event_description").val()
        }
    }

    this.clearData = function() {
        var data = {
            id: 0,
            owner_id: $("#event_owner_id").val(),
            display_name: $("#user_display_name").val(),
            title: "",
            start: app.calendar.fullCalendar("getDate").format("YYYY-MM-DD HH:mm"),
            end: "",
            status: "new",
            color: "#0c343d",
            color_text: "#fff",
            description: ""
        }
        this.setData(data);
    }

}

var appEvent = new Event();

$(function() {
    appEvent.init();
});