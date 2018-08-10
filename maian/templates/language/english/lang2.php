<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: lang2.php
  Description: English Language File Additions for v2.1

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/******************************************************************************************************
 * LANGUAGE FILE - PLEASE READ                                                                        *
 * This is a language file for the Maian Support script. Edit it to suit your own preferences.        *
 * DO NOT edit the language variable names in any way and be careful NOT to remove any of the         *
 * apostrophe`s (') that contain the variable info. This will cause the script to malfunction.        *
 * USING APOSTROPHES IN MESSAGES                                                                      *
 * If you need to use an apostrophe, escape it with a backslash. ie: d\'apostrophe                    *  
 * SYSTEM VARIABLES                                                                                   *
 * Single letter variables with a percentage sign are system variables. ie: %d, %s {%d} etc           *
 * The system will not fail if you accidentally delete these, but some language may not display       *
 * correctly.                                                                                         *
 ******************************************************************************************************/

$msg_header3               = 'My Account';
$msg_header4               = 'Search';
$msg_header6               = 'Logged in as: {name} &lt;<span class="user" id="logged_in_email">{email}</span>&gt;';
$msg_header7               = 'New Ticket';
$msg_header8               = 'F.A.Q';
$msg_header9               = 'Search Tickets';

$msg_pkbase7               = 'All Categories';

$msg_main15                = '';
$msg_main16                = 'If you need assistance, please open a new ticket.';
$msg_main17                = 'Before you open a new ticket, check our FAQ to see if your question has already been answered. Thank you.';
$msg_main18                = 'All Frequently Asked Questions';
$msg_main19                = '';
$msg_main20                = 'Portal access is disabled. Please contact us immediately.';
$msg_main21                = 'Filter by Category';
$msg_main22                = 'All Categories';
$msg_main23                = 'Before you open a new ticket, check our FAQ section below to see if your question has already been answered. Thank you.';

$msg_pkbase19              = '<span class="incat">In Category: {category}</span>';

$msg_portsearch            = '<b>Search Results</b>: {count}';
$msg_portsearch2           = 'All Types';
$msg_portsearch3           = 'Tickets Only';
$msg_portsearch4           = 'Disputes Only';


$msg_tickets               = '<b>Total Tickets</b>: {count}';
$msg_tickets2              = '<b>Total Disputes</b>: {count}';

$msg_newticket2            = 'Please use the form below to open a new support ticket. If you wish to open a dispute, please give details about who you want to open a dispute with. If your ticket is accepted and moved to a dispute, further emails will follow. Required fields are marked with a *.<br /><br /><span class="highlight">Note that a password will be assigned to you if this is your first ticket. It is shown after you submit a ticket. This can be changed later if required.</span>';
$msg_newticket30           = 'Please use the form below to open a new support ticket. If you wish to open a dispute, please give details about who you want to open a dispute with. If your ticket is accepted and moved to a dispute, further emails will follow. Required fields are marked with a *.';
$msg_newticket31           = 'Required field, please complete..';
$msg_newticket32           = 'BBCode Text Formatting';
$msg_newticket33           = 'Max';
$msg_newticket34           = 'Allowed File Extensions';
$msg_newticket35           = 'Max Size Per File';
$msg_newticket36           = 'Please fix the {count} error(s) highlighted below';
$msg_newticket37           = 'Add Box';
$msg_newticket38           = 'Remove Box';
$msg_newticket39           = 'Please enable javascript in your browser..';
$msg_newticket40           = 'Your new ticket entitled &quot;{subject}&quot; has been created.<br /><br />Email confirmation has been sent to <span class="highlight">{email}</span>.<br /><br />
                              This appears to be your first ticket, so an account has been created for you:<br /><br />
                              E-Mail: <span class="highlight">{email}</span><br />
                              Password: <span class="highlight">{pass}</span><br /><br />
                              <b>Make a note of these details now</b>.<br /><br />
                              We would suggest you log in and update your password immediately to something you can remember.<br /><br />
                              <a href="index.php?e={email}&amp;ap={pass}" class="login" title="Support Ticket Portal Login">Support Ticket Portal Login</a><br /><br />
                              Further emails will follow as soon as your ticket has been reviewed by the support team.<br /><br />
                              Kind regards,<br />
                              {website}';
