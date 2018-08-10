<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  This File: lang1.php
  Description: English Language File

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

/*---------------------------------------------
  CHARACTER SET
  For encoding HTML characters
  Unless specified in language file,
   this may not need altering.
----------------------------------------------*/


$msg_charset               = 'iso-8859-1';
$msg_pipe_charset          = 'utf-8';
$mail_charset              = 'iso-8859-1';


/*-------------------------------
  TEMPLATES/HEADER.TPL.PHP
---------------------------------*/


$msg_header                = '{website}';
$msg_header2               = 'Logout';
$msg_header3               = 'My Account';
$msg_header4               = 'Search Tickets';
$msg_header5               = 'Enter Keywords or Ticket ID';


/*-------------------------------
  TEMPLATES/MAIN-DISPLAY.TPL.PHP
---------------------------------*/


$msg_main                  = 'Account Login - View Existing Tickets';
$msg_main2                 = 'Open New Support Ticket';
$msg_main3                 = 'E-Mail Address';
$msg_main4                 = 'Password';
$msg_main5                 = 'View Tickets';
$msg_main6                 = 'Continue';
$msg_main7                 = 'Invalid E-Mail..Please Try Again..';
$msg_main8                 = 'No Account Found..Please Try Again..';
$msg_main9                 = 'Forgot Password? Click Here';
$msg_main10                = 'Most Popular {count} Questions';
$msg_main11                = 'View';
$msg_main12                = '[{website}] Your New Password';
$msg_main13                = 'Invalid E-Mail Address..Try Again..';
$msg_main14                = 'No Account Found..Try Again..';
$msg_main15                = 'Your new ticket has been created';


/*----------------------------------
  TEMPLATES/FAQ.TPL.PHP
------------------------------------*/


$msg_pkbase                = 'Search F.A.Q';
$msg_pkbase2               = 'Enter Keywords';
$msg_pkbase3               = 'Search';
$msg_pkbase4               = 'Categories <span class="normal">({count})</span>';
$msg_pkbase5               = 'Most Popular {count} Questions';
$msg_pkbase6               = 'Search Results <span class="normal">({count})</span>';
$msg_pkbase7               = 'All Categories';
$msg_pkbase8               = 'No entries found in F.A.Q.';
$msg_pkbase9               = 'No results found for search: <b>{search}</b>';
$msg_pkbase10              = 'No categories found in F.A.Q.';
$msg_pkbase11              = 'Date Added: {date}';
$msg_pkbase12              = 'Did you find this article helpful?';
$msg_pkbase13              = 'Article Help?';
$msg_pkbase14              = '';
$msg_pkbase15              = '';
$msg_pkbase16              = 'Close Search Help';
$msg_pkbase17              = 'Add to Favourites';
$msg_pkbase18              = 'Print Article';


/*--------------------------
  TEMPLATES/PORTAL.TPL.PHP
----------------------------*/


$msg_portal                = 'Your Account';
$msg_portal2               = 'Ticket Status &amp; Updates';
$msg_portal3               = 'Update Password';
$msg_portal4               = 'Enter New Password (Min {min} Chars)';
$msg_portal5               = 'Welcome to your support ticket portal.<br /><br />Your existing support tickets/disputes are shown below.<br /><br />Please use the links on the right to change your account e-mail address or password. We recommend you
                              change your password from time to time for security. If you wish tickets to display in your own timezone, use the link above to set your current timezone.<br /><br />Any problems, please contact us. Thank you.';
$msg_portal6               = 'Open Tickets / Disputes';
$msg_portal7               = 'You currently have 0 tickets to display. Previous tickets may have been deleted.';
$msg_portal8               = 'View Ticket';
$msg_portal9               = 'Opened';
$msg_portal10              = 'Priority';
$msg_portal11              = 'Department';
$msg_portal12              = 'Status';
$msg_portal13              = 'My Tickets';
$msg_portal14              = 'Password Too Short..Min {min} Chars..';
$msg_portal15              = 'Ticket Closed';
$msg_portal16              = 'Open New Ticket';
$msg_portal17              = 'Search Results';
$msg_portal18              = 'Your new ticket has been created and is shown below.<br /><br />You currently have <span class="highlight"><b>{open}</b></span> open tickets.<br /><br /><a href="?p=portal" title="Continue">Continue</a>..';
$msg_portal19              = 'Replies';
$msg_portal20              = 'Search Results ({count})';
$msg_portal21              = 'Your search generated 0 results.';
$msg_portal22              = 'Password Updated';
$msg_portal23              = '';


/*---------------------------------
  TEMPLATES/CREATE-TICKET.TPL.PHP
-----------------------------------*/


$msg_newticket             = 'Open New Ticket';
$msg_newticket2            = 'Please use the form below to open a new support ticket. Required fields are marked with a *.<br /><br /><span class="highlight">Note that a password will be assigned to you if this is your first ticket. This can be changed later if required.</span>';
$msg_newticket3            = 'Your Name';
$msg_newticket4            = 'E-Mail Address';
$msg_newticket5            = 'Comments';
$msg_newticket6            = 'Department';
$msg_newticket7            = 'Comments';
$msg_newticket8            = 'Priority';
$msg_newticket9            = 'Low';
$msg_newticket10           = 'Medium';
$msg_newticket11           = 'High';
$msg_newticket12           = 'Open Support Ticket';
$msg_newticket13           = 'Open New Ticket';
$msg_newticket14           = 'Attachment(s)';
$msg_newticket15           = 'Subject';
$msg_newticket16           = 'Please include your name...';
$msg_newticket17           = 'Please include a valid e-mail address...';
$msg_newticket18           = 'Please include a subject heading...';
$msg_newticket19           = 'Please include some comments...';
$msg_newticket20           = 'One or more attachment files too big..Check and try again...';
$msg_newticket21           = 'One or more attachment files invalid file type..Check and try again...';
$msg_newticket22           = '[#{ticket}] New Support Ticket';
$msg_newticket23           = '[#{ticket}] New Support Ticket';
$msg_newticket24           = 'Security sum incorrect. Please try again...';
$msg_newticket25           = '(Max: {limit})';
$msg_newticket26           = 'For Spam Prevention, please complete the following:';
$msg_newticket27           = 'Please select a department..';
$msg_newticket28           = 'Invalid Priority..Check and try again..';
$msg_newticket29           = 'New Support Ticket';
$msg_newticket30           = 'Please use the form below to open a new support ticket. Required fields are marked with a *.';


