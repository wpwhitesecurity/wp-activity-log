<?php

// if not included correctly...
if ( !class_exists( 'WpSecurityAuditLog' ) ) exit();

defined('E_CRITICAL') || define('E_CRITICAL', 'E_CRITICAL');
defined('E_DEBUG') || define('E_DEBUG', 'E_DEBUG');

WpSecurityAuditLog::GetInstance()
	->constants->UseConstants(array(
		// default PHP constants
		array('name' => 'E_ERROR', 'description' => 'Fatal run-time error.'),
		array('name' => 'E_WARNING', 'description' => 'Run-time warning (non-fatal error).'),
		array('name' => 'E_PARSE', 'description' => 'Compile-time parse error.'),
		array('name' => 'E_NOTICE', 'description' => 'Run-time notice.'),
		array('name' => 'E_CORE_ERROR', 'description' => 'Fatal error that occurred during startup.'),
		array('name' => 'E_CORE_WARNING', 'description' => 'Warnings that occurred during startup.'),
		array('name' => 'E_COMPILE_ERROR', 'description' => 'Fatal compile-time error.'),
		array('name' => 'E_COMPILE_WARNING', 'description' => 'Compile-time warning.'),
		array('name' => 'E_USER_ERROR', 'description' => 'User-generated error message.'),
		array('name' => 'E_USER_WARNING', 'description' => 'User-generated warning message.'),
		array('name' => 'E_USER_NOTICE', 'description' => 'User-generated notice message. '),
		array('name' => 'E_STRICT', 'description' => 'Non-standard/optimal code warning.'),
		array('name' => 'E_RECOVERABLE_ERROR', 'description' => 'Catchable fatal error.'),
		array('name' => 'E_DEPRECATED', 'description' => 'Run-time deprecation notices.'),
		array('name' => 'E_USER_DEPRECATED', 'description' => 'Run-time user deprecation notices.'),
		// custom constants
		array('name' => 'E_CRITICAL', 'description' => 'Critical, high-impact messages.'),
		array('name' => 'E_DEBUG', 'description' => 'Debug informational messages.'),
	));