$msg_newticket41           = 'Your new ticket entitled &quot;{subject}&quot; has been created.<br /><br />Email confirmation has been sent to <span class="highlight">{email}</span>.<br /><br />
                              Further emails will follow as soon as your ticket has been reviewed by the support team.<br /><br />
                              Click <a href="?p=portal">here</a> to return to your ticket portal.<br /><br />
                              Kind regards,<br />
                              {website}';
$msg_newticket42           = 'New Ticket Created';
$msg_newticket43           = 'Preview Message';
$msg_newticket44           = 'No preview available.';
$msg_newticket45           = 'Your new ticket entitled &quot;{subject}&quot; has been created.<br /><br />Email confirmation has been sent to <span class="highlight">{email}</span>.<br /><br />
                              Further emails will follow as soon as your ticket has been reviewed by the support team.<br /><br />
                              Click <a href="?e={email}">here</a> to log in to your ticket portal.<br /><br />
                              Kind regards,<br />
                              {website}';

$msg_showticket27          = 'View All Tickets';
$msg_showticket28          = 'View All Disputes';
$msg_showticket29          = 'Dispute ID';
$msg_showticket30          = '{count} Users in Dispute';
$msg_showticket31          = '[#{ticket}] Dispute Updated';
$msg_showticket32          = 'Viewing Dispute: #{ticket}';
$msg_showticket33          = 'This dispute currently has 0 replies.';

$msg_portal                = 'Your Account';
$msg_portal2               = 'Ticket Overview';
$msg_portal5               = 'Welcome to your support ticket portal.<br /><br />Any open support tickets/disputes are shown below.<br /><br />Please use the links on the right to manage your account. We recommend you
                              change your password from time to time for security.<br /><br />Any problems, please contact us. Thank you.';
$msg_portal6               = 'Open Tickets / Disputes';
$msg_portal17              = 'Search Results';
$msg_portal24              = 'All Disputes';
$msg_portal25              = 'Enter New E-Mail Address';
$msg_portal26              = 'Update E-Mail Address';
$msg_portal27              = '<b>{open}</b> open ticket(s)';
$msg_portal28              = '<b>{dis_open}</b> open dispute(s)';
$msg_portal29              = 'Your password was successfully updated, thank you.'.mswDefineNewline().mswDefineNewline().'Your new password is: {pass}';
$msg_portal30              = 'Invalid e-mail address, try again..';
$msg_portal31              = 'E-mail address must be an alternative address..';
$msg_portal32              = 'E-mail already exists, please choose another..';
$msg_portal33              = 'Your e-mail address has been successfully updated, thank you.';
$msg_portal34              = '[{website}] E-Mail Update Confirmation';
$msg_portal35              = 'View Dispute';
$msg_portal36              = 'My Disputes';
$msg_portal37              = 'View All Tickets';
$msg_portal38              = 'View All Disputes';
$msg_portal39              = 'All';
$msg_portal40              = 'Open Tickets';
$msg_portal41              = 'Open Disputes';
$msg_portal42              = 'Ticket: #{ticketID} - (Started by {name})';
$msg_portal43              = 'Dispute: #{ticketID} - (Started by {name}, {count} users in dispute)';
$msg_portal44              = 'You currently have 0 disputes to display. Previous dispute tickets may have been deleted.';
$msg_portal45              = 'My Disputes';

$msg_adheader24            = 'Imap Accounts';
$msg_adheader25            = 'Logged in as';
$msg_adheader26            = 'Custom Fields';
$msg_adheader27            = 'Version Check';
$msg_adheader28            = 'Open Disputes';
$msg_adheader29            = 'Closed Disputes';
$msg_adheader30            = 'Database Backup';
$msg_adheader31            = 'Helpdesk';

$msg_backup                = 'This feature lets you take a schematic backup of your database, this is recommended from time to time in case you suffer a server/database crash. You
                              should not totally rely on the backup option here, so a further backup with your database administration software is recommended.<br /><br />Listed below are 
                              the tables in your database, click the button to download backup file or send backup file as attachment to e-mail address(es). 
                              E-mail option requires <a href="?p=settings">SMTP</a> is enabled in settings. You should perform a backup at least once a week. If you are using the e-mail option, e-mail should NOT exist on the same server as your database.<br /><br />
                              Backup can be set up as automated task if required.';