/*------------------------------
  TEMPLATES/VIEW-TICKET.TPL.PHP
--------------------------------*/


$msg_showticket            = 'Details';
$msg_showticket2           = 'No Ticket Found';
$msg_showticket3           = 'There are currently 0 replies to this ticket. A member of staff will respond as soon as possible.';
$msg_showticket4           = 'Viewing Ticket: #{ticket}';
$msg_showticket5           = 'Close Ticket - Do you wish to close this ticket after this response?';
$msg_showticket6           = 'Attach Another File';
$msg_showticket7           = 'Your response has been added. A further response will follow shortly.';
$msg_showticket8           = 'Response Added, Thank you';
$msg_showticket9           = 'Name';
$msg_showticket10          = 'E-Mail';
$msg_showticket11          = 'Department';
$msg_showticket12          = 'Ticket Date/Time';
$msg_showticket13          = 'IP Address';
$msg_showticket14          = 'Status';
$msg_showticket15          = 'Details';
$msg_showticket16          = 'Priority';
$msg_showticket17          = 'Add Reply';
$msg_showticket18          = 'Ticket ID';
$msg_showticket19          = '#{ticket}';
$msg_showticket20          = 'This ticket currently has 0 replies.';
$msg_showticket21          = 'Reply by';
$msg_showticket22          = '{count} attachment(s)';
$msg_showticket23          = 'Open';
$msg_showticket24          = 'Closed';
$msg_showticket25          = '[#{ticket}] Support Ticket Updated';
$msg_showticket26          = 'Add Reply &amp; Re-Open Ticket';
$msg_showticket27          = 'This dispute currently has 0 replies.';


/*----------------------------
  ADMIN & CONTROL/HEADER.PHP
------------------------------*/


$msg_adheader              = 'Administration';
$msg_adheader2             = 'Settings';
$msg_adheader3             = 'Departments';
$msg_adheader4             = 'Users';
$msg_adheader5             = 'Open Tickets';
$msg_adheader6             = 'Closed Tickets';
$msg_adheader7             = 'Search Tickets';
$msg_adheader8             = 'Questions & Answers';
$msg_adheader9             = 'Purchase Full Version';
$msg_adheader10            = 'Logout';
$msg_adheader11            = 'Dashboard';
$msg_adheader12            = 'Help';
$msg_adheader13            = 'Standard Responses';
$msg_adheader14            = 'Tickets';
$msg_adheader15            = 'Tools';
$msg_adheader16            = 'Categories';
$msg_adheader17            = 'F.A.Q';
$msg_adheader18            = 'System Tools';
$msg_adheader19            = 'Import Options';
$msg_adheader20            = 'Entry Log';
$msg_adheader21            = 'Portal Options';
$msg_adheader22            = 'No Access';
$msg_adheader23            = 'Send Message to Other Users';


/*-------------------------
  ADMINISTRATION LANG
--------------------------*/


$msg_dept                  = 'Add';
$msg_dept2                 = 'Add New Department';
$msg_dept3                 = 'Delete';
$msg_dept4                 = 'Current Departments';
$msg_dept5                 = 'Update Department';
$msg_dept6                 = 'Edit';
$msg_dept7                 = 'Department Added';
$msg_dept8                 = 'There are currently 0 departments in the database.';
$msg_dept9                 = 'Assign different departments to your ticket system. Examples: Technical Support, Billing, Sales etc etc.. Departments can appear on the ticket creation page, or be used for internal use/imap departments only via the checkbox option. Use the pre-populate options to auto populate ticket subject/comments.';
$msg_dept10                = 'Update';
$msg_dept11                = 'Cancel';
$msg_dept12                = 'Department Updated';
$msg_dept13                = 'Department Deleted';

$msg_home                  = '';
$msg_home2                 = 'System Overview';
$msg_home3                 = 'Ticket Overview';
$msg_home4                 = 'New Tickets (No Replies)';
$msg_home5                 = 'Open Tickets (Awaiting Admin)';
$msg_home6                 = 'Open Tickets (Awaiting Visitor)';
$msg_home7                 = 'Closed Tickets';
$msg_home8                 = '<span class="highlight"><a href="?p=users">{users}</a></span> Users &amp; <span class="highlight"><a href="?p=dept">{dept}</a></span> Departments';
$msg_home9                 = '<span class="highlight"><a href="?p=standard-responses">{responses}</a></span> Standard Responses';
$msg_home10                = '<span class="highlight"><a href="?p=faq">{questions}</a></span> FAQ, <span class="highlight"><a href="?p=faq-cat">{cats}</a></span> Categories, <span class="highlight"><a href="?p=attachments">{attachments}</a></span> Attachments';
$msg_home11                = 'Error - You do not have permission to view the selected page.';
$msg_home12                = 'Ticket Statistics (ALL)';
$msg_home13                = 'Last 7 Days';
$msg_home14                = 'Last {count} Weeks';
$msg_home15                = 'Last Month';
$msg_home16                = 'Last {count} Months';
$msg_home17                = 'Last Year';
$msg_home18                = 'Filter';
$msg_home19                = 'All';
$msg_home20                = 'There is no ticket data to display';
$msg_home21                = 'Tickets';
$msg_home22                = 'Replies';
$msg_home23                = 'WARNING! Please remove or rename the \'install\' directory. This is a major security risk. (<a href="#" onclick="jQuery(\'#ew_1\').hide(\'slow\');return false" style="color:#fff">Close</a>)';
$msg_home24                = 'MESSAGE! Don`t forget to update the \'ENABLE_MYSQL_ERRORS\' option in the "control/connect.inc.php" file to disable showing MySQL errors.
                              You should always disable this and show a default message when the system is live. This message is a kindly reminder and will disappear once the option is updated. (<a href="#" onclick="jQuery(\'#ew_3\').hide(\'slow\');return false" style="color:#fff">Close</a>)';
