//===================================================
//
// Script: Maian Support
// Written by: David Ian Bennett
// E-Mail: support@maianscriptworld.co.uk
// Website: http://www.maianscriptworld.co.uk
// Javascript Functions
//
// Incorporating jQuery functions
// Copyright (c) John Resig
// http://jquery.com/
//
//==================================================

// BB Code Tag Handling
function ms_addTags(tags,type,text) {
  switch (type) {
    // Bold, italic & underline..
    case 'bold':
    case 'italic':
    case 'underline':
    ms_insertAtCursor('comments',tags);
    break;
    // Other..
    case 'url':
    case 'img':
    case 'email':
    case 'youtube':
    case 'vimeo':
    var bx = prompt(text+':',(type!='email' && type!='youtube' && type!='vimeo' ? 'http://' : ''));
    if (bx=='' || bx=='http://' || bx==null || bx==' ') {
      return false;
    } else {
      ms_insertAtCursor('comments','['+type+']'+bx+'[/'+type+']');
    }
    break;
  }
}

// With thanks to Scott Klarr
// http://www.scottklarr.com
function ms_insertAtCursor(field,text) {
  var txtarea   = document.getElementById(field); 
  var scrollPos = txtarea.scrollTop; 
  var strPos    = 0; 
  var br        = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 'ff' : (document.selection ? 'ie' : false));
  if (br=='ie') { 
    txtarea.focus(); 
    var range = document.selection.createRange(); 
    range.moveStart ('character', -txtarea.value.length); 
    strPos    = range.text.length; 
  }
  if (br=='ff') {
    strPos      = txtarea.selectionStart; 
  }
  var front     = (txtarea.value).substring(0,strPos); 
  var back      = (txtarea.value).substring(strPos,txtarea.value.length); 
  txtarea.value = front+text+back; 
  strPos        = strPos+text.length; 
  if (br=='ie') { 
    txtarea.focus(); 
    var range = document.selection.createRange(); 
    range.moveStart('character', -txtarea.value.length); 
    range.moveStart('character', strPos); 
    range.moveEnd('character', 0); 
    range.select();
  }
  if (br=='ff') { 
    txtarea.selectionStart = strPos; 
    txtarea.selectionEnd   = strPos; 
    txtarea.focus(); 
  } 
  txtarea.scrollTop = scrollPos;
}

// Set timezone..
function ms_SetTimezone(value) {
  jQuery(document).ready(function() {
   jQuery.ajax({
    url: 'index.php',
    data: 'p=portal&setTS='+value,
    dataType: 'html',
    success: function (data) {
      jQuery('.timezones').slideUp('slow');
    },
    complete: function () {
    },
    error: function(xml,status,error) {
    }
   });
  });
  return false;
}

// Pre-populate data based on department..
// Custom fields & default subject/comments..
function deptLoader(dept,posted) {
  jQuery(document).ready(function() {
    jQuery.ajax({
      url: 'index.php',
      data: 'p=ticket&prePopulation='+dept+'&postSent='+posted,
      dataType: 'json',
      success: function (data) {
        // Subject..
        if (data[0]!='none') {
          jQuery('#subject').val(data[0]);
        }
        // Comments..
        if (data[1]!='none') {
          jQuery('#comments').val(data[1]);
        }
        // Custom fields..
        if (data[2]) {
          jQuery('#customFieldsWrapper').html(data[2]);
        }
      },
      complete: function () {
      },
      error: function(xml,status,error) {
      }
    });
  });
  return false;   
}

// Update password..
function ms_updatePass() {
  if (jQuery('#upass').val()=='') {
    jQuery('#upass').focus();
    return false;
  }
  jQuery(document).ready(function() {
    jQuery.post('index.php?p=portal', { 
      pass: jQuery('#upass').val() 
    }, 
    function(data) {
      var string = data.split('#####');
      if (string[0]=='error') {
        jQuery('#upass').after('<span class="error" id="eError">'+string[1]+'</span>').show('slow');
      } else {
        alert(string[1]);
        jQuery('#upass').val('');
        jQuery('#passArea').hide('slow');
        jQuery('#mainDisplay').show('slow');
      }
    }); 
  }); 
  return false; 
}

// Preview ticket message..
function ms_ticketPreview(url,field) {
  jQuery(document).ready(function() {
    jQuery.post('index.php?p='+url+'&previewMsg=yes', { 
      msg: jQuery('#'+field).val() 
    }, 
    function(data) {
      var string = data.split('|||||');
       jQuery.GB_hide();
       jQuery.GB_show('index.php?p='+url+'&previewMsg=yes', {
         height: 500,
         width: 900,
         close_text: string[1]
       });
    }); 
  });  
  return false
}

// Update email.
function ms_updateEmail() {
  if (jQuery('#uemail').val()=='') {
    jQuery('#uemail').focus();
    return false;
  }
  jQuery(document).ready(function() {
    jQuery.post('index.php?p=portal', { 
      portemail: jQuery('#uemail').val() 
    }, 
    function(data) {
      var string = data.split('#####');
      if (string[0]=='error') {
        jQuery('#uemail').after('<span class="error" id="eError">'+string[1]+'</span>').show('slow');
      } else {
        alert(string[1]);
        jQuery('#logged_in_email').html(jQuery('#uemail').val());
        jQuery('#uemail').val('');
        jQuery('#emailArea').hide('slow');
        jQuery('#mainDisplay').show('slow');
      }
    }); 
  }); 
  return false;
}