$msg_backup2               = 'MySQL Database Schematic';
$msg_backup3               = 'Name';
$msg_backup4               = 'Rows';
$msg_backup5               = 'Size';
$msg_backup6               = 'Created';
$msg_backup7               = 'Last Updated';
$msg_backup8               = 'Engine';
$msg_backup9               = 'Backup Options';
$msg_backup10              = 'Estimated Backup Size';
$msg_backup11              = 'Download to Hard Drive';
$msg_backup12              = 'Copy as Attachment to E-Mail Address(es)';
$msg_backup13              = 'Compress Backup File';
$msg_backup14              = 'Process Backup';
$msg_backup15              = 'Backup Completed and E-Mailed';

$msg_customfields          = 'This feature enables you to add custom form fields to the ticket creation and/or reply pages. Useful if you need to get specific data from customers or visitors on ticket creation or replies. Hover over the help tips for more information.';
$msg_customfields2         = 'Add New Field';
$msg_customfields3         = 'Instructions/Text';
$msg_customfields4         = 'Field Type';
$msg_customfields5         = 'Textarea';
$msg_customfields6         = 'Input';
$msg_customfields7         = 'Select';
$msg_customfields8         = 'Checkboxes';
$msg_customfields9         = 'Required Field';
$msg_customfields10        = 'Select/Checkbox Options (One per line)';
$msg_customfields11        = 'Update Field';
$msg_customfields12        = 'New Field Added';
$msg_customfields13        = 'Field Updated';
$msg_customfields14        = 'Field Deleted';
$msg_customfields15        = 'Current Custom Fields';
$msg_customfields16        = 'There are currently 0 custom fields in the system';
$msg_customfields17        = 'Field Location';
$msg_customfields18        = 'New Ticket';
$msg_customfields19        = 'Ticket Reply';
$msg_customfields20        = 'Admin Reply';
$msg_customfields21        = 'Update Field Order';
$msg_customfields22        = 'Field Order Updated';
$msg_customfields23        = 'ID';
$msg_customfields24        = 'Admin Reply Visibility';
$msg_customfields25        = 'Selected Fields Enabled';
$msg_customfields26        = 'Selected Fields Disabled';
$msg_customfields27        = 'Enable Field';
$msg_customfields28        = 'Visible';
$msg_customfields29        = 'Invisible';
$msg_customfields30        = 'Type: {type} &#8226; Required: {req} &#8226; Location: {loc} &#8226; Departments: {dept}';

$msg_disputes              = '<span class="highlight"><b>{count}</b></span> open dispute(s). Click icon to view dispute.';
$msg_disputes2             = '<span class="highlight"><b>{count}</b></span> closed dispute(s). Closed disputes must be re-opened to add new replies.';
$msg_disputes3             = 'Create Dispute';
$msg_disputes4             = 'Create Ticket';
$msg_disputes5             = 'Dispute Users';
$msg_disputes6             = 'Original User Details';
$msg_disputes7             = 'Currently 0 other users in dispute<br />with {name}';
$msg_disputes8             = 'Manage Users';
$msg_disputes9             = 'Post Privileges OFF';
$msg_disputes10            = 'Post Privileges ON';
$msg_disputes11            = 'Click to Edit Name/E-Mail';
$msg_disputes12            = 'Update';
$msg_disputes13            = 'in dispute with:';
$msg_disputes14            = 'Click to enable/disable post privileges';
$msg_disputes15            = 'Open Dispute Notification';
$msg_disputes16            = 'There are currently no disputes to display.';

$msg_dept15                = 'Display on Open New Ticket Page';
$msg_dept16                = 'Display: Off';
$msg_dept17                = 'Auto Populate Subject (Optional)';
$msg_dept18                = 'Auto Populate Comments (Optional)';
$msg_dept19                = 'Department Name';
$msg_dept20                = 'Update Display Order';
$msg_dept21                = 'Order Display Updated';

$msg_home26                = 'Open Disputes (Awaiting Admin/Other)';
$msg_home27                = 'Open Disputes (Awaiting Visitor)';
$msg_home28                = 'Closed Disputes';
$msg_home29                = 'Dispute Overview';
$msg_home30                = 'Ticket Overview';
$msg_home31                = 'Latest {count} Tickets Awaiting Admin Response';
$msg_home32                = 'Latest {count} Disputes Awaiting Admin/Other Response';
$msg_home33                = 'Today';
$msg_home34                = 'This Week';
$msg_home35                = 'This Month';
$msg_home36                = 'This Year';
$msg_home37                = 'Tickets';
$msg_home38                = 'Disputes';
$msg_home39                = 'Latest {count} Tickets Awaiting Visitor Response';
$msg_home40                = 'Latest {count} Disputes Awaiting Visitor Response';
$msg_home41                = 'There are currently 0 tickets to display';
$msg_home42                = 'Quick Links';
$msg_home43                = 'New Disputes (No Replies)';
$msg_home44                = 'From: {name} / Priority: {priority} / Last Updated: {date}';
$msg_home45                = 'From: {name} / Priority: {priority} / Last Updated: {date} / {count} Users in Dispute';