$msg_home25                = 'MESSAGE! You should rename the SECRET_KEY value in the "control/connect.inc.php" file. This message is a kindly reminder and will disappear once the option is updated. (<a href="#" onclick="jQuery(\'#ew_2\').hide(\'slow\');return false" style="color:#fff">Close</a>)';

$msg_kbasecats             = 'Category Added';
$msg_kbasecats2            = 'Add New Category';
$msg_kbasecats3            = 'Delete';
$msg_kbasecats4            = 'Current Categories';
$msg_kbasecats5            = 'Update Category';
$msg_kbasecats6            = 'Edit';
$msg_kbasecats7            = 'Category Updated';
$msg_kbasecats8            = 'There are currently 0 categories in the database.';
$msg_kbasecats9            = 'F.A.Q questions/answers are grouped into categories. Manage categories below.<br /><br /><b>NOTE:</b> Deleting category also removes all questions from that category.';
$msg_kbasecats10           = 'Update';
$msg_kbasecats11           = 'Cancel';
$msg_kbasecats12           = 'Category Deleted';

$msg_kbase                 = 'Question';
$msg_kbase2                = 'Answer';
$msg_kbase3                = 'Add New Question';
$msg_kbase4                = 'Current Questions';
$msg_kbase5                = 'Category';
$msg_kbase6                = 'All Categories';
$msg_kbase7                = 'Question Added';
$msg_kbase8                = 'Question Updated';
$msg_kbase9                = 'There are currently 0 questions/answers in the F.A.Q.';
$msg_kbase10               = 'Question Deleted';
$msg_kbase12               = 'Preview';
$msg_kbase13               = 'Update Question';
$msg_kbase14               = 'Here you can add some frequently asked questions into the system and group them into the various <a href="?p=faq-cat">categories</a>. Users can see the F.A.Q on the main ticket page and see if their question has already been answered.<br /><br />Enable the F.A.Q in the <a href="?p=settings">settings</a>. You can <a href="?p=import">batch add</a> F.A.Q entries for quickness. Use BB Code for formatting if enabled.';
$msg_kbase15               = 'Summary';
$msg_kbase16               = 'Add Category';
$msg_kbase17               = 'Category Name';
$msg_kbase18               = '{count} Vote(s) - {cat} - ({helpful}% Helpful, {nothelpful}% Not Helpful)';
$msg_kbase19               = 'Reset Counts';
$msg_kbase20               = 'Reset ALL Counts';
$msg_kbase21               = 'Selected Counts Reset';
$msg_kbase22               = 'Selected Counts Reset';
$msg_kbase23               = '(In Category: {category})';

$msg_log                   = 'Here you can view your admin entry log. This logs an entry each time a user logs into the system. To export or clear a specific user only, filter first, then click links.';
$msg_log2                  = 'Clear Log';
$msg_log3                  = 'Export Log';
$msg_log4                  = 'There are currently 0 entries in the log.';
$msg_log5                  = 'Log File Cleared';

$msg_messenger             = 'Use the box below to send an e-mail to all selected users of the support team. Users with notification off are not shown.';
$msg_messenger2            = 'Send Message';
$msg_messenger3            = 'Copy Message to: &quot;<b>{email}</b>&quot;';
$msg_messenger4            = 'Message Sent';
$msg_messenger5            = 'Message from Support Team: {user}';
$msg_messenger6            = '[Copy] Message from Support Team: {user}';

$msg_response              = 'Title';
$msg_response2             = 'Answer';
$msg_response3             = 'Add New Response';
$msg_response4             = 'Current Responses';
$msg_response5             = 'Department';
$msg_response6             = 'All Departments';
$msg_response7             = 'Response Added';
$msg_response8             = 'Response Updated';
$msg_response9             = 'There are currently 0 standard responses in the database.';
$msg_response10            = 'Response Deleted';
$msg_response12            = 'Preview';
$msg_response13            = 'Update Response';
$msg_response14            = 'Standard responses are a huge time saving option enabling you to store pre-defined responses. When answering a ticket, rather than typing the same messages, you can select a standard response. Standard responses can
                              be available for ALL departments or allocated to individual ones only if required.<br /><br />Use BB code for formatting if enabled.';
$msg_response15            = '(In Department: {dept})';

$msg_systemportal          = 'Enter E-Mail Address';
$msg_systemportal2         = 'Enter New Password';
$msg_systemportal3         = 'Reset Portal Password';
$msg_systemportal4         = 'Here you can reset passwords for visitors, move visitor tickets from one e-mail account to another, export data or enable/disable login access. If you move tickets to another e-mail account, the source account will be removed and all tickets will be associated with the new address. E-mail addresses must exist in the system and cannot be random.';
$msg_systemportal5         = 'Send E-Mail';
$msg_systemportal6         = 'Move Tickets to Another E-Mail Account';
$msg_systemportal7         = 'Enter E-Mail Address - Source';
$msg_systemportal8         = 'Enter E-Mail Address - Destination';
$msg_systemportal9         = 'Update';
$msg_systemportal10        = 'Move';
$msg_systemportal11        = 'Password Reset';
$msg_systemportal12        = 'E-Mail Address Not Found..';
$msg_systemportal13        = '{count} Tickets Moved';
$msg_systemportal14        = '[{website}] Your Tickets Have Been Moved';
$msg_systemportal15        = 'Export Portal Data to CSV';
$msg_systemportal16        = 'Export Name';
$msg_systemportal17        = 'Export E-Mail Address';
$msg_systemportal18        = 'Export';

