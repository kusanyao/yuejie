var stringHTML = {
	/**
	 * 首页列表item
	 */
	indexListItemModule: function() {
		var data = "{{each list data}}<div><a class='list-item'><!--图片--><div class='list-img'><img src='{{data.schoolImgUrl}}' data-url='images/loading.gif' /></div><!--文字--><div class='list-mes'><!--标题以及时间--><div class='list-mes-item '><h3 class='list-title'>{{data.schoolTitle}}</h3><div>{{data.schoolTime}}</div></div><!--简介--><div class='list-mes-item'><div>{{data.schoolExplain}}</div></div><!--价格以及标签--><div class='list-mes-item'><div><span class='list-price'>￥{{data.schoolPrice}}</span> {{each data.schoolBadgeList schoolBadge}}<span class='badge badge-radius'>{{schoolBadge}}</span> {{/each}}</div></div></div></a><div class='indexListLine'></div></div>{{/each}}";
		return data;
	},
	/**
	 * 底部item
	 */
	footerItemModule: function() {
		var data = "{{each footerList item}}{{if item.footerIsCheck}}<a class='tabbar-item tabbar-active' onclick={{item.footerOnClick}}>{{else}}<a class='tabbar-item' onclick={{item.footerOnClick}}>{{/if}}<span class='tabbar-icon'>{{if item.footerType == 1}}<i class={{item.footerIsCheck ? 'icon-home':'icon-home-outline'}}></i>{{else if item.footerType == 2}}<i class={{item.footerIsCheck ? 'icon-shopcart':'icon-shopcart-outline'}}></i>{{else if item.footerType == 3}}<i class={{item.footerIsCheck ? 'icon-ucenter':'icon-ucenter-outline'}}></i>{{/if}}</span><span class='tabbar-txt'>{{item.footerName}}</span></a>{{/each}}";
		return data;
	},
	/**
	 *我的历史记录
	 */
	myHistoryItemModule: function() {
		var data = "{{each historyList item}}<a class='cell-item cell-itemnew'><div class='cell-left'>{{item.name}}</div><div class='cell-right cell-arrow'></div></a>{{/each}}";
		return data;
	},
	/**
	 * 校院库省份
	 */
	schoolProvinceItemModule: function() {
		var data = "<a class='scrolltab-item'><div class='scrolltab-title'>{{province}}</div></a>";
		return data;
	},
	/**
	 * 学校列表
	 */
	schoolListItemModule: function() {
		var data = "<div class='scrolltab-content-item zeroMarginPadding'><strong class='scrolltab-content-title' style='display: none;'>{{province}}</strong><div class='m-cell zeroMarginPadding'>{{each schoolList data}}<a class='cell-item schoolListItem cell-itemnew' onclick={{data.schoolOnClick}} ><div class='cell-left'><span class='cell-icon'><img src='//static.ydcss.com/ydui/img/logo.png' /></span> {{data.schoolName}}</div></a>{{/each}}</div></div>";
		return data;
	},
	/**
	 * 详情页面顶部的图片
	 */
	detailSchoolIntroduceADListModule: function() {
		var data = "{{each schoolIndexADList ad}}<div class='slider-item'><a><img src={{ad.adImg}} /></a></div>{{/each}}";
		return data;
	},
	/**
	 * 详情页面的学院
	 */
	detailSchoolIntroduceModule: function() {
		var data = "<div class='detailSchoolIntroduceMargin'><a class='list-item'><!--文字--><div class='list-mes'><!--标题以及时间--><div class='list-mes-item '><h3 class='list-title'>{{schoolTitle}}</h3></div><!--简介--><div class='list-mes-item'><div>{{schoolExplain}}</div></div><!--价格以及标签--><div class='list-mes-item'><div><span class='list-price'>￥{{schoolPrice}}</span> {{each schoolBadgeList schoolBadge}}<span class='badge badge-radius badge-diy'>{{schoolBadge}}</span> {{/each}}</div></div></div></a><div class='indexListLine'></div></div>";
		return data;
	},
	/**
	 * 详情页面的专业特点，课程设置，
	 */
	detailSchoolIntroduceMajorCurriculumModule: function() {
		var data = "{{each MajorCurriculumList item}}<div class='deteilSchoolTitleDiv'><div class='deteilSchoolTitle'><span class='span'>{{item.name}}</span></div></div><div><ol class='detailSchoolIntroducesMajor'>{{each item.explainList explain positions}}<li>{{positions + 1 }}、{{explain}}</li>{{/each}}</ol></div>{{/each}}<div>{{if compulsoryList.length > 0}}<span class='badge badge-radius badge-diy' style='padding: 8px;margin-left:20px ;'>必考</span><ol class='detailSchoolIntroducesMajor'>{{each compulsoryList explain positions}}<li>{{positions + 1 }}、{{explain}}</li>{{/each}}</ol><div class='detailSchoolIntroducesCompulsoryExplain'><ol class='detailSchoolIntroducesMajor'><span>说明：</span> {{each compulsoryExplainList compulsoryExplain compulsoryExplainPositions}}<li>{{compulsoryExplainPositions + 1 }}、{{compulsoryExplain}}</li>{{/each}}</ol></div>{{/if}}</div>";
		return data;
	}
}