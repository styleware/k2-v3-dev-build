define(['marionette', 'text!layouts/toolbar.html', 'dispatcher', 'widgets/widget', 'views/batch'], function(Marionette, template, K2Dispatcher, K2Widget, K2ViewBatch) {'use strict';

	var K2ViewToolbar = Marionette.ItemView.extend({

		template : _.template(template),

		events : {
			'click .appActionSetState' : 'setState',
			'click #appActionRemove' : 'remove',
			'click .appActionCloseToolbar' : 'closeToolbar',
			'click #appActionBatch' : 'batch'
		},

		modelEvents : {
			'change:toolbar' : 'render'
		},

		initialize : function() {
			
			// Model
			this.model = new Backbone.Model({
				toolbar : [],
				batchActions : []
			});

			// Listener for updating subheader related data
			K2Dispatcher.on('app:update:subheader', function(response) {
				this.model.set({
					'toolbar' : response.toolbar,
					'batchActions' : response.batch
				});
				this.hideToolbar();
			}, this);

			// Listener for showing/hiding toolbar
			K2Dispatcher.on('app:view:toolbar', function(show) {
				if (show) {
					this.showToolbar();
				} else {
					this.hideToolbar();
				}
			}, this);
		},

		onDomRefresh : function() {
			K2Widget.updateEvents(this.$el);
		},

		onRender : function() {
			
			// Hide toolbar
			this.$el.find('.appToolbar').hide();
		},

		remove : function(event) {
			event.preventDefault();
			var rows = jQuery('input.appRowToggler:checked').serializeArray();
			K2Dispatcher.trigger('app:controller:batchDelete', rows);
		},

		setState : function(event) {
			event.preventDefault();
			var rows = jQuery('input.appRowToggler:checked').serializeArray();
			var el = jQuery(event.currentTarget);
			var value = el.data('value');
			var state = el.data('state');
			K2Dispatcher.trigger('app:controller:batchSetState', rows, value, state);
		},

		showToolbar : function() {
			this.$el.find('#appToolbarCounter').text(jQuery('input.appRowToggler:checked').length);
			this.$el.find('.appToolbar').show();
		},

		hideToolbar : function() {
			this.$el.find('.appToolbar').hide();
		},

		closeToolbar : function(event) {
			event.preventDefault();
			K2Dispatcher.trigger('onToolbarClose');
			this.hideToolbar();
		},

		batch : function() {
			var counter = jQuery('input.appRowToggler:checked').length;
			var actions = this.model.get('batchActions');
			var model = new Backbone.Model;
			model.set('counter', counter);
			model.set('actions', actions);
			var view = new K2ViewBatch({
				model : model
			});
			K2Dispatcher.trigger('app:region:show', view, 'modal');
		}
	});

	return K2ViewToolbar;
});