$msg_import                = 'Batch Import Standard Responses';
$msg_import2               = 'Batch Import F.A.Q Entries';
$msg_import3               = 'Here you have a couple of batch routines that enable you to get the system up and running much faster. Files must be CSV format and formatted correctly. See example files below for more help.';
$msg_import4               = 'Clear Existing';
$msg_import5               = 'Locate CSV File';
$msg_import6               = 'Lines to Read';
$msg_import7               = 'Delimited by';
$msg_import8               = 'Enclosed by';
$msg_import9               = 'Import Standard Responses';
$msg_import10              = 'Categories';
$msg_import11              = 'Import F.A.Q Entries';
$msg_import12              = 'All Categories';
$msg_import13              = '{count} Standard Responses Imported';
$msg_import14              = '{count} F.A.Q Entries Imported';
$msg_import15              = 'Example CSV';

$msg_login                 = 'Administration Login';
$msg_login2                = 'Password';
$msg_login3                = 'Remember Me?';
$msg_login4                = 'No account found...please try again..';
$msg_login5                = 'Enter';
$msg_login6                = 'Please enter your valid email..';
$msg_login7                = 'Please enter your password..';
$msg_login8                = 'E-Mail Address';

$msg_merge                 = 'Select Parent Ticket - Click Icon to Load';
$msg_merge2                = 'Click to Select New Parent Ticket';

$msg_open                  = '<span class="highlight"><b>{count}</b></span> open ticket(s). Click icon to view ticket.';
$msg_open2                 = 'All Departments';
$msg_open3                 = 'All Statuses &amp; Priority Levels';
$msg_open4                 = 'Low Priority';
$msg_open5                 = 'Medium Priority';
$msg_open6                 = 'High Priority';
$msg_open7                 = 'View Ticket';
$msg_open8                 = '<span class="highlight">#{ticket}</span> &#8226; Opened: <span class="highlight">{date}</span> &#8226; Priority: <span class="highlight">{priority}</span> &#8226; Dept: <span class="highlight">{dept}</span> &#8226; Replies: <span class="highlight">{replies}</span><span class="floatright"><span class="highlight">{status}</span></span>';
$msg_open9                 = 'From';
$msg_open10                = 'There are currently no tickets to display.';
$msg_open11                = 'Open - Awaiting Admin Response';
$msg_open12                = 'Open - Awaiting Visitor Response';
$msg_open13                = 'Closed &amp; Resolved';
$msg_open14                = 'Permanently Closed &amp; Resolved';
$msg_open15                = 'Delete Selected Tickets';
$msg_open16                = 'Selected Ticket(s) Deleted';
$msg_open17                = '<span class="highlight"><b>{count}</b></span> closed ticket(s). Closed tickets must be re-opened to add new replies.';
$msg_open18                = 'Check All';
$msg_open19                = 'Re-Open';
$msg_open20                = 'Ticket Re-Opened';
$msg_open21                = 'Selected Tickets Deleted';

$msg_search                = 'Search your tickets below. At least one field must be specified.';
$msg_search2               = 'Search Tickets';
$msg_search3               = 'Keywords or Ticket ID';
$msg_search4               = 'Department';
$msg_search5               = 'Priority';
$msg_search6               = 'Search Results';
$msg_search7               = 'Date From/To';
$msg_search8               = 'Ticket Status';
$msg_search9               = 'Please specify some search parameters..';
$msg_search10              = 'No results found for the specified search parameters.';
$msg_search11              = 'Ticket Type';

$msg_settings              = 'Enable F.A.Q';
$msg_settings2             = 'PHP Date/Time Format';
$msg_settings3             = 'Enable Attachments';
$msg_settings4             = 'Allowable File Extensions';
$msg_settings5             = 'Max Size for Attachments';
$msg_settings6             = 'Software Language';
$msg_settings7             = 'Update Settings';
$msg_settings8             = 'Settings Updated';
$msg_settings9             = 'Help Desk Name';
$msg_settings10            = 'These are the program settings. Update them to suit your preferences. Hover your cursor over the help tips for assistance.';
$msg_settings12            = 'Timezone';
$msg_settings13            = 'Auto Close Tickets';
$msg_settings14            = 'Days';
$msg_settings15            = 'Enable SMTP';
$msg_settings16            = 'SMTP Host';
$msg_settings17            = 'SMTP Username';
$msg_settings18            = 'SMTP Password';
$msg_settings19            = 'SMTP Port';
$msg_settings20            = 'HTTP Installation Path';
$msg_settings21            = 'E-Mail \'From\' Address';
$msg_settings22            = 'General Settings';
$msg_settings23            = 'Ticket Attachments';
$msg_settings24            = 'SMTP Settings';
$msg_settings25            = 'Total Attachment Boxes';
$msg_settings26            = 'MySQL Date Format';
$msg_settings27            = 'Server Path to Attachments Folder';
$msg_settings28            = 'Auto Create Hyperlinks';
$msg_settings29            = 'Frequently Asked Questions';
$msg_settings30            = 'Admin Folder Name';
$msg_settings31            = 'Portal Tickets Per Page';
$msg_settings32            = 'Enable Multiple Votes';
$msg_settings33            = 'Total Popular Questions';
$msg_settings34            = 'Cookie Duration (in Days)';
$msg_settings36            = 'Show Calculator';
$msg_settings53            = 'hours';
$msg_settings54            = 'Admin Footer';
$msg_settings55            = 'Public Footer';
$msg_settings56            = 'Edit Footers';
$msg_settings57            = 'Enable Voting System';

