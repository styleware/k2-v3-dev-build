'use strict';
define(['marionette', 'text!layouts/subheader.html', 'dispatcher'], function(Marionette, template, K2Dispatcher) {

	var K2ViewSubheader = Marionette.ItemView.extend({

		template : _.template(template),

		events : {
			'change .appFilters select' : 'filter',
			'click .appActionToggleState' : 'toggleState',
			'click #appActionRemove' : 'remove',
			'click .appActionCloseToolbar' : 'closeToolbar'
		},

		modelEvents : {
			'change:toolbar' : 'render',
			'change:title' : 'render'
		},

		initialize : function() {
			K2Dispatcher.on('app:update:subheader', function(response) {
				this.model.set({
					'title' : response.title,
					'filters' : response.filters.header,
					'toolbar' : response.toolbar
				});
			}, this);

			K2Dispatcher.on('app:view:toolbar', function(show) {
				if (show) {
					this.showToolbar();
				} else {
					this.hideToolbar();
				}
			}, this);

			K2Dispatcher.on('app:subheader:resetFilters', function() {

				// Apply select states
				this.$el.find('.appFilters select').each(function() {
					var el = jQuery(this);
					var value = el.find('option:first').val();
					el.select2('val', value);
					K2Dispatcher.trigger('app:controller:setCollectionState', el.attr('name'), value);
				});

				// Always go to first page after reset
				K2Dispatcher.trigger('app:controller:filter', 'page', 1);

			}, this);
		},

		onRender : function() {
			this.$el.find('.appToolbar').hide();
			require(['widgets/select2/select2', 'css!widgets/select2/select2.css'], _.bind(function() {
				this.$el.find('.appFilters select').select2();
			}, this));
		},

		filter : function(event) {
			event.preventDefault();
			var el = jQuery(event.currentTarget);
			var state = el.attr('name');
			var value = el.val();
			K2Dispatcher.trigger('app:controller:filter', state, value);
		},

		remove : function(event) {
			event.preventDefault();
			var rows = jQuery('input.appRowToggler:checked').serializeArray();
			K2Dispatcher.trigger('app:controller:batchDelete', rows);
		},

		toggleState : function(event) {
			event.preventDefault();
			var rows = jQuery('input.appRowToggler:checked').serializeArray();
			var el = jQuery(event.currentTarget);
			var state = el.data('state');
			K2Dispatcher.trigger('app:controller:batchToggleState', rows, state);
		},

		showToolbar : function() {
			this.$el.find('.appToolbar').show();
		},

		hideToolbar : function() {
			this.$el.find('.appToolbar').hide();
		},

		closeToolbar : function(event) {
			event.preventDefault();
			K2Dispatcher.trigger('onToolbarClose');
			this.hideToolbar();
		}
	});

	return K2ViewSubheader;
});