$msg_kbase24               = 'Enable Category';
$msg_kbase25               = '(Disabled)';
$msg_kbase26               = 'Preview Answer';
$msg_kbase27               = 'Reset Voting Counts';
$msg_kbase28               = 'Enable';
$msg_kbase29               = 'Disable';
$msg_kbase30               = 'Selected Categories Enabled';
$msg_kbase31               = 'Selected Categories Disabled';
$msg_kbase32               = 'Selected Questions Enabled';
$msg_kbase33               = 'Selected Questions Disabled';
$msg_kbase34               = 'Order Display Updated';
$msg_kbase35               = 'Update Display Order';

$msg_imap                  = 'Add New Imap Account';
$msg_imap2                 = 'The imap functions enable tickets to be opened via standard e-mails. The system reads the mailbox and imports the data into the ticket system, opening a standard ticket. Subsequent replies via email are assigned to the same ticket.';
$msg_imap3                 = 'Enable Imap Account';
$msg_imap4                 = 'Mailbox Protocol';
$msg_imap5                 = 'Pop3';
$msg_imap6                 = 'Imap';
$msg_imap7                 = 'Mailbox Host';
$msg_imap8                 = 'Mailbox User';
$msg_imap9                 = 'Mailbox Password';
$msg_imap10                = 'Mailbox Port';
$msg_imap11                = 'Mailbox Name';
$msg_imap12                = 'Mailbox Flags';
$msg_imap13                = 'Accept Attachments';
$msg_imap14                = 'After Reading, Move Message to';
$msg_imap15                = 'Maximum Messages to Fetch';
$msg_imap16                = 'Enable SSL';
$msg_imap17                = 'Assign to Department';
$msg_imap18                = 'Default Priority';
$msg_imap19                = 'Imap Reply-to E-Mail Address';
$msg_imap20                = 'Current Imap Accounts';
$msg_imap21                = 'There are currently 0 imap accounts in the system';
$msg_imap22                = 'Imap Account Added';
$msg_imap23                = 'Imap Account Updated';
$msg_imap24                = 'Imap Account Deleted';
$msg_imap25                = 'Update Imap Account';
$msg_imap26                = 'Selected Accounts Enabled';
$msg_imap27                = 'Selected Accounts Disabled';
$msg_imap28                = 'ID';
$msg_imap29                = 'Check Mail';
$msg_imap30                = 'Department: {dept} &#8226; Attachments: {attach}';
$msg_imap31                = 'Show Folders';

$msg_log6                  = 'All Admin Users';

$msg_merge3                = 'Select Parent Dispute - Click Icon to Load'; 
$msg_merge4                = 'Click to Select New Parent Dispute';
$msg_merge5                = 'There are currently no disputes to display.';

$msg_open22                = '<span class="highlight">#{ticket}</span> &#8226; Opened: <span class="highlight">{date}</span> &#8226; Priority: <span class="highlight">{priority}</span> &#8226; Dept: <span class="highlight">{dept}</span> &#8226; Replies: <span class="highlight">{replies}</span> &#8226; Users in Dispute: <span class="highlight">{dispute}</span><span class="floatright"><span class="highlight">{status}</span></span>';
$msg_open23                = 'Delete Selected Disputes';
$msg_open24                = 'View Dispute';
$msg_open25                = 'Dispute Re-Opened';
$msg_open26                = 'Selected Disputes Deleted';
$msg_open27                = 'New - Awaiting Admin Response';
$msg_open28                = '<span class="highlight">#{ticket}</span> &#8226; Opened: <span class="highlight">{date}</span> &#8226; Priority: <span class="highlight">{priority}</span> &#8226; Dept: <span class="highlight">{dept}</span> &#8226; Replies: <span class="highlight">{replies}</span><span class="floatrightclosed"><span class="highlight">{status}</span></span>';
$msg_open29                = '<span class="highlight">#{ticket}</span> &#8226; Opened: <span class="highlight">{date}</span> &#8226; Priority: <span class="highlight">{priority}</span> &#8226; Dept: <span class="highlight">{dept}</span> &#8226; Replies: <span class="highlight">{replies}</span> &#8226; Users in Dispute: <span class="highlight">{dispute}</span><span class="floatrightclosed"><span class="highlight">{status}</span></span>';
$msg_open30                = 'Open - Awaiting Admin/Other Response';