$msg_tools                 = 'This feature enables you to purge certain data from the system that is a certain amount of days old. This can be useful if you have lots of data and need to do a clean up. Note that this action is irreversible.';
$msg_tools2                = 'Purge Closed Tickets/Disputes X Days Old';
$msg_tools3                = 'Days Old';
$msg_tools4                = 'Purge';
$msg_tools5                = 'Clear Attachments';
$msg_tools6                = 'Clear ticket attachments only X days old';
$msg_tools7                = 'Department';
$msg_tools8                = '{count} Ticket(s), {count2} Reply/Replies, {count3} Attachment(s) Deleted';
$msg_tools9                = '{count} Attachment(s) Deleted';
$msg_tools10               = 'All Departments';

$msg_user                  = 'Name/Alias';
$msg_user2                 = 'Add New User';
$msg_user3                 = 'Current Users';
$msg_user4                 = 'Login E-Mail Address';
$msg_user5                 = 'Department Access';
$msg_user6                 = 'User Added';
$msg_user7                 = 'Name';
$msg_user8                 = 'Department';
$msg_user9                 = 'E-Mail';
$msg_user10                = 'User Details';
$msg_user11                = 'There are currently 0 users in the database.';
$msg_user12                = 'Login Password';
$msg_user13                = 'User Deleted';
$msg_user14                = 'Update User';
$msg_user15                = 'User Updated';
$msg_user16                = 'Cancel';
$msg_user17                = 'Signature (Optional)';
$msg_user18                = 'E-Mail Notification';
$msg_user19                = 'Signature';
$msg_user20                = 'Notification';
$msg_user21                = 'Users are members of your support team (or staff/operators). The administrative user cannot be deleted and automatically has full site access. This user cannot be modified by anyone else. You should be careful when allowing users access to certain areas of the admin area.';
$msg_user22                = 'There are no replies by this user';
$msg_user23                = 'Total Responses';
$msg_user24                = 'Admin Page Access';
$msg_user25                = 'View All Responses';
$msg_user26                = 'ALL Departments (Default)';
$msg_user27                = 'ALL Pages (Default)';
$msg_user28                = 'Date Added';
$msg_user29                = 'View Ticket';
$msg_user30                = 'Ticket';
$msg_user31                = 'View Graph';
$msg_user32                = 'Reply stats for';
$msg_user33                = 'by';
$msg_user34                = 'Responses';
$msg_user35                = 'Total Replies';
$msg_user36                = 'User Statistics';
$msg_user37                = 'Last Reply';
$msg_user38                = 'Last Login';
$msg_user39                = 'Change';
$msg_user40                = 'Administrator';
$msg_user41                = 'Enable Notifications';
$msg_user42                = 'Disable Notifications';
$msg_user43                = 'Selected E-Mail Notifications Enabled';
$msg_user44                = 'Selected E-Mail Notifications Disabled';

$msg_viewticket            = 'Viewing Ticket: #{ticket}';
$msg_viewticket2           = 'Name';
$msg_viewticket3           = 'E-Mail';
$msg_viewticket4           = 'Department';
$msg_viewticket5           = 'Ticket Date/Time';
$msg_viewticket6           = 'IP Address';
$msg_viewticket7           = 'Status';
$msg_viewticket8           = 'Details';
$msg_viewticket9           = 'Priority';
$msg_viewticket10          = 'Ticket: <b>#{ticket}</b>';
$msg_viewticket11          = 'Add Reply';
$msg_viewticket12          = 'Standard Responses';
$msg_viewticket13          = 'Add New Reply';
$msg_viewticket14          = 'Open';
$msg_viewticket15          = 'Closed';
$msg_viewticket16          = 'Locked';
$msg_viewticket17          = 'Status';
$msg_viewticket18          = 'Send Mail';
$msg_viewticket19          = 'Merge With Ticket #';
$msg_viewticket20          = 'Edit Ticket #{ticket}';
$msg_viewticket21          = 'Update Ticket';
$msg_viewticket22          = 'Comments';
$msg_viewticket23          = 'Ticket Updated';
$msg_viewticket24          = 'Already Exists in System';
$msg_viewticket25          = 'Subject';
$msg_viewticket26          = 'Open';
$msg_viewticket27          = 'Close';
$msg_viewticket28          = 'Lock';
$msg_viewticket29          = 'Viewing {count} Attachment(s): #{ticket}';
$msg_viewticket30          = 'Delete All';
$msg_viewticket31          = 'This ticket has 0 attachments.';
$msg_viewticket32          = 'File &amp; Type';
$msg_viewticket33          = 'Size';
$msg_viewticket34          = 'Delete Selected Attachments';
$msg_viewticket35          = 'Add Response';
$msg_viewticket36          = 'Edit Ticket Reply: #{ticket}';
$msg_viewticket37          = 'Update Ticket Reply';
$msg_viewticket38          = 'Reply Updated';
$msg_viewticket39          = 'There are currently 0 replies to this ticket.';
$msg_viewticket40          = 'View Attachments';
$msg_viewticket41          = '{count} Attachment(s)';
$msg_viewticket42          = 'Reply by';
$msg_viewticket43          = 'Unknown';
$msg_viewticket44          = 'This reply has 0 attachments.';
$msg_viewticket45          = 'This ticket is currently closed. Please re-open to add reply.';
$msg_viewticket46          = 'Ticket Reply Deleted';
$msg_viewticket47          = 'Ticket Reply Added';
$msg_viewticket48          = 'Ticket Merged &amp; Reply Added';
$msg_viewticket49          = '[#{ticket}] Support Ticket Updated';
$msg_viewticket50          = 'Download';
$msg_viewticket51          = 'Describe this Change for Other Users';
$msg_viewticket52          = '[#{ticket}] Ticket Admin Edit Notification';
$msg_viewticket53          = 'You do not have permission to view this ticket as it appears to be in a department you don`t have access to.<br /><br />This message usually appears affter a ticket
                              has been updated and moved to a department allocated to other support members and then a further update is attempted.<br /><br />Once a ticket has been moved, you no longer have access to it.';


/*-----------------
  GENERAL VARIABLES
------------------*/


