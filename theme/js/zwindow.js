var ZWindow = function(config) {

	this.config = config;

	this.screen = {
		width: $(window).width(),
		height: $(window).height()
	}

	this.size = {
		width: typeof(config.width) != 'undefined' ? config.width : 500,
		height: typeof(config.height) != 'undefined' ? config.height : 250
	}

	this.position = {
		left: 0,
		top: 0
	}

	this.init = function() {
		$('#zwindow .zbuttons').html("");
		$('#zwindow .zclose-btn').remove();
		this.setData();
		this.initHandlers();
		this.setCenterPosition();
	}

	this.setData = function() {
		var scope = this;
		$('#zwindow .ztitle').html(config.title);
		$('#zwindow .zbody').html(config.text + "<div class='zbuttons'></div>");
		$.each(config.buttons, function(index, el) {
			scope.setButton(el);
		});
		this.setCloseButton();
	}

	this.initHandlers = function() {
    var scope = this;
		this.initScreenResize();
    $('.zmask').click(function() {
      scope.hide();
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
		this.position.left = (this.screen.width / 2) - ($('#zwindow').width() / 2);
		this.position.top = this.screen.height / 2 - ($('#zwindow').height() / 2);
		$('#zwindow').css('left', this.position.left);
		$('#zwindow').css('top', this.position.top);
	}

	this.show = function() {
    $('.zmask').show();
		$('#zwindow').show();
	}

	this.hide = function() {
    $('.zmask').hide();
		$('#zwindow').hide();
	}

	this.setCloseButton = function() {
		var scope = this;
		var btn = $('<div class="zclose-btn"><span class="fa fa-close">&nbsp</span></div>').appendTo('#zwindow .ztitle');
		$(btn).click(function() {
			scope.hide();
			if(typeof(scope.config.onclose) != 'undefined') scope.config.onclose();
		});
	}

	this.setButton = function(config) {
		var button = $("<button>" + config.text + "</button>").appendTo('#zwindow .zbuttons');
		if(config.click) {
			$(button).click(function() {
				config.click();
			});	
		}
	}

	this.init();

}