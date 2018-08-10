<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: lang3.php
  Description: English Language File Additions for v2.2

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

$msg_newticket46           = '[{website}] Support Ticket Closed';
$msg_newticket47           = 'Staff Assigned';

$msg_offline               = 'System Currently Offline';
$msg_offline2              = 'Our support system is currently offline.';
$msg_offline3              = 'Our support system is currently offline. It will return on {date}.';

$msg_pkbase20              = 'Sub Categories <span class="normal">({count})</span>';

$msg_adheader32            = 'Assign Tickets';
$msg_adheader33            = 'Attachments';
$msg_adheader34            = 'Reports';
$msg_adheader35            = 'Priority Levels';
$msg_adheader36            = 'Password Reset';

$msg_bbcode28              = 'Media Tags';
$msg_bbcode29              = 'Video Display';
$msg_bbcode30              = 'code here..';

$msg_dept22                = 'Manually Assign Tickets to Users';
$msg_dept23                = '(Manual Assign: {manual} &#8226; Visible: {visible})';

$msg_levels                = 'Add';
$msg_levels2               = 'Add New Level';
$msg_levels3               = 'Delete';
$msg_levels4               = 'Current Levels';
$msg_levels5               = 'Update Level';
$msg_levels6               = 'Edit';
$msg_levels7               = 'Priority Level Added';
$msg_levels8               = 'Update Order Display';
$msg_levels9               = 'Add new priority levels below. Note that the default priorities can be renamed, but not removed.';
$msg_levels10              = 'Update';
$msg_levels11              = 'Cancel';
$msg_levels12              = 'Priority Level Updated';
$msg_levels13              = 'Priority Level Deleted';
$msg_levels15              = 'Display on Open New Ticket Page';
$msg_levels16              = '(Visible: {visible} &#8226; XML RPC ID: {id})';
$msg_levels18              = 'Level Name';
$msg_levels19              = 'New Priority Level';
$msg_levels20              = 'Order Display Updated';

$msg_assign                = '<span class="highlight">#{ticket}</span> &#8226; Opened: <span class="highlight">{date}</span> &#8226; Priority: <span class="highlight">{priority}</span> &#8226; Dept: <span class="highlight">{dept}</span> &#8226; Replies: <span class="highlight">{replies}</span><span class="floatright"><a href="?p=view-ticket&amp;id={id}" onclick="window.open(this);return false" title="View Full Ticket">View Full Ticket</a></span>';
$msg_assign2               = '<span class="highlight"><b>{count}</b></span> ticket(s) awaiting assignment to user/staff. Use checkboxes to assign users. Note that further notifications are only sent to assigned users, so if you are the administrator and want to receive ticket reply notifications, you should always add yourself to the assigned list.';
$msg_assign3               = 'Assign To';
$msg_assign4               = '{count} ticket(s) assigned to users';
$msg_assign5               = 'E-mail notification to users';
$msg_assign6               = 'Assign Tickets to Users';

$msg_attachments           = 'Batch add F.A.Q attachments below. Once added they can be assigned to one or more questions. File can be local or remote.';
$msg_attachments2          = 'Add Attachments';
$msg_attachments3          = 'Display Name';
$msg_attachments4          = 'Remote File';
$msg_attachments5          = 'Browse for Local File';
$msg_attachments6          = 'Add Boxes';
$msg_attachments7          = 'Remove Boxes';
$msg_attachments8          = 'Current Attachments';
$msg_attachments9          = 'There are currently no F.A.Q attachments';
$msg_attachments10         = '{count} attachment(s) Added';
$msg_attachments11         = '[{type}, {size}, Assigned to {questions} question(s)]';
$msg_attachments12         = 'Update Attachment';
$msg_attachments13         = 'Attachment Updated';
$msg_attachments14         = 'Attachment Deleted';
$msg_attachments15         = 'Click to View/Close Attachments';

$msg_customfields31        = 'Apply to Department(s)';
$msg_customfields32        = 'All';

$msg_home46                = 'New Tickets to be Assigned';
$msg_home47                = 'New Disputes to be Assigned';
$msg_home48                = '<span class="highlight"><a href="?p=imap">{imap}</a></span> Imap Accounts';
$msg_home49                = '<span class="highlight"><a href="?p=fields">{fields}</a></span> Custom Fields';

$msg_kbase36               = 'Parent Category';
$msg_kbase37               = 'Sub Category Of';
$msg_kbase38               = 'Category Type';
$msg_kbase39               = 'Status';

$msg_messenger7            = '(Use {name} in message to personalise)';

$msg_open31                = 'Assigned to';