$msg_script                = SCRIPT_NAME;
$msg_script2               = '';
$msg_script3               = 'Powered by';
$msg_script4               = 'Yes';
$msg_script5               = 'No';
$msg_script6               = '404 - Page Not Found';
$msg_script7               = 'Optional';
$msg_script8               = 'Delete';
$msg_script9               = 'Edit';
$msg_script10              = 'View';
$msg_script11              = 'Pages';
$msg_script12              = 'All Rights Reserved';
$msg_script13              = 'Printer Friendly Version';
$msg_script14              = 'Print';
$msg_script15              = 'Close';
$msg_script16              = 'Forbidden: You do not have permission to view this page';
$msg_script17              = 'N/A';
$msg_script18              = 'Powered by';
$msg_script19              = 'Bytes';
$msg_script20              = 'Get Adobe Flash Player';
$msg_script21              = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$msg_script22              = 'Free Version Restriction';


/*----------------------
  EMAIL PIPING
-----------------------*/


$msg_piping                = 'Are Connection Parameters Correct?';
$msg_piping2               = 'Is Username/Password valid?';
$msg_piping3               = 'Are flags set correctly? Contact host if not sure.';
$msg_piping4               = 'Have you specified correct protocol?';
$msg_piping5               = 'This function is not enabled';
$msg_piping6               = '[No Subject]';
$msg_piping7               = 'Sent via E-Mail';
$msg_piping8               = 'Cron Run @ {datetime}.<br /><br />{count} New Tickets Opened.<br />{count2} Replies Added.<br />{count3} Attachment(s) Saved.';
$msg_piping9               = 'Server Imap Error';


/*-----------------------------------------------------------------------------------------------------
  JAVASCRIPT VARIABLES
  IMPORTANT: If you want to use apostrophes in these variables, you MUST escape them with 3 backslashes
             Failure to do this will result in the script malfunctioning on javascript code.
  EXAMPLE: d\\\'apostrophe

  Double quotes can be used with no problems
------------------------------------------------------------------------------------------------------*/


