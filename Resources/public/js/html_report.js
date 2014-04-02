function ReportFiltering(reportId, dataKey, limit, offset) {

    var self = this;
	self.reportId = reportId;
	self.report = jQuery('#'+self.reportId);
	self.dataKey = dataKey;
	self.filterUri = window.location.pathname;
	self.limit = limit;
	self.offset = offset;
	self.sortColumn = null;
	self.sortDirection = 'asc';
	self.sortKey = self.dataKey + '[' + self.reportId + '][sort]';
	self.offsetKey = self.dataKey + '[' + self.reportId + '][offset]';
	self.filterData = {};
	
	self.replaceFilterData = function(filterData, keysToPreserve) {
		
		keysToPreserve = keysToPreserve || [];
		
		jQuery.each(keysToPreserve, function(index, elem) {
			
			if (self.filterData[elem] != undefined) {
				
				filterData[elem] = self.filterData[elem];
			}
		});
		
		self.filterData = filterData;
	};
	
	self.submitFilters = function(event) {
		
		self.doSubmitFilters(event);
	};
	
	self.clearFilters = function(event) {
		
		self.doClearFilters(event);
	};
	
	self.doClearFilters = function(event) {

        var $this = jQuery(event.target);
        var $form = $this.closest('form');
		jQuery(':input', $form)
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected')
		;
		self.report.find('.submit-filters').click();
	};
	
	self.doSubmitFilters = function(event) {

        var $this = jQuery(event.target);
        var $form = $this.closest('form');

        var newFilterData = {};
		
		jQuery.each($form.serializeArray(), function(index, elem) {
			
			newFilterData[self.dataKey + '[' + self.reportId + ']' + elem.name.substring(4)] = elem.value;
		});
		
		self.replaceFilterData(newFilterData, [self.sortKey]);
		
		self.sendFilterData();
	};
	
	self.sendFilterData = function() {

        var callback = function (data) {

            self.report.find('.report-content').html(jQuery(data).filter('#' + self.reportId).children('.report-content').html());
        };

        var outerCallback;

        if (self.filterUri != window.location.pathname) {

            outerCallback = function () {

                jQuery.get(window.location.pathname, [], callback);
            };
        } else {

            outerCallback = callback;
        }
		
		jQuery.post(self.filterUri, jQuery.param(self.filterData), outerCallback);
	};
	
	self.setSort = function(sort) {
		
		self.sortDirection = self.sortDirection == 'asc' ? 'desc' : 'asc';
		self.sortColumn = sort;
		
		sort = {};
		sort[self.sortColumn] = self.sortDirection;
		
		self.filterData[self.sortKey] = sort;
	};
	
	self.submitSort = function(event) {
		
		self.doSubmitSort(event);
	};
	
	self.doSubmitSort = function(event) {

        var $this = jQuery(event.target).closest('.sort-column');
		self.setSort($this.data('sort-name'));
		self.sendFilterData();
	};
	
	self.submitPage = function(event) {
		
		self.doSubmitPage(event);
	};
	
	self.doSubmitPage = function(event) {

        var $this = jQuery(event.target).closest('.report-pagination-page');
		
		if ($this.hasClass('disabled') || $this.hasClass('active')) {
			
			return;
		}
		
		self.setPage($this.data('page'));
		self.sendFilterData();
	};
	
	self.setPage = function(page) {
		
		self.filterData[self.offsetKey] = self.limit * (page - 1);
	};
	
	self.report.on('click', '.submit-filters', this.submitFilters);
	self.report.on('click', '.clear-filters', this.clearFilters);
	self.report.on('click', '.sort-column', this.submitSort);
	self.report.on('click', '.report-pagination-page', this.submitPage);
}