$msg_response16            = 'Selected Responses Enabled';
$msg_response17            = 'Selected Responses Disabled';

$msg_search11              = 'Ticket Type';
$msg_search12              = 'Standard Ticket';
$msg_search13              = 'Dispute';

$msg_settings58            = 'Enable BB Code';
$msg_settings59            = 'XML-RPC API Key (<a href="#" onclick="ms_generateAPIKey();return false">Generate Key</a>)';
$msg_settings60            = 'Public Key';
$msg_settings61            = 'Private Key';
$msg_settings62            = 'reCaptcha Settings';
$msg_settings63            = 'Create Keys';
$msg_settings64            = 'Start Day for Week';
$msg_settings65            = 'Sunday';
$msg_settings66            = 'Monday';
$msg_settings67            = 'Disable if User is Logged In';
$msg_settings68            = 'Questions Per Page';
$msg_settings69            = 'Javascript Calendar Date Format';

$msg_systemportal19        = 'Enable/Disable Login Access';
$msg_systemportal20        = 'Block';
$msg_systemportal21        = 'Enter E-Mail Address';
$msg_systemportal22        = 'Acccount Disabled';
$msg_systemportal23        = 'Re-Enable';
$msg_systemportal24        = 'Acccount Enabled';
$msg_systemportal25        = 'There are no accounts currently disabled';

$msg_tools11               = 'This page is not available, due to your delete privileges being switched off.';

$msg_user12                = 'Login Password (<a href="#" onclick="jQuery(\'#passOptions\').show(\'slow\');jQuery(\'#pass\').hide();return false" title="Generate Password">Generate</a>)';
$msg_user45                = 'Display Signature in E-Mails';
$msg_user46                = 'Send E-Mail Notification to User on Account Creation';
$msg_user47                = 'A-Z';
$msg_user48                = '0-9';
$msg_user49                = '[*@]';
$msg_user50                = 'Create';
$msg_user51                = 'Cancel';
$msg_user52                = 'a-z';
$msg_user53                = '[{website}] Welcome to the Support Team';
$msg_user54                = 'Ticket Notepad Access';
$msg_user55                = '(Notification Disabled)';
$msg_user56                = 'All Departments';
$msg_user57                = 'All Pages';
$msg_user58                = 'Dispute';
$msg_user59                = 'View Dispute';
$msg_user60                = 'All Responses';
$msg_user61                = 'Tickets Only';
$msg_user62                = 'Disputes Only';
$msg_user63                = 'Between';
$msg_user64                = 'Delete Privileges';
$msg_user65                = 'Ticket \'From\' Name';
$msg_user66                = 'Ticket \'From\' E-Mail Address';
$msg_user67                = 'Ticket From Name/Email';
$msg_user68                = 'No pages set at the moment';

$msg_viewticket51          = 'Describe this Change for Other Users';
$msg_viewticket52          = '[#{ticket}] Ticket Admin Edit Notification';
$msg_viewticket54          = 'Notepad';
$msg_viewticket55          = 'Preview Message';
$msg_viewticket56          = 'BB Code';
$msg_viewticket57          = 'There are no standard responses to display.';
$msg_viewticket58          = 'Add Users to Dispute';
$msg_viewticket59          = 'Name';
$msg_viewticket60          = 'E-Mail Address';
$msg_viewticket61          = '{users} user(s) disputed by &quot;{original}&quot;';
$msg_viewticket62          = 'Update Selected Users';
$msg_viewticket63          = 'Enable Post Privileges';
$msg_viewticket64          = 'Disable Post Privileges';
$msg_viewticket65          = 'Delete User &amp; Posts';
$msg_viewticket66          = 'There have been 0 users added to this dispute';
$msg_viewticket67          = 'Add Users to Dispute';
$msg_viewticket68          = '{count} User(s) Added to Dispute';
$msg_viewticket69          = '{count} User(s) Updated';
$msg_viewticket70          = '[#{ticket}] Dispute Opened - Please Read';
$msg_viewticket71          = 'All';
$msg_viewticket72          = 'View Notes';
$msg_viewticket73          = 'This ticket currently has no notes.';
$msg_viewticket74          = 'Viewing Notes for Ticket #{ticket}';
$msg_viewticket75          = 'Add Reply';
$msg_viewticket76          = 'Your post privileges have currently been turned off by admin, please try again later';
$msg_viewticket77          = 'Update Notes';
$msg_viewticket78          = 'Attach File(s):';
$msg_viewticket79          = 'Template Language';
$msg_viewticket80          = 'Viewing Dispute: #{ticket}';
$msg_viewticket81          = 'Dispute: <b>#{ticket}</b>';
$msg_viewticket82          = 'This dispute currently has no notes.';
$msg_viewticket83          = 'Viewing Notes for Dispute #{ticket}';
$msg_viewticket84          = 'Merge With Dispute #';
$msg_viewticket85          = 'Edit Dispute Ticket #{ticket}';
$msg_viewticket86          = 'Dispute Ticket Updated';
$msg_viewticket87          = 'Edit Dispute Ticket Reply: #{ticket}';
$msg_viewticket88          = 'Update Dispute Ticket';
$msg_viewticket89          = 'Update Dispute Ticket Reply';
$msg_viewticket90          = 'Ticket Merged';