$msg_javascript            = 'Confirm Action..\n\nAre you sure?';
$msg_javascript2           = 'Logout and terminate session..\n\nAre you sure?';
$msg_javascript3           = 'Preview';
$msg_javascript4           = 'Help';
$msg_javascript5           = 'The name of your website or ticket system. Max 150 chars.';
$msg_javascript6           = 'E-mail "From" address that appears when any e-mails are sent. This may need to be a valid e-mail on some servers.';
$msg_javascript7           = 'Full HTTP path to your ticket installation. The system would have attempted to create this on install. NO slash at the end.<br /><br /><b>Example</b>:<br />http://www.yoursite.com/tickets';
$msg_javascript8           = 'Select software language.';
$msg_javascript9           = 'Preferred PHP date/time format. If you are unsure of this leave it as it is. Click the heading to be taken to the PHP website for more information.';
$msg_javascript10          = '';
$msg_javascript11          = 'Do you wish to enable the frequently asked questions?';
$msg_javascript13          = 'Do you want the system to auto close tickets/disputes that are awaiting a visitor reply, but haven`t been replied to for X amount of days? Set to 0 to disable or enter amount in days. Example: 50<br /><br />Check notification box to send email notification to visitor. If a dispute is open, notification is sent to everyone in the dispute.';
$msg_javascript14          = 'Default timezone as supported by PHP5`s <a href="http://php.net/manual/en/function.date-default-timezone-set.php" onclick="window.open(this);return false">date_default_timezone_set</a> function. Edit timezones in "control/timezones.php" if required.<br /><br />Legacy support is included for PHP4.';
$msg_javascript15          = 'Do you want to enable attachments so visitors can include files with their tickets? Note that disabling this feature does not disable attachments for admin responses. This section also does not affect FAQ attachments.';
$msg_javascript16          = 'If enabled, specify allowed file extensions. This must be the extension (including period or dot) separated with a pipe. Enter as many as you need. Extensions are NOT case sensitive.<br /><br /><b>Examples</b>:<br />.jpg|.zip|.rar<br />.Jpg|.ZIP|.RaR<br /><br />Leave blank for no restrictions (NOT recommended).';
$msg_javascript17          = 'Maximum file size for attachments. In Bytes.<br /><br /><b>Examples</b>:<br />1024*1024 = 1048576 = 1MB (You enter 1048576)<br />1024*200 = 204800 = 200KB (You enter 204800)<br /><br />Set to 0 for no limit or use the calculator for help.';
$msg_javascript18          = 'Total attachment boxes to display on ticket page. For example, if you entered 5, visitor could include a maximum of 5 attachments per ticket. Restricted to 1 box in the free version.';
$msg_javascript19          = 'Do you wish to enable SMTP to send e-mails? Some servers restrict the PHP function sending to addresses outside of the domain, so this is required.<br /><br />Some servers require authentication via username/password.';
$msg_javascript20          = 'Enter SMTP host. This can be your server IP, localhost or mail server address.<br /><br /><b>Examples</b>:<br />localhost<br />mail.yoursite.com<br />smtp.yoursite.com<br />127.0.0.1';
$msg_javascript21          = 'Enter SMTP username if required. This is usually your e-mail address.';
$msg_javascript22          = 'Enter SMTP mail password if required.';
$msg_javascript23          = 'Enter SMTP port number. Usually 25 or 26. Can also be your submission port, ie: 587. If you are unsure, contact your host.';
$msg_javascript24          = 'Enter F.A.Q question.';
$msg_javascript25          = 'Specify which category this question applies to. Can be ALL categories or specific category.';
$msg_javascript26          = 'Enter F.A.Q answer. For formatting options, use the available BB code if enabled. HTML is not allowed.';
$msg_javascript27          = 'Enter support members name or user alias.';
$msg_javascript28          = 'If a user has access to department tickets, they can view all tickets in that department and will be notified when tickets are opened in that department for departments where manual assign is not enabled.<br /><br />If a user has access to assigned tickets only, they can ONLY view ticket(s) assigned to them, regardless of department.<br /><br />The administrator can always view all tickets regardless of this setting.';
$msg_javascript29          = 'Specify which admin pages this user has access to. This can restrict user from accessing certain administration content.<br /><br /><b>WARNING</b>! If user has access to an admin page, he/she has access to all features on that page. Unlike the departments, users are NOT added to all pages by default if none are selected as a security precaution.<br /><br />Administration user has access to all pages regardless of selections.';
$msg_javascript30          = 'Enter log in e-mail address. This is also the e-mail address ticket notification is sent to.';
$msg_javascript31          = 'Enter login password. The use of special characters is recommended for more difficult passwords. ie: []()*/<br /><br />Use the auto create option to help generate a secure password. When editing, leave blank to keep same password.';
$msg_javascript32          = 'Do you wish to enable e-mail notification for this user if tickets are opened or replied to?';
$msg_javascript33          = 'Enter user signature. This is optional. If entered, automatically appears at the bottom of all replies made by this user. HTML may be used here if required.<br /><br />Line breaks are auto parsed unless disabled in:<br /><b>control/user-defined/defined2.inc.php</b>';
$msg_javascript34          = 'Enter title for standard response. This is to easily identify this response.';
$msg_javascript35          = 'Specify which departments this response applies to. Can be ALL departments or specific department. When viewing tickets, reponses only applicable to all or individual department will be shown.';
$msg_javascript36          = 'Enter standard response answer. For formatting options, use the available BBCode if enabled. HTML is not allowed.';
$msg_javascript37          = 'Enter amount of days old tickets must be before being purged. For example, if you enter 180, all tickets up to 180 days old will be deleted from the system.';
$msg_javascript38          = 'Specify which department(s) to purge. Tickets can be purged from ALL departments or just specific ones. Use the checkboxes to select departments.';
$msg_javascript39          = 'When purging tickets, do you want to clear any attachments associated with these tickets?';
$msg_javascript40          = 'Enter amount of days old attachments must be before being purged. For example, if you enter 180, all attachments up to 180 days old will be deleted from the system.';
$msg_javascript41          = 'Specify which department to purge. Attachments can be purged from ALL departments or just specific ones. Use the checkboxes to select departments.';
$msg_javascript42          = 'Enter';
$msg_javascript43          = 'Get New Password';
$msg_javascript44          = 'Select Ticket';
$msg_javascript45          = 'Specify ticket status. If "Locked" ticket cannot be re-opened by visitor.';
$msg_javascript46          = 'Do you wish to send e-mail notification about this ticket reply?';
$msg_javascript47          = 'Do you want to merge this ticket with another one after the reply is added? If merged, reply is added to specified ticket and this ticket is deleted.<br /><br />Click box to launch ticket window. Note that tickets can only be merged with tickets with the SAME e-mail address.';
$msg_javascript48          = 'These are quick links. Click link to open, close or lock ticket. If locked, visitor cannot re-open ticket. No e-mails are sent with these options.';
$msg_javascript49          = 'Enter e-mail address of visitor. Once you start typing suggestions will appear. This helps to locate e-mails faster.';
$msg_javascript50          = 'Enter new password for visitor. A simple password is recommended for reset, so visitors can update their password if they choose to a more secure one. Use the auto create option to generate simple or secure passwords.';
$msg_javascript51          = 'Do you want to send e-mail to visitor to let them know of this change?';
$msg_javascript52          = 'Enter source e-mail address. Once you start typing suggestions will appear. This helps to locate e-mails faster.';
$msg_javascript53          = 'Enter destination e-mail address. Once you start typing suggestions will appear. This helps to locate e-mails faster.';
$msg_javascript54          = 'Full server path to your attachments directory. The system will have attempted to complete this on install. NO slash at the end. If you are unsure of your server path, contact your host.<br /><br /><b>Examples</b>:<br />/home/server/public_html/tickets/templates/attachments<br />C:\\\windows\\\path\\\tickets\\\templates\\\attachments';
$msg_javascript55          = 'Specify new F.A.Q category name. Max 100 chars.';
$msg_javascript56          = 'Enter summary for this category. For example, if your category was called "Billing", your summary might be "Articles Related to Billing" etc<br /><br />Max 250 chars.';
$msg_javascript57          = 'Do you wish to enable BBCode? BBCode or Bulletin Board Code is a lightweight markup language used to format data. The available tags are usually indicated by square brackets ([]) surrounding a keyword, and are parsed before being translated into a markup language that web browsers understand. Examples:<br /><br />[b]Bold Text[b] = <b>Bold Text</b><br />[link=http://www.google.co.uk]Google[/link] = <a href="http://www.google.co.uk">Google</a><br /><br />BBCode was devised to provide a safer, easier and more limited way of allowing users to format their messages.<br /><br />Text &copy;Wikipedia';
$msg_javascript58          = 'Thanks for Voting';
$msg_javascript59          = 'Invalid email address..';
$msg_javascript60          = 'No account found, please check email..';
$msg_javascript61          = 'Thank you, please check your inbox at "{email}"';
$msg_javascript62          = 'Enter keyword(s) or ticket ID. This field searches comments, name and e-mail if keyword and id field if numeric. For ticket ID enter full ticket number or short number. ie: 000456 OR 456';
$msg_javascript63          = 'Both from and to dates must be specified for date filter. Click in date field to launch the date picker.';
$msg_javascript64          = 'For security you should rename your admin folder. If you rename it, specify the new name here. Folder name should NOT contain invalid characters. Alphanumeric, hyphens and underscores are recommended.';
$msg_javascript65          = 'How many tickets to show per page for visitors in their ticket portal? Must be at least 1.';
$msg_javascript66          = 'The F.A.Q main page shows the most popular questions. This is determined by most votes, not visits. How many popular questions do you want to show?';
$msg_javascript67          = 'The voting system enables a webmaster to see if questions have been helpul or not. Do you want visitors to be able to vote multiple times? This is fairly pointless, but can be enabled if required.';
$msg_javascript68          = 'If multiple votes aren`t allowed, a cookie is set. Specify the duration IN DAYS before this cookie expires.';
$msg_javascript69          = 'Please enter a number first..';
$msg_javascript70          = 'Locate CSV file. Any file extension should work providing the formatting is correct within the file. Click the example file to see how the CSV file must be formatted.';
$msg_javascript71          = 'Set the field delimiter. If left blank delimiter defaults to a comma.';
$msg_javascript72          = 'Set the field enclosure character. Fields are enclosed if the delimiter is found in the string to prevent premature end of delimiter. Example on comma delimited string:<br /><br /><b>0,1,"The delimiter is , a comma",2,3</b><br /><br />If left blank defaults to quotes (").';
$msg_javascript73          = 'Choose department for import.';
$msg_javascript74          = 'Choose category for import.';
$msg_javascript75          = 'Must be greater than the longest line (in characters) to be found in the CSV file (allowing for trailing line-end characters).<br /><br />It became optional in PHP 5. Omitting this parameter (or setting it to 0 in PHP 5.0.4 and later) the maximum line length is not limited, which is slightly slower.<br /><br /><b>NO</b> commas or period symbols. Examples: 1000, 2000, 3000 etc<br /><br />Text &copy;PHP.net';
$msg_javascript76          = 'When you run this import, do you want to clear existing responses already in the system for the selected department?<br /><br /><b>WARNING! THIS IS NOT REVERSIBLE!!</b>';
$msg_javascript77          = 'When you run this import, do you want to clear existing F.A.Q entries already in the system for the selected category?<br /><br /><b>WARNING! THIS IS NOT REVERSIBLE!!</b>';
$msg_javascript78          = 'When you add this reply, do you want to add the reply as a standard response? If yes, response will be added to same category as ticket.';
$msg_javascript79          = 'Check the "Remember Me" box to stay logged in for 30 days. Note, this is <b>NOT</b> recommended for shared computers and cookies must be enabled';
$msg_javascript80          = 'Do you wish to enable this imap account?';
$msg_javascript81          = 'Imap and Pop3 protocols are supported. Specify your preference. Imap is recommended.';
$msg_javascript82          = 'Enter mailbox host or IP address. Examples:<br /><br />localhost<br />mail.yoursite.com<br />127.0.0.1';
$msg_javascript83          = 'Enter mailbox username. Usually e-mail address, but varies from server to server.';
$msg_javascript84          = 'Enter mailbox password.';
$msg_javascript85          = 'Enter mailbox port number. Usually 110 for pop3 or 143 for imap. Check with your host.';
$msg_javascript86          = 'Enter name of mailbox. A common example would be "inbox". Specifying an invalid name will prevent the system from working. Use the "Show Folders" option to display mailbox folders.';
$msg_javascript87          = 'If applicable, enter mailbox flag. Click the heading to be taken to the PHP website for more information. Entering invalid flag or omitting required flag will cause the system to fail when fetching mail.<br /><br />Flag must begin with a slash (/). It is recommended the flag "/novalidate-cert" be used in most cases.<br /><br />If you aren`t sure, leave as is. <b>Note this works ONLY with imap accounts</b>';
$msg_javascript88          = 'If tickets are started via email, do you want to accept attachments? If yes, the attachment restrictions on settings page apply.<br /><br />It is vitally important you have virus/spam filtering on the mail box you are using for e-mail fetching.';
$msg_javascript89          = 'After the message has been read, do you wish to archive the message in another folder? This can be any folder within your mailbox, including custom folders or Trash/Deleted Items. Sub folders should be concatenated with a dot or period symbol, ie: Inbox.Sent.<br /><br />Use the "Show Folders" option to display mailbox folders.<br /><br />If left blank, message is deleted without archiving (if you find this isn`t the case, you must add a folder to move the messages to. This will prevent duplicate tickets).<br /><br /><b>Note the move option works ONLY with imap accounts</b>';
$msg_javascript90          = 'How many messages do you want to fetch each time the mailbox is accessed? Max 999.';
$msg_javascript91          = 'Are you connecting to the mailbox using ssl?';
$msg_javascript92          = 'Specify which department is to be assigned to tickets opened via e-mail. Department must be created first.';
$msg_javascript93          = 'Specify the default priority level for tickets started via e-mail.';
$msg_javascript94          = 'Enter your own admin footer data. This will replace the default admin footer. This option is available when a licence has been paid. HTML may be used here if required.';
$msg_javascript95          = 'Enter your own front end (public) footer data. This will replace the default public footer. This option is available when a licence has been paid. HTML may be used here if required.';
$msg_javascript96          = 'Please enter title for new response..';
$msg_javascript97          = 'My New Response';
$msg_javascript98          = 'Enter text to describe the edit you have made. This is optional and is included in the edit email notification sent to other ticket users if applicable.';
$msg_javascript99          = 'Do you wish to enable the voting system? This is useful for admin to see which questions have proved useful and which haven`t. Enable or disable depending on your preference.';
$msg_javascript100         = 'Do you wish to include the persons name in the export? This will be determined by the first ticket opened.';
$msg_javascript101         = 'Do you wish to include the portal e-mail address in the export?';
$msg_javascript102         = 'This is your reply to e-mail address for imap messages. If set to same as mailbox thats being read, this enables visitors to reply directly in their email software back to the imap account. If this happens, the system will attempt to assign the reply to the same ticket.<br /><br />Set to another e-mail not to have replies sent to imap address.';
$msg_javascript103         = 'If you update this ticket to a department you don`t have access to, you will no longer be able to see this ticket. In this case you might want to use the notification option below to inform support members who do have access to new destination department.';

?>