WpSecurityAuditLog::GetInstance()
	->alerts->RegisterGroup(array(
		'Other User Activity' => array(
			array(1000, E_NOTICE, 'User logs in', 'Successfully logged in'),
			array(1001, E_NOTICE, 'User logs out', 'Successfully logged out'),
			array(1002, E_WARNING, 'Login failed', 'Failed login detected using "%Username%" as username'),
			array(2010, E_NOTICE, 'User uploaded file from Uploads directory', 'Uploaded the file %FileName% in %FilePath%'),
			array(2011, E_WARNING, 'User deleted file from Uploads directory', 'Deleted the file %FileName% from %FilePath%'),
			array(2046, E_CRITICAL, 'User changed a file using the editor', 'Modified %File% with the Theme Editor'),
		),
		'Blog Posts' => array(
			array(2000, E_NOTICE, 'User created a new blog post and saved it as draft', 'Created a new blog post called %PostTitle%. Blog post ID is %PostID%'),
			array(2001, E_NOTICE, 'User published a blog post', 'Published a blog post called %PostTitle%. Blog post URL is %PostUrl%'),
			array(2002, E_NOTICE, 'User modified a published blog post', 'Modified the published blog post %PostTitle%. Blog post URL is %PostUrl%'),
			array(2003, E_NOTICE, 'User modified a draft blog post', 'Modified the draft blog post %PostTitle%. Blog post ID is %PostID%'),
			array(2008, E_NOTICE, 'User permanently deleted a blog post from the trash', 'Deleted the post %PostTitle%. Blog post ID is %PostID%'),
			array(2012, E_WARNING, 'User moved a blog post to the trash', 'Moved the blog post %PostTitle% to trash'),
			array(2014, E_CRITICAL, 'User restored a blog post from trash', 'Restored post %PostTitle% from trash'),
			array(2016, E_NOTICE, 'User changed blog post category', 'Changed the category of the post %PostTitle% from %OldCategories% to %NewCategories%'),
			array(2017, E_NOTICE, 'User changed blog post URL', 'Changed the URL of the post %PostTitle% from %OldUrl% to %NewUrl%'),
			array(2019, E_NOTICE, 'User changed blog post author', 'Changed the author of %PostTitle% post from %OldAuthor% to %NewAuthor%'),
			array(2021, E_NOTICE, 'User changed blog post status', 'Changed the status of %PostTitle% post from %OldStatus% to %NewStatus%'),
			array(2023, E_NOTICE, 'User created new category', 'Created a new category called %CategoryName%'),
			array(2024, E_WARNING, 'User deleted category', 'Deleted the %CategoryName% category'),
			array(2025, E_WARNING, 'User changed the visibility of a blog post', 'Changed the visibility of %PostTitle% blog post  from %OldVisibility% to %NewVisibility%'),
			array(2027, E_NOTICE, 'User changed the date of a blog post', 'Changed the date of %PostTitle% blog post from %OldDate% to %NewDate%'),
			array(2049, E_NOTICE, 'User sets a post as sticky', 'Set the post %PostTitle% as Sticky'),
			array(2050, E_NOTICE, 'User removes post from sticky', 'Removed the post %PostTitle% from Sticky'),
		),
		'Pages' => array(
			array(2004, E_NOTICE, 'User created a new WordPress page and saved it as draft', 'Created a new page called %PostTitle%. Page ID is %PostID%'),
			array(2005, E_NOTICE, 'User published a WorPress page', 'Published a page called %PostTitle%. Page URL is %PageUrl%'),
			array(2006, E_NOTICE, 'User modified a published WordPress page', 'Modified the published page %PostTitle%. Page URL is %PostUrl%'),
			array(2007, E_NOTICE, 'User modified a draft WordPress page', 'Modified the draft page %PostTitle%. page ID is %PostID%'),
			array(2009, E_NOTICE, 'User permanently deleted a page from the trash', 'Deleted the page %PostTitle%. Page ID is %PostID%'),
			array(2013, E_WARNING, 'User moved WordPress page to the trash', 'Moved the page %PostTitle% to trash'),
			array(2015, E_CRITICAL, 'User restored a WordPress page from trash', 'Restored page %PostTitle% from trash'),
			array(2018, E_NOTICE, 'User changed page URL', 'Changed the URL of the page %PostTitle% from %OldUrl% to %NewUrl%'),
			array(2020, E_NOTICE, 'User changed page author', 'Changed the author of %PostTitle% page from %OldAuthor% to %NewAuthor%'),
			array(2022, E_NOTICE, 'User changed page status', 'Changed the status of %PostTitle% page from %OldStatus% to %NewStatus%'),
			array(2026, E_WARNING, 'User changed the visibility of a page post', 'Changed the visibility of %PostTitle% page  from %OldVisibility% to %NewVisibility%'),
			array(2028, E_NOTICE, 'User changed the date of a page post', 'Changed the date of %PostTitle% page from %OldDate% to %NewDate%'),
			array(2047, E_NOTICE, 'User changed the parent of a page', 'Changed the parent of %PostTitle% page from %OldParentName% to %NewParentName%'),
			array(2048, E_CRITICAL, 'User changes the template of a page', 'Changed the page template from %OldTemplate% to %NewTemplate%'),
		),
		'Custom Posts' => array(
			array(2029, E_NOTICE, 'User created a new post with custom post type and saved it as draft', 'Created a new custom post called %PostTitle% of type %PostType%. Post ID is %PostID%'),
			array(2030, E_NOTICE, 'User published a post with custom post type', 'Published a custom post %PostTitle% of type %PostType%. Post URL is %PostUrl%'),
			array(2031, E_NOTICE, 'User modified a post with custom post type', 'Modified custom post %PostTitle% of type %PostType%. Post URL is %PostUrl%'),
			array(2032, E_NOTICE, 'User modified a draft post with custom post type', 'Modified draft custom post %PostTitle% of type is %PostType%. Post URL is %PostUrl%'),
			array(2033, E_WARNING, 'User permanently deleted post with custom post type', 'Deleted custom post %PostTitle% of type %PostType%'),
			array(2034, E_WARNING, 'User moved post with custom post type to trash', 'Moved custom post %PostTitle% to trash. Post type is %PostType%'),
			array(2035, E_CRITICAL, 'User restored post with custom post type from trash', 'Restored custom post %PostTitle% of type %PostType% from trash'),
			array(2036, E_NOTICE, 'User changed the category of a post with custom post type', 'Changed the category(ies) of custom post %PostTitle% of type %PostType% from %OldCategories% to %NewCategories%'),
			array(2037, E_NOTICE, 'User changed the URL of a post with custom post type', 'Changed the URL of custom post %PostTitle% of type %PostType% from %OldUrl% to %NewUrl%'),
			array(2038, E_NOTICE, 'User changed the author or post with custom post type', 'Changed the author of custom post %PostTitle% of type %PostType% from %OldAuthor% to %NewAuthor%'),
			array(2039, E_NOTICE, 'User changed the status of post with custom post type', 'Changed the status of custom post %PostTitle% of type %PostType% from %OldStatus% to %NewStatus%'),
			array(2040, E_WARNING, 'User changed the visibility of a post with custom post type', 'Changed the visibility of custom post %PostTitle% of type %PostType% from %OldVisibility% to %NewVisibility%'),
			array(2041, E_NOTICE, 'User changed the date of post with custom post type', 'Changed the date of custom post %PostTitle% of type %PostType% from %OldDate% to %NewDate%'),
		),
		'Widgets' => array(
			array(2042, E_CRITICAL, 'User added a new widget', 'Added a new %WidgetName% widget in  %Sidebar%'),
			array(2043, E_WARNING, 'User modified a widget', 'Modified the %WidgetName% widget in %Sidebar%'),
			array(2044, E_CRITICAL, 'User deleted widget', 'Deleted the %WidgetName% widget from %Sidebar%'),
			array(2045, E_NOTICE, 'User moved widget', 'Moved the %WidgetName% widget from %OldSidebar% to %NewSidebar%'),
		),
		'User Profiles' => array(
			array(4000, E_CRITICAL, 'A new user was created on WordPress', 'User %NewUserData->Username% subscribed with a role of %NewUserData->Roles%'),
			array(4001, E_CRITICAL, 'A user created another WordPress user', 'Created a new user %NewUserData->Username% with the role of %NewUserData->Roles%'),
			array(4002, E_CRITICAL, 'The role of a user was changed by another WordPress user', 'Changed the role of user %Username% from %OldRole% to %NewRole%'),
			array(4003, E_CRITICAL, 'User has changed his or her password', 'Changed the password'),
			array(4004, E_CRITICAL, 'A user changed another user\'s password', 'Changed the password for user %UserData->Username% with the role of %UserData->Roles%'),
			array(4005, E_NOTICE, 'User changed his or her email address', 'Changed the email address from %OldEmail% to %NewEmail%'),
			array(4006, E_NOTICE, 'A user changed another user\'s email address', 'Changed the email address of user account %Username% from %OldEmail% to %NewEmail%'),
			array(4007, E_CRITICAL, 'A user was deleted by another user', 'Deleted User %UserData->Username% with the role of %UserData->Roles%'),
		),
		'Plugins & Themes' => array(
			array(5000, E_CRITICAL, 'User installed a plugin', 'Installed the plugin %PluginName% in %PluginPath%'),
			array(5001, E_CRITICAL, 'User activated a WordPress plugin', 'Activated the plugin %PluginData->Name% installed in %PluginFile%'),
			array(5002, E_CRITICAL, 'User deactivated a WordPress plugin', 'Deactivated the plugin %PluginData->Name% installed in %PluginFile%'),
			array(5003, E_CRITICAL, 'User uninstalled a plugin', 'Uninstalled the plugin %PluginData->Name% which was installed in %PluginFile%'),
			array(5004, E_WARNING, 'User upgraded a plugin', 'Upgrade the plugin %PluginData->Name% installed in %PluginFile%'),
			array(5005, E_CRITICAL, 'User installed a theme', 'Installed theme "%NewTheme->Name%" in %NewTheme->get_template_directory%'),
			array(5006, E_CRITICAL, 'User activated a theme', 'Activated theme "%NewTheme->Name%", installed in %NewTheme->get_template_directory%'),
		),
		'System Activity' => array(
			array(0001, E_CRITICAL, 'PHP error', '%Message%'),
			array(0002, E_WARNING, 'PHP warning', '%Message%'),
			array(0003, E_NOTICE, 'PHP notice', '%Message%'),
			array(0004, E_CRITICAL, 'PHP exception', '%Message%'),
			array(6000, E_NOTICE, 'Events automatically pruned by system', ''),
			array(6001, E_CRITICAL, 'Option Anyone Can Register in WordPress settings changed', '%NewValue% the option "Anyone can register"'),
			array(6002, E_CRITICAL, 'New User Default Role changed', 'Changed the New User Default Role from %OldRole% to %NewRole%'),
			array(6003, E_CRITICAL, 'WordPress Administrator Notification email changed', 'Changed the WordPress administrator notifications email address from %OldEmail% to %NewEmail%'),
			array(6004, E_CRITICAL, 'WordPress was updated', 'Updated WordPress from version %OldVersion% to %NewVersion%'),
			array(6005, E_CRITICAL, 'User changes the WordPress Permalinks', 'Changed the WordPress permalinks from %OldPattern% to %NewPattern%'),
		),
		'MultiSite' => array(
			array(4008, E_CRITICAL, 'User granted Super Admin privileges', 'Granted Super Admin privileges to %Username%'),
			array(4009, E_CRITICAL, 'User revoked from Super Admin privileges', 'Revoked Super Admin privileges from %Username%'),
			array(4010, E_CRITICAL, 'Existing user added to a site', 'Added existing user %Username% with %UserRole% role to site %SiteName%'),
			array(4011, E_CRITICAL, 'User removed from site', 'Removed user %Username% with role %UserRole% from %SiteName% site'),
			array(4012, E_CRITICAL, 'New network user created', 'Created a new network user %NewUserData->Username%'),
			array(7000, E_CRITICAL, 'New site added on network', 'Added site %SiteName% to the network'),
			array(7001, E_CRITICAL, 'Existing site archived', 'Archived site %SiteName%'),
			array(7002, E_CRITICAL, 'Archived site has been unarchived', 'Unarchived site %SiteName%'),
			array(7003, E_CRITICAL, 'Deactivated site has been activated', 'Activated site %SiteName%'),
			array(7004, E_CRITICAL, 'Site has been deactivated', 'Deactivated site %SiteName%'),
			array(7005, E_CRITICAL, 'Existing site deleted from network', 'Deleted site %SiteName%'),
		),
	));