$msg_bbcode                = 'BB Code Formatting';
$msg_bbcode2               = 'BB Code is a collection of formatting tags that are used to change the look of text. BB Code is based on a similar principal to HTML. Below is a list of all the available BB Codes and instructions on how to use them in this software. Nesting of tags is allowed and tags can be upper or lowercase. Style data can also be changed via the main helpdesk stylesheet.';
$msg_bbcode3               = 'Bold Text';
$msg_bbcode4               = 'Underlined Text';
$msg_bbcode5               = 'Italic Text';
$msg_bbcode6               = 'Strike-Through Text';
$msg_bbcode7               = 'Deleted Text';
$msg_bbcode8               = 'Inserted Text';
$msg_bbcode9               = 'Emphasised Text';
$msg_bbcode10              = 'Red Text';
$msg_bbcode11              = 'Blue Text';
$msg_bbcode12              = 'Heading 1 Text';
$msg_bbcode13              = 'Heading 2 Text';
$msg_bbcode14              = 'Heading 3 Text';
$msg_bbcode15              = 'Heading 4 Text';
$msg_bbcode16              = 'BB Code Usage &amp; Examples';
$msg_bbcode17              = 'Hyperlinks and Images';
$msg_bbcode18              = 'Lists';
$msg_bbcode19              = 'Nesting Tags';
$msg_bbcode20              = 'Bullet List Item';
$msg_bbcode21              = 'Numbered List Item';
$msg_bbcode22              = 'Alpha List Item';
$msg_bbcode23              = 'Bold, Underlined Text';
$msg_bbcode24              = 'Bold, Underlined Blue Text';
$msg_bbcode25              = 'Return to Payment Method';
$msg_bbcode26              = 'Click to E-Mail Me';
$msg_bbcode27              = 'BB Code is a collection of formatting tags that are used to change the look of text. BB Code is based on a similar principal to HTML. Below is a list of all the available BB Codes and instructions on how to use them in your ticket messages/replies. Nesting of tags is allowed and tags can be upper or lowercase.';
$msg_bbcode28              = 'New tab/window';

$msg_edigest               = 'No tickets to display';
$msg_edigest2              = 'No disputes to display';
$msg_edigest3              = '[{website}] E-Mail Digest: Tickets/Disputes';
$msg_edigest4              = 'E-Mail Digest Completed';
$msg_edigest5              = 'From: {name} > Priority: {priority} > Last Updated: {updated}';
$msg_edigest6              = 'From: {name} > Priority: {priority} > {count} Users in Dispute > Last Updated: {updated}';
$msg_edigest7              = 'View';
$msg_edigest8              = 'E-Mail Digest Completed. No Mail Sent (Zero Counts)';


/*------------------------------------------------------------------------------------------------------
  JAVASCRIPT CALENDAR LOCALE
  Javascript arrays. Square brackets are important, DO NOT remove these.
--------------------------------------------------------------------------------------------------------*/


$msg_cal                   = '["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]';
$msg_cal2                  = '["Su","Mo","Tu","We","Th","Fr","Sa"]';
$msg_cal3                  = 'false'; // Should calendar display right to left (RTL)?


// General..

