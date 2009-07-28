/*
 * Ext JS Library 3.0.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.grid.GroupingView=Ext.extend(Ext.grid.GridView,{groupByText:"Group By This Field",showGroupsText:"Show in Groups",hideGroupedColumn:false,showGroupName:true,startCollapsed:false,enableGrouping:true,enableGroupingMenu:true,enableNoGroups:true,emptyGroupText:"(None)",ignoreAdd:false,groupTextTpl:"{text}",gidSeed:1000,initTemplates:function(){Ext.grid.GroupingView.superclass.initTemplates.call(this);this.state={};var a=this.grid.getSelectionModel();a.on(a.selectRow?"beforerowselect":"beforecellselect",this.onBeforeRowSelect,this);if(!this.startGroup){this.startGroup=new Ext.XTemplate('<div id="{groupId}" class="x-grid-group {cls}">','<div id="{groupId}-hd" class="x-grid-group-hd" style="{style}"><div class="x-grid-group-title">',this.groupTextTpl,"</div></div>",'<div id="{groupId}-bd" class="x-grid-group-body">')}this.startGroup.compile();this.endGroup="</div></div>"},findGroup:function(a){return Ext.fly(a).up(".x-grid-group",this.mainBody.dom)},getGroups:function(){return this.hasRows()?this.mainBody.dom.childNodes:[]},onAdd:function(){if(this.enableGrouping&&!this.ignoreAdd){var a=this.getScrollState();this.refresh();this.restoreScroll(a)}else{if(!this.enableGrouping){Ext.grid.GroupingView.superclass.onAdd.apply(this,arguments)}}},onRemove:function(e,a,b,d){Ext.grid.GroupingView.superclass.onRemove.apply(this,arguments);var c=document.getElementById(a._groupId);if(c&&c.childNodes[1].childNodes.length<1){Ext.removeNode(c)}this.applyEmptyText()},refreshRow:function(a){if(this.ds.getCount()==1){this.refresh()}else{this.isUpdating=true;Ext.grid.GroupingView.superclass.refreshRow.apply(this,arguments);this.isUpdating=false}},beforeMenuShow:function(){var c,a=this.hmenu.items,b=this.cm.config[this.hdCtxIndex].groupable===false;if((c=a.get("groupBy"))){c.setDisabled(b)}if((c=a.get("showGroups"))){c.setDisabled(b);c.setChecked(!!this.getGroupField(),true)}},renderUI:function(){Ext.grid.GroupingView.superclass.renderUI.call(this);this.mainBody.on("mousedown",this.interceptMouse,this);if(this.enableGroupingMenu&&this.hmenu){this.hmenu.add("-",{itemId:"groupBy",text:this.groupByText,handler:this.onGroupByClick,scope:this,iconCls:"x-group-by-icon"});if(this.enableNoGroups){this.hmenu.add({itemId:"showGroups",text:this.showGroupsText,checked:true,checkHandler:this.onShowGroupsClick,scope:this})}this.hmenu.on("beforeshow",this.beforeMenuShow,this)}},onGroupByClick:function(){this.grid.store.groupBy(this.cm.getDataIndex(this.hdCtxIndex));this.beforeMenuShow()},onShowGroupsClick:function(a,b){if(b){this.onGroupByClick()}else{this.grid.store.clearGrouping()}},toggleGroup:function(c,b){this.grid.stopEditing(true);c=Ext.getDom(c);var a=Ext.fly(c);b=b!==undefined?b:a.hasClass("x-grid-group-collapsed");this.state[a.dom.id]=b;a[b?"removeClass":"addClass"]("x-grid-group-collapsed")},toggleAllGroups:function(c){var b=this.getGroups();for(var d=0,a=b.length;d<a;d++){this.toggleGroup(b[d],c)}},expandAllGroups:function(){this.toggleAllGroups(true)},collapseAllGroups:function(){this.toggleAllGroups(false)},interceptMouse:function(b){var a=b.getTarget(".x-grid-group-hd",this.mainBody);if(a){b.stopEvent();this.toggleGroup(a.parentNode)}},getGroup:function(a,d,f,h,b,e){var c=f?f(a,{},d,h,b,e):String(a);if(c===""){c=this.cm.config[b].emptyGroupText||this.emptyGroupText}return c},getGroupField:function(){return this.grid.store.getGroupState()},afterRender:function(){Ext.grid.GroupingView.superclass.afterRender.call(this);if(this.grid.deferRowRender){this.updateGroupWidths()}},renderRows:function(){var a=this.getGroupField();var d=!!a;if(this.hideGroupedColumn){var b=this.cm.findColumnIndex(a);if(!d&&this.lastGroupField!==undefined){this.mainBody.update("");this.cm.setHidden(this.cm.findColumnIndex(this.lastGroupField),false);delete this.lastGroupField}else{if(d&&this.lastGroupField===undefined){this.lastGroupField=a;this.cm.setHidden(b,true)}else{if(d&&this.lastGroupField!==undefined&&a!==this.lastGroupField){this.mainBody.update("");var c=this.cm.findColumnIndex(this.lastGroupField);this.cm.setHidden(c,false);this.lastGroupField=a;this.cm.setHidden(b,true)}}}}return Ext.grid.GroupingView.superclass.renderRows.apply(this,arguments)},doRender:function(d,h,s,a,q,u){if(h.length<1){return""}var B=this.getGroupField(),p=this.cm.findColumnIndex(B),y;this.enableGrouping=!!B;if(!this.enableGrouping||this.isUpdating){return Ext.grid.GroupingView.superclass.doRender.apply(this,arguments)}var j="width:"+this.getTotalWidth()+";";var t=this.grid.getGridEl().id;var f=this.cm.config[p];var b=f.groupRenderer||f.renderer;var v=this.showGroupName?(f.groupName||f.header)+": ":"";var A=[],m,w,x,o;for(w=0,x=h.length;w<x;w++){var l=a+w,n=h[w],e=n.data[B];y=this.getGroup(e,n,b,l,p,s);if(!m||m.group!=y){o=t+"-gp-"+B+"-"+Ext.util.Format.htmlEncode(y);var c=typeof this.state[o]!=="undefined"?!this.state[o]:this.startCollapsed;var k=c?"x-grid-group-collapsed":"";m={group:y,gvalue:e,text:v+y,groupId:o,startRow:l,rs:[n],cls:k,style:j};A.push(m)}else{m.rs.push(n)}n._groupId=o}var z=[];for(w=0,x=A.length;w<x;w++){y=A[w];this.doGroupStart(z,y,d,s,q);z[z.length]=Ext.grid.GroupingView.superclass.doRender.call(this,d,y.rs,s,y.startRow,q,u);this.doGroupEnd(z,y,d,s,q)}return z.join("")},getGroupId:function(f){var d=this.grid.getGridEl().id;var c=this.getGroupField();var e=this.cm.findColumnIndex(c);var b=this.cm.config[e];var g=b.groupRenderer||b.renderer;var a=this.getGroup(f,{data:{}},g,0,e,this.ds);return d+"-gp-"+c+"-"+Ext.util.Format.htmlEncode(f)},doGroupStart:function(a,d,b,e,c){a[a.length]=this.startGroup.apply(d)},doGroupEnd:function(a,d,b,e,c){a[a.length]=this.endGroup},getRows:function(){if(!this.enableGrouping){return Ext.grid.GroupingView.superclass.getRows.call(this)}var h=[];var f,c=this.getGroups();for(var e=0,a=c.length;e<a;e++){f=c[e].childNodes[1].childNodes;for(var d=0,b=f.length;d<b;d++){h[h.length]=f[d]}}return h},updateGroupWidths:function(){if(!this.enableGrouping||!this.hasRows()){return}var c=Math.max(this.cm.getTotalWidth(),this.el.dom.offsetWidth-this.scrollOffset)+"px";var b=this.getGroups();for(var d=0,a=b.length;d<a;d++){b[d].firstChild.style.width=c}},onColumnWidthUpdated:function(c,a,b){Ext.grid.GroupingView.superclass.onColumnWidthUpdated.call(this,c,a,b);this.updateGroupWidths()},onAllColumnWidthsUpdated:function(a,b){Ext.grid.GroupingView.superclass.onAllColumnWidthsUpdated.call(this,a,b);this.updateGroupWidths()},onColumnHiddenUpdated:function(b,c,a){Ext.grid.GroupingView.superclass.onColumnHiddenUpdated.call(this,b,c,a);this.updateGroupWidths()},onLayout:function(){this.updateGroupWidths()},onBeforeRowSelect:function(d,c){if(!this.enableGrouping){return}var b=this.getRow(c);if(b&&!b.offsetParent){var a=this.findGroup(b);this.toggleGroup(a,true)}}});Ext.grid.GroupingView.GROUP_ID=1000;