// Add/remove attachment boxes..
function ms_attachBox(type,max) {
  switch (type) {
    case 'add':
    jQuery('#e_attach').hide('slow');
    var n = jQuery('.attachBoxes span').length;
    if (n<max) {
      jQuery('.attachBoxes').append('<span class="attachBox"><input class="filebox" type="file" name="attachment[]" /><\/span> ').show();
    }
    break;
    case 'remove':
    var n = jQuery('.attachBoxes span').length;
    if (n>1) {
      jQuery('.attachBoxes span').last().remove();
    }
    break;
  }
  jQuery('#acount').html(jQuery('.attachBoxes span').length);
}

// Apply vote..
function addVote(id,vote) {
  jQuery('#loading').html('<img src="templates/images/loading.gif" alt="" title="" /> ');
  jQuery(document).ready(function() {
    jQuery.ajax({
      url: 'index.php',
      data: 'v='+id+'&vote='+vote,
      dataType: 'json',
      success: function (data) {
        jQuery('#loading').html('&nbsp;');
        jQuery('#voting').html('<span class="voting" id="voting"><span class="voted">'+data[4]+'</span> - <span class="yes">'+data[2]+'</span> ('+data[0]+'%) <span class="no">'+data[3]+'</span> ('+data[1]+'%)</span>');
      },
      complete: function () {
      },
      error: function(xml,status,error) {
        // alert('Data Returned: '+xml+'\n\nStatus: '+status+'\n\nError: '+error);
      }
    });
  });
  return false;   
}

// Show/hide email/pass boxes..
function showHideBoxes(which) {
  switch (which) {
    case 'show-pass':
    jQuery('#mainDisplay').hide('slow');
    jQuery('#passArea').show('slow');
    break;
    case 'show-email':
    jQuery('#mainDisplay').hide('slow');
    jQuery('#emailArea').show('slow');
    break;
    case 'close-pass':
    jQuery('#passArea').hide('slow');
    jQuery('#mainDisplay').show('slow');
    jQuery('#eError').hide();
    jQuery('#upass').val('')
    break;
    case 'close-email':
    jQuery('#emailArea').hide('slow');
    jQuery('#mainDisplay').show('slow');
    jQuery('#eError').hide();
    jQuery('#uemail').val('')
    break;
  }
}

// Scroll to reply..
function scrollToReply() {
  setInterval(function() {
    jQuery('html, body').animate({
      scrollTop: jQuery('#replyBoxWrapper').offset().top
    }, 2000);
  });
}

// Send new password..
function sendNewPassword() {
  if (jQuery('#email').val()=='') {
    jQuery('#email').focus();
    return false;
  }
  jQuery(document).ready(function() {
    jQuery.ajax({
      url: 'index.php',
      data: 'np='+jQuery('#email').val(),
      dataType: 'html',
      success: function (data) {
        var string = data.split('#####');
        if (string[0]=='error') {
          jQuery('#email').after('<span class="error" id="eError">'+string[1]+'</span>').show('slow');
        } else {
          alert(string[1]);
          jQuery('#upass').val('');
          toggleBoxes('off');
          jQuery('#upass').focus();
        }
      },
      complete: function () {
      },
      error: function(xml,status,error) {
        // alert('Data Returned: '+xml+'\n\nStatus: '+status+'\n\nError: '+error);
      }
    });
  });
  return false;   
}

// Toggle for new password..
function toggleBoxes(status) {
  switch (status) {
    case 'on':
    jQuery('#viewTickets').hide();
    jQuery('#pbox').hide();
    jQuery('#newPass').show('slow');
    jQuery('#email').focus();
    break;
    case 'off':
    jQuery('#newPass').hide();
    jQuery('#viewTickets').show('slow');
    jQuery('#eError').hide();
    jQuery('#pError').hide();
    jQuery('#pbox').show('slow');
    break;
  }
}

// BB Code help window..
function ms_bbCodeHelp(url) {
  jQuery.GB_hide();
  jQuery.GB_show(url, {
    height: 550,
    width: 900,
    caption: ''
  });
  return false;
}

// Select custom boxes..
function selectAllCustomBoxes(id,state) {
  switch (state) {
    case 'on':
    jQuery("#"+id+" input:checkbox").each(function() {
      jQuery(this).attr('checked', 'checked');
    });
    break;
    case 'off':
    jQuery("#"+id+" input:checkbox").each(function() {
      jQuery(this).removeAttr('checked');
    });
    break;
  }
}

// Add to faves..
function addBookmark(article,page) {
  if (window.sidebar) {
    window.sidebar.addPanel(article,page,"");
  } else if( document.all ) {
    window.external.AddFavorite(page,article);
  } else if( window.opera && window.print ) {
    alert('Your browser doesn`t support this feature, sorry. Use the standard bookmarking option in your browser.');
  } else {
    alert('Your browser doesn`t support this feature, sorry. Use the standard bookmarking option in your browser.');
  }
}