<?php
  /**
   * Kontrollbase
   *
   * An open source MySQL monitoring and analytics application
   *
   * @package Kontrollbase
   * ID: $Id$
   * @copyright Copyright (c) 2009 Matt Reid, Kontrollbase LLC
   * @license http://kontrollsoft.com/kontrollbase/userguide/general-LICENSE.php
   * @link http://kontrollbase.com
   */

function head(
	      $root,
	      $server_list,
	      $servers,
	      $footer,
	      $data_size,
	      $index_size,
	      $total_size,
	      $data,
	      $alerts,
	      $overviewpage,
	      $slavepage,
	      $graphspage,
	      $server_statistics_id,
	      $server_list_id,
	      $sessionpage) {

  $nroot = substr_replace($root,"",-1);
  print<<<HEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kontrollbase 2.0.1 - MySQL Monitoring</title>

<link rel="stylesheet" type="text/css" href="$nroot/includes/style.css" />
<link rel="stylesheet" type="text/css" href="$nroot/includes/extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="$nroot/includes/extjs/resources/css/xtheme-slate.css" />

<script type="text/javascript" src="$nroot/includes/browser_detect.js"></script>
<script type="text/javascript" src="$nroot/includes/extjs/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="$nroot/includes/extjs/ext-all.js"></script>
<script type="text/javascript" src="$nroot/includes/extjs/miframe.js"></script>

<style type="text/css">
    .settings {
    background-image:url('$nroot/includes/images/folder_wrench.png');
  }
  .nav {
    background-image:url('$nroot/includes/images/folder_go.png');
  }
</style>

<script type="text/javascript">
 Ext.onReady(function() {  
 Ext.QuickTips.init();
HEAD;

 print "    
var alertData = [";
 $r=0;
 $u=count($alerts);
 foreach($alerts as $key => $value) {
   foreach($value as $vKey => $vValue) {
     if($vKey == 'alert_name') { $alert_name=$vValue; }
     if($vKey == 'alerts_current_id') { $alerts_current_id=$vValue; }
     if($vKey == 'alert_desc') { $alert_desc=$vValue; }
     if($vKey == 'alert_links') { $alert_links=$vValue; }
     if($vKey == 'alert_solution') { $alert_solution=$vValue; }
     if($vKey == 'server_list_id') { $server_list_id=$vValue; }
     if($vKey == 'server_hostname') { $server_hostname=$vValue; }
     if($vKey == 'alert_level') { $alert_level=$vValue; }
   }

   if($alert_level == 0) { $alert_level = 'crit';}
   elseif($alert_level == 1) { $alert_level= 'warn';}
   elseif($alert_level == 2) { $alert_level= 'info';}

   // here we need hover pop up thing for the $alerts_current_id column: we need to display $alert_desc, $alert_links, $alert_solution
   print "['$alerts_current_id','$server_hostname','$alert_level','$alert_name']
";
   $r++;
   if($r<$u) { print ",";} else { print "];";}
 }

 print "    
var summaryData = [";

 $queries_per_second_c=0;
 $num_schema_c=0;
 $num_tables_c=0;
 $length_data_c=0;
 $length_index_c=0;
 $total_size_c=0;
 $num_connections_c=0;
 $engine_count_innodb_c=0;
 $engine_count_myisam_c=0;
 $engine_myisam_size_total_c=0;
 $engine_innodb_size_total_c=0;

 $z=0;
 $c=count($data);
 foreach($data as $key => $value) {
   foreach($value as $k => $v) {
     if($k == 'server_list_id') { $server_list_id=$v;}
     if($k == 'server_hostname') { $server_hostname=$v;}
     if($k == 'os_load_15') { $os_load_15=$v;}
     if($k == 'mem_perc') { $mem_perc=$v;}
     if($k == 'queries_per_second') { $queries_per_second=$v; $queries_per_second_c += $queries_per_second;}
     if($k == 'num_schema') { $num_schema=$v; $num_schema_c += $num_schema;}
     if($k == 'num_tables') { $num_tables=$v; $num_tables_c += $num_tables;}
     if($k == 'num_connections') { $num_connections=$v; $num_connections_c += $num_connections;}
     if($k == 'length_data') { $length_data=$v; $length_data_c += $length_data;}
     if($k == 'length_index') { $length_index=$v; $length_index_c += $length_index;}
     if($k == 'total_size') { $total_size=$v; $total_size_c += $total_size;}
     if($k == 'engine_count_innodb') { $engine_count_innodb=round($v,0); $engine_count_innodb_c += $engine_count_innodb;}
     if($k == 'engine_count_myisam') { $engine_count_myisam=round($v,0); $engine_count_myisam_c += $engine_count_myisam;}
     if($k == 'engine_myisam_size_total') { $engine_myisam_size_total=$v; $engine_myisam_size_total_c += $engine_myisam_size_total;}
     if($k == 'engine_innodb_size_total') { $engine_innodb_size_total=$v; $engine_innodb_size_total_c += $engine_innodb_size_total;}
   }
    print "
  ['$server_hostname',
$os_load_15,
$mem_perc,
$queries_per_second,
$num_schema,
$num_tables,
$num_connections,
$total_size,
$engine_count_innodb,
$engine_count_myisam,
$engine_myisam_size_total,
$engine_innodb_size_total],";
 }

print "
['Total Values',
 ,
 ,
 $queries_per_second_c,
 $num_schema_c,
 $num_tables_c,
 $num_connections_c,
 $total_size_c,
 $engine_count_innodb_c,
 $engine_count_myisam_c,
 $engine_myisam_size_total_c,
 $engine_innodb_size_total_c]
];
";

 print<<<HEAD
   var detailEl;
 
 var refreshTab=function(tab){
   tab.getUpdater().refresh();
 };
 
 var contentPanel = {
 id: 'content-panel',
 region: 'center', 
 layout: 'card',
 margins: '2 5 5 0',
 activeItem: 0,
 border: false,
 items: [
	 border
	 ]
 };
 
 var border = {
 id:'border-panel',
 title: '<img src="$nroot/includes/images/kontrollbase_logo-trans32.png" align="center">',
 layout:'border',
 region:'center',
 bodyBorder: false,
 defaults: {
   collapsible: true,
   split: true,
   animFloat: false,
   autoHide: false,
   useSplitTips: true,
   bodyStyle: 'padding:0px'
   },
 
 items: [
   {
     xtype: 'toolbar',
     height: 25,
     region: 'north',
     items: [{
       xtype: 'tbbutton',
       text: 'Logout',
       handler: function() {
         window.location = '$nroot/index.php/login/logout/';}
     },
   { 
     xtype: 'tbseparator' 
   },     
   {
     xtype: 'tbbutton',
     text: 'Goto Environment',
     handler: function() {
       window.location = '$nroot/index.php';}
   },
   {
     xtype: 'tbseparator'
   },
   {
     xtype: 'tbbutton',
     text: 'Forums',
     handler: function() {
       window.location = 'http://kontrollsoft.com/forum';}
   },
   {
     xtype: 'tbseparator'
   },
   {
     xtype: 'tbbutton',
     id: this.id + 'AuditButton',
     cls: 'x-btn-icon audit-button',
     tooltip: 'Contact Support',
     handler: function() {
       window.location = 'http://kontrollsoft.com/support';},
     scope: this,
   }]},
   {
     region:'west',
     id:'west-panel',
     title:'Navigation',
     split:true,
     width: 200,
     minSize: 175,
     maxSize: 400,
     collapsible: true,
     margins:'5 0 0 0',
     layout:'accordion',
     layoutConfig:{
       animate:true
     },
     items: [{
       title: 'Servers List',
       html: "$servers",
       autoScroll: true,
       animScroll: true,
       iconCls:'nav'
     }]
   },
   {
   xtype: 'tabpanel',
   plain: true,
   region: 'center',
   margins: '5 0 0 0',
   activeTab: 0,
   collapsible: false,
   shim:false,
   frame:true,
   animCollapse:false,
   enableTabScroll:true,
   autoScroll:true,
   bodyStyle: 'padding:5px 0px 0px 5px',
   items: [
   {
   title: 'Host Overview',
   deferredRender: true,
   layout : 'fit',
   items: {
     xtype          : 'iframepanel',
     defaultSrc  : '$nroot/includes/pages/$overviewpage'
     },
   shim:false,
   frame:true,
   animCollapse:false,
   enableTabScroll:true,
   autoScroll:true
   },
   {
     title: 'Analytics',
     deferredRender: true,
     layout : 'fit',
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
     autoScroll:true,
     items: [
   {
     xtype: 'tabpanel',
     plain: true,
     region: 'center',
     margins: '0 5 5 5',
     activeTab: 0,
     animScroll: true,
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
     autoScroll:true,     
     items: [
   {
     title: 'export',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_export/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'query analysis',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_query_analysis/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'query cache',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_query_cache/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'connections',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_connections/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'threads',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_threads/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'index usage',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_indexes/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'table locking',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_table_locking/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'table cache',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_table_cache/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'temp tables',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_temp_table/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'sort buffer',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_sort_buffer/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'join buffer',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_join_buffer/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'myisam',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_myisam/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   },
   {
     title: 'innodb',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/analytics/stats_innodb/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
       autoScroll:true
   }
   ]}]},
   {
   title: 'Perf Report',
   deferredRender: true,
   layout : 'fit',
   items: {
     xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/main/report/$server_statistics_id/$server_list_id'
     },
   shim:false,
   frame:true,
   animCollapse:false,
   enableTabScroll:true,
   autoScroll:true
   },
   { 
   title: 'Graphs',
   deferredRender: true,
   layout : 'fit',
   items: {  
     xtype          : 'iframepanel', 
     defaultSrc  : '$nroot/includes/graphs/$graphspage'
     },
   shim:false,
   frame:true,
   animCollapse:false,
   enableTabScroll:true,
   autoScroll:true
   }, 
   {
     title: 'Variables',
     deferredRender: true,
     layout : 'fit',
   items: [
   {
     xtype: 'tabpanel',
     plain: true,
     region: 'center',
     margins: '0 5 5 5',
     activeTab: 0,
     autoScroll: true,
     animScroll: true,
   items: [
   {
     title: 'CNF File',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/main/cnf/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
   autoScroll:true
   },
   {
     title: 'Global Variables',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/main/server_variables/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
   autoScroll:true
   },
   {
     title: 'Global Status',
     deferredRender: true,
     layout : 'fit',
     listeners: {activate: refreshTab},
     items: {
       xtype          : 'iframepanel',
     defaultSrc  : '$nroot/index.php/main/server_status/$server_list_id'
     },
     shim:false,
     frame:true,
     animCollapse:false,
     enableTabScroll:true,
   autoScroll:true
   }]}]},
   {
   title: 'View Alerts',
   xtype: 'grid',
   layout: 'fit',
   store: new Ext.data.SimpleStore({
     fields: [
	      {name: 'id'},
	      {name: 'server'},
	      {name: 'state'},
	      {name: 'name'}
	      ]}),
   columns: [
   {header: "id", width: 60, sortable: true, dataIndex: 'id'},
   {header: "server", width: 160, sortable: true, dataIndex: 'server'},
   {header: "state", width: 60, sortable: true, dataIndex: 'state'},
   {id: 'name', header: "name", width: 200, sortable: true, dataIndex: 'name'}
	     ],
   stripeRows: true,
   autoExpandColumn: 'name',
   listeners: {
     render: function(){
	 this.store.loadData(alertData);
       }
     }
   },
   {
   title: 'Replication',
   deferredRender: true,
   layout : 'fit',
   items: {
     xtype          : 'iframepanel',
     defaultSrc  : '$nroot/includes/pages/$slavepage'
     },
   shim:false,
   frame:true,
   animCollapse:false,
   enableTabScroll:true,
   autoScroll:true
   }
   ]}
   ]};
 
 new Ext.Viewport({
   layout: 'border',
       title: 'Ext Layout Browser',
       items: [
	       border
	       ],
       renderTo: Ext.getBody()
       });
   });
  
  </script>
      
      
</head>
<body>
HEAD;
  }

$nroot = substr_replace($root,"",-1);
$servers='<table>';
foreach($server_list as $key => $value) {
  $servers .= "<tr>";
  foreach($value as $k => $v) {
    if($k == 'id') { $id=$v;}
    if($k == 'server_hostname') { $list_hostname=$v;}    
    if($k == 'active') {$active=$v;}
    if($k == 'server_client_name') {$server_client_name=$v;}
    if($k == 'server_type') { $server_type=$v;}
  }
  if($server_type == 0) { $server_type='prod';}
  elseif($server_type == 1) { $server_type='stage';}
  elseif($server_type == 2) { $server_type='dev';}

  if($active == 0) { $active="<img src='$nroot/includes/images/Record-Disabled-16x16.png' width='14px' heigh='14px'>";}
  elseif($active == 1) { $active="<img src='$nroot/includes/images/Record-Normal-Green-16x16.png' width='14px' heigh='14px'>";}
  elseif($active == 2) { $active="<img src='$nroot/includes/images/Record-Problem-Red-16x16.png' width='14px' heigh='14px'>";}

  $servers .= "<td>$active <a href='$nroot/index.php/main/host/$id' target='_self'>$list_hostname</a></td></tr>";
}
$servers .= "</table>";
$footer=$alerts;

head(
     $root,
     $server_list,
     $servers,
     $footer,
     $data_size,
     $index_size,
     $total_size,
     $data,
     $alerts,
     $overviewpage,
     $slavepage,
     $graphspage,
     $server_statistics_id,
     $server_list_id,
     $sessionpage);

?>
