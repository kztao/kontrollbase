<?php  
  /**
   * Kontrollbase
   *
   * An open source MySQL monitoring and analytics application
   *
   * @packageKontrollbase
   * @authorMatt Reid
   * @copyrightCopyright (c) 2009 Matt Reid, Kontrollbase LLC
   * @licensehttp://kontrollsoft.com/kontrollbase/userguide/general-LICENSE.php
   * @linkhttp://kontrollbase.cm
   * @sinceVersion 2.0.1
   * @filesource
   */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['base_url']= "http://yourdomain.com/"; //USE TRAILING SLASH
$config['base_dir']     = "/var/www/html/kontrollbase"; //NO TRAILING SLASH
$config['schema_readonly_name'] = "kontrollbase";
$config['google_uacct'] = "UA-922072-13";
$config['index_page'] = "index.php";
$config['uri_protocol']= "AUTO";
$config['url_suffix'] = "";
$config['language']= "english";
$config['charset'] = "UTF-8";
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd'; 
$config['log_threshold'] = 4;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['memcache_enabled'] = FALSE;
$config['memcache_ip']= '127.0.0.1';
$config['memcache_port'] = '11211';
$config['encryption_key'] = "bcf6ac7da2493874e344";
$config['sess_cookie_name']= 'kontrollbase_session';
$config['sess_expiration']= 600;
$config['sess_encrypt_cookie']= TRUE;
$config['sess_use_database']= FALSE;
$config['sess_table_name']= 'webapp_sessions';
$config['sess_match_ip']= TRUE;
$config['sess_match_useragent']= TRUE;
$config['sess_time_to_update'] = 600;
$config['cookie_prefix']= "";
$config['cookie_domain']= "";
$config['cookie_path']= "/";
$config['global_xss_filtering'] = TRUE;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['ci_version'] = '1.7.0'; # CodeIgniter framework version
$config['extjs_version'] = '3.0.0'; # ExtJS framework version
$config['kb_version'] = '2.0.1'; # Kontrollbase version
$config['kb_revision'] = "194"; //Kontrollbase revision number
/* End of file config.php */
/* Location: ./system/application/config/config.php */
?>