$msg_passreset             = 'Reset user login details below. Leave password fields blank to keep current password.';
$msg_passreset2            = 'E-Mail';
$msg_passreset3            = 'Password';
$msg_passreset4            = 'Update Login Details';
$msg_passreset5            = 'Click to show/hide password';
$msg_passreset6            = 'Login Details Updated';

$msg_reports               = 'Here you can view a report of the total tickets in the system. Use the filters available to filter information. Note that longer date ranges may take longer to load the information if you have lots of tickets.';
$msg_reports2              = 'From';
$msg_reports3              = 'To';
$msg_reports4              = 'by Day';
$msg_reports5              = 'by Month';
$msg_reports6              = 'Show';
$msg_reports7              = 'Date';
$msg_reports8              = 'Open Tickets';
$msg_reports9              = 'Closed Tickets';
$msg_reports10             = 'Open Disputes';
$msg_reports11             = 'Closed Disputes';
$msg_reports12             = 'Totals';
$msg_reports13             = 'There is currently no data for the specified time period';
$msg_reports14             = 'Export to CSV';

$msg_response18            = 'Last Updated';

$msg_settings70            = 'System Status';
$msg_settings71            = 'Enabled';
$msg_settings72            = 'Disabled';
$msg_settings73            = 'Auto Enable on Date';
$msg_settings74            = 'Help Desk Status';
$msg_settings75            = 'E-Mail Notification';
$msg_settings76            = 'Rename Attachments';

$msg_search14              = 'Batch Update Selected Tickets';
$msg_search15              = 'Department (No Change)';
$msg_search16              = '{count} ticket(s) updated';
$msg_search17              = 'Priority (No Change)';
$msg_search18              = 'Status (No Change)';

$msg_user69                = 'View Assigned Tickets ONLY';
$msg_user70                = 'Timezone';
$msg_user71                = 'All Privileges';
$msg_user72                = 'Notepad: {notepad} &#8226; Signature: {siggie} &#8226; Notification: {notify} &#8226; Assigned Only: {assigned} &#8226; Delete Privileges: {del}';

$msg_viewticket91          = '[{website}] Ticket(s) Assigned by {user}';
$msg_viewticket92          = 'Assigned To';
$msg_viewticket93          = 'Attach File';
$msg_viewticket94          = 'Not Yet Assigned';

$msg_portal46              = 'Set Timezone';
$msg_portal47              = 'Please Choose';

$msg_script40              = 'Auto Cron Completed';
$msg_script41              = 'Return to Previous Screen';
$msg_script42              = array('First','Previous','Next','Last'); // Pagination

$bb_code_buttons           = array(
                              'Image','E-Mail','Link','More..','Enter Image Url','Enter E-Mail Address','Enter Hyperlink',
                              'Enter YouTube Video Code','Enter Vimeo Video Code'
                             );

$msg_javascript157         = 'Is this category a parent category or a sub category of an existing parent?';
$msg_javascript158         = 'If this box is ticked, tickets are required to be assigned to users/staff after the tickets are created. Only the administrator receives an email and its his/her job to log in and assign the tickets.<br /><br />Tickets can be batch assigned for quickness and assigned to multiple users if required.';
$msg_javascript159         = 'Warning: If the assigned flag is removed and assigned tickets exist, they will revert to standard tickets viewable by department only.';
$msg_javascript160         = 'If set to yes, user can view only tickets assigned to them, regardless of department filter. As such, user is automatically assigned to all departments.';
$msg_javascript161         = 'Display name. If left blank, the file name itself will be displayed on the F.A.Q question page.';
$msg_javascript162         = 'If file is hosted remotely, enter http url to remote file.';
$msg_javascript163         = 'Locate file on hard drive. If you specify something in the remote file box, this is ignored.<br /><br />If updating, leave blank to keep same file.';
$msg_javascript164         = 'Enable or disable help desk system.';
$msg_javascript165         = 'If the system is disabled, do you wish to auto enable it on any given date?';
$msg_javascript166         = 'Specify which ticket departments the custom field will be available in when the department is selected on the create ticket page. If none are specified it will be shown for ALL departments.';
$msg_javascript167         = 'Specify the timezone for this user, if different from the system timezone in settings.';
$msg_javascript168         = 'Do you wish to rename attachments on upload? Can resolve issues where invalid characters are used in file names.';
$msg_javascript169         = 'Do you want this priority level to display on the ticket creation page? If unchecked, does not display in priority level list for visitors. Useful for internal purposes.';
$msg_javascript170         = 'Enter new priority level name? Max 100 chars.';

?>