$msg_script23              = 'Close &amp; Refresh';
$msg_script24              = 'Preview not available.';
$msg_script25              = 'Software Locked';
$msg_script26              = 'Previous';
$msg_script27              = 'Next';
$msg_script28              = array('Mon','Tue','Wed','Thur','Fri','Sat','Sun');
$msg_script29              = array('Sun','Mon','Tue','Wed','Thur','Fri','Sat');
$msg_script30              = 'Unassigned';
$msg_script31              = '[{website}] MySQL Backup File for {date}/{time}';
$msg_script32              = 'Backup Completed';
$msg_script33              = 'helpdesk-backup'; // Backup file prefix..
$msg_script34              = 'To add your own footer code, log in to your admin area and click "Settings"';
$msg_script35              = 'To add your own footer code, click "Settings" from the above menu';
$msg_script36              = 'Close Window';
$msg_script37              = 'Sent via XML-RPC. Awaiting Login.';
$msg_script38              = 'Close';
$msg_script39              = 'Preview Message';

$msg_javascript98          = 'Enter text to describe the edit you have made. This is optional and is included in the edit e-mail notification sent to other ticket users if applicable.';
$msg_javascript105         = 'If a user responds to a ticket, do you want their signature (if applicable) to be included in e-mail notifications?<br /><br />Note that if HTML is included in e-mail signatures you MUST enable the html e-mails option in the "control/user-defined/defined.inc.php" file.';
$msg_javascript106         = 'Do you want this department to display on the ticket creation? If unchecked, does not display in department list for visitors. Useful for internal purposes or as an imap department only.';
$msg_javascript107         = 'Do you wish to enable this category?';
$msg_javascript108         = 'Enter field question, text or instructions for customer/visitor. Max 250 Chars.';
$msg_javascript109         = 'Which field type do you require?<br /><br />Textarea = Multi line<br />Input = Single line (Max 250 Chars)<br />Select - Single selection from multiple options<br />Checkboxes = Multi selections from multiple options.';
$msg_javascript110         = 'Is this a required field? If yes, customer/visitor must complete option. If checkboxes are used, at least one box must be selected. Note that restrictions are not imposed in admin area.';
$msg_javascript111         = 'For select and checkboxes which require multiple options. ONE entry PER line.';
$msg_javascript112         = 'Where should the new fields appear?<br /><br />New Ticket = Added to ticket creation page<br />Ticket Reply = Added to ticket reply page<br />Admin Reply = Added to admin ticket reply page<br /><br />If none are selected, will default to New Ticket.';
$msg_javascript113         = 'Do you want user to be able to see and update the notepad area on a ticket page? If disabled, user cannot see or edit notes. System administrator has access by default.';
$msg_javascript114         = 'Add new users to dispute. Use the +/- buttons to add more fields and batch add users if you wish.<br /><br />If users don`t exist in system an account will be created for them to log in and reply to the dispute. E-mails are sent to both registered users and none registered.<br /><br />Note: If you add a user with the same e-mail address as the original user, it will be ignored.';
$msg_javascript115         = 'Manage dispute users below. You can enable/disable post privileges for dispute users if you wish. To prevent original user from posting, close or lock ticket.<br /><br />To update, click the edit icon.';
$msg_javascript116         = 'Do you wish to revert this dispute back to a standard ticket?\n\nIf yes, users will be removed from dispute. Any posts made, will remain.';
$msg_javascript117         = 'Notes Updated';
$msg_javascript118         = 'If you are utilising the XML-RPC data post API option to create tickets from other applications, enter API key. This is to ensure data coming in is valid. Key should be numbers, letters &amp; hyphens ONLY and a max of 100 characters.<br /><br />Click "Generate Key" to auto create key if preferred. See the docs for more information on this feature.';
$msg_javascript119         = 'reCaptcha is a free service from Google to prevent bots from auto submitting forms. Click "Create Keys" to create a free account. After you have signed up for your free account, enter your <b>private key</b> below.<br /><br />To disable spam prevention measures in this software, leave both boxes blank.';
$msg_javascript120         = 'reCaptcha is a free service from Google to prevent bots from auto submitting forms. Click "Create Keys" to create a free account. After you have signed up for your free account, enter your <b>public key</b> below.<br /><br />To disable spam prevention measures in this software, leave both boxes blank.';
$msg_javascript121         = 'Dispute User Updated';
$msg_javascript122         = 'If a field location is set as an Admin Reply it appears on the admin reply pages only. Do you want visitors to see this field information data on their ticket pages? If no, seen only by admin. Useful for backend only operations.';
$msg_javascript123         = 'Specify your preferred start day for the week. This is for the javascript pop up calendar. For example, UK is Sunday.';
$msg_javascript124         = 'Enter e-mail address. If blocked, account with this address cannot login to their tickets. Once you start typing suggestions will appear. This helps to locate e-mails faster.';
$msg_javascript125         = 'Do you wish to enable or disable this question/answer?';
$msg_javascript126         = 'Determines which language pack loads for replies to this ticket. If you aren`t using the multi language option you can ignore this.';
$msg_javascript127         = 'Do you wish to enable this field?';
$msg_javascript128         = 'Do you wish to enable or disable this response?';
$msg_javascript129         = 'Users in Dispute';
$msg_javascript130         = 'Specify dispute status. If "Locked" dispute cannot be re-opened by visitor.';
$msg_javascript131         = 'When you add this reply, do you want to add the reply as a standard response? If yes, response will be added to same category as dispute.';
$msg_javascript132         = 'Do you wish to send e-mail notification about this dispute reply? Notification is sent to all users in dispute.';
$msg_javascript133         = 'Do you want to merge this dispute with another one after the reply is added? If merged, reply is added to specified dispute and this dispute is deleted. All users applicable are notified if email is checked.<br /><br />Click box to launch dispute window. Note that disputes can only be merged with disputes with the SAME e-mail address as the original message.';
$msg_javascript134         = 'Do you wish to download a copy of this backup to your hard drive? This envokes the save-as dialogue box. If you set this as no and enter no e-mail addresses, this is default.';
$msg_javascript135         = 'Do you wish to compress the backup file? This is recommended for large databases.';
$msg_javascript136         = 'Do you want to copy the backup to other e-mail accounts? E-mail accounts should not be located on the same server. Add multiple e-mails if required separated with a comma.<br /><br /><b>SMTP must be enabled to send attachments. If its not this will be ignored.</b>';
$msg_javascript137         = 'Post privileges enabled';
$msg_javascript138         = 'Post privileges disabled';
$msg_javascript139         = 'Do you wish to disable the captcha on the ticket creation page if the user is logged into their ticket portal?';
$msg_javascript140         = 'Do you want to send email notification to the original ticket creator that this ticket is now officially a dispute?<br /><br />You`ll only need to send this once, but the checkbox is provided as a switch in case you wish to send notification each time a user is added.';
$msg_javascript141         = 'How many questions do you wish to display per page for a F.A.Q category?';
$msg_javascript142         = 'in dispute with';
$msg_javascript143         = '(No additional users added. View ticket to add users.)';
$msg_javascript144         = 'When date input form fields are clicked, a javascript calendar appears. When a date is clicked on the calendar, this transfers to the input box. Specify preferred date format.';
$msg_javascript145         = 'If enabled, user can action delete options on any page they have access to. If disabled, delete options are not available to user. Note that if the privileges are off, access to the System Tools page is auto disabled.<br /><br />Administrative user has this enabled by default regardless of settings as all admin features are always available.';
$msg_javascript146         = 'Please enter imap host, user, password and port..';
$msg_javascript147         = 'Error, cannot connect to mailbox. Check connection details or enter folder manually..';
$msg_javascript148         = 'Fatal Error: Imap functions NOT enabled on server.';
$msg_javascript149         = 'Enter new department name. Max 100 characters.';
$msg_javascript150         = 'When a visitor selects this department, do you want to auto populate the ticket subject field? If this is enabled and the department is changed more than once, existing data may be lost. Leave this field empty for no auto population.';
$msg_javascript151         = 'When a visitor selects this department, do you want to auto populate the ticket comments field? If this is enabled and the department is changed more than once, existing data may be lost. Leave this field empty for no auto population.';
$msg_javascript152         = 'From name visitor sees in their email program when this user replies to a ticket and notification is sent. Can be the same as name/alias or different.<br /><br />If left blank, defaults to name/alias.';
$msg_javascript153         = 'From email address visitor sees in their email program when this user replies to a ticket and notification is sent. Can be the same as login email or different.<br /><br />If left blank, defaults to login email. Note that if the ticket has been opened by imap, the reply address will always be the imap email address and not the admin user address.';
$msg_javascript154         = 'Password:';
$msg_javascript155         = 'Click "OK" to use this password or "Cancel" to generate another';
$msg_javascript156         = 'Please enter valid user login email address..';

?>