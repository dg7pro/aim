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

function ms_addTags(tags,type,text,box) {
  switch (type) {
    // Bold, italic & underline..
    case 'bold':
    case 'italic':
    case 'underline':
    ms_insertAtCursor(box,tags);
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
      ms_insertAtCursor(box,'['+type+']'+bx+'[/'+type+']');
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

function closeAttachments(id) {
  $('#h2A').css({'background-image':'none','border-top':'none'});
  $('#signal').html('[+]');
  $('#h2A').attr('onclick','showFAQAttachments('+id+')');
  $('#attach-display').slideUp('slow',function(){$('#attach-display').html('')});
}

function showFAQAttachments(id) {
  $('#h2A').css('background','#f6f6f6 url(templates/images/indicator.gif) no-repeat 95% 50%');
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=faq&loadAttachments='+id,
      dataType: 'html',
      success: function (data) {
        $('#h2A').css({'background-image':'none','border-top':'1px dashed #d7d7d7'});
        $('#signal').html('[-]');
        $('#h2A').attr('onclick','closeAttachments('+id+')');
        $('#attach-display').html(data);
        $('#attach-display').slideDown('slow');
      },
      complete: function () {
      },
      error: function(xml,status,error) {
      }
    });
  });
  return false;
}

function faqAttachBox(action) {
  var n = $('#faqAttachArea .doubleWrapper').length;
  switch (action) {
    case 'add':
    var html = $('#faqAttachArea .doubleWrapper').last().clone();
    $('#faqAttachArea .doubleWrapper').last().after(html);
    $('#faqAttachArea .doubleWrapper input[name="name[]"]').last().val('');
    $('#faqAttachArea .doubleWrapper input[name="remote[]"]').last().val('');
    $('#faqAttachArea .doubleWrapper input[name="file[]"]').last().val('');
    break;
    case 'remove':
    if (n>1) {
      $('#faqAttachArea .doubleWrapper').last().remove();
    }
    break;
  }
}

function ms_previewTicket(id) {
  $('#subject_'+id).css('background','url(templates/images/loading.gif) no-repeat 75% 50%');
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=open&loadTicketMessage='+id,
      dataType: 'html',
      success: function (data) {
        $('#subject_'+id).css('background-image','none');
        $('#preview_msg_'+id).html(data);
        $('#preview_'+id).show('slow');
      },
      complete: function () {
      },
      error: function(xml,status,error) {
      }
    });
  });
  return false; 
}

function ms_autoComplete(box) {
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=portal&autoComplete='+box,
      dataType: 'html',
      success: function (data) {
        if (data!='none') {
          $('#'+box).autocomplete({
		        source: data.split(',')
	        });
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

function ms_insertMailBox(value,type) {
  switch(type) {
    case 'mailbox':
    $('#im_name').val(value);
    $('#nameFolders').hide('slow');
    break;
    case 'move':
    $('#im_move').val(value);
    $('#moveFolders').hide('slow');
    break;
  }
}

function ms_imapOptions(protocol) {
  switch(protocol) {
    case 'pop3':
    $('.showFolders').hide();
    $('#im_move').attr('disabled','disabled');
    $('#im_flags').attr('disabled','disabled');
    $('#im_port').val('110');
    $('#nameFolders').html('');
    $('#nameFolders').hide();
    break;
    case 'imap':
    $('.showFolders').show();
    $('#im_move').removeAttr('disabled');
    $('#im_flags').removeAttr('disabled');
    $('#im_port').val('143');
    $('#moveFolders').html('');
    $('#moveFolders').hide();
    break;
  }
}

function folderCheck() {
  return ($('#im_host').val()!='' && $('#im_user').val()!='' && $('#im_pass').val()!='' && $('#im_port').val()!='' ? true : false);
}

function ms_showImapFolders(loc) {
  $(document).ready(function() {
    $.post('index.php?p=imap&showImapFolders='+loc, { 
      host: $('#im_host').val(),
      user: $('#im_user').val(),
      pass: $('#im_pass').val(),
      port: $('#im_port').val(),
      flags: $('#im_flags').val()
    }, 
    function(data) {
      if (data) {
        if (data.substring(0,4)=='####') {
          alert(data);
        } else {
          switch(loc) {
            case 'mailbox':
            $('#nameFolders').html(data);
            $('#nameFolders').show('slow');
            break;
            case 'move':
            $('#moveFolders').html(data);
            $('#moveFolders').show('slow');
            break;
          }
        }
      }
    }); 
  });  
  return false
}

function ms_enPostPriv(id,user) {
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=view-ticket&id='+id+'&ppriv='+user,
      dataType: 'html',
      success: function (data) {
        var split = data.split('#####');
        switch (split[0]) {
          case 'yes':
          if (user>0) {
            $('#ou_'+user).removeClass('user_no').addClass('user_yes');
          } else {
            $('#oru').removeClass('user_no').addClass('user_yes');
          }
          break;
          case 'no':
          if (user>0) {
            $('#ou_'+user).removeClass('user_yes').addClass('user_no');
          } else {
            $('#oru').removeClass('user_yes').addClass('user_no');
          }
          break;
        }
        alert(split[1]);
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

function ms_generateAPIKey() {
  $('#apiKey').css('background','url(templates/images/indicator.gif) no-repeat 98% 50%');
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=settings&genKey=yes',
      dataType: 'html',
      success: function (data) {
        $('#apiKey').css('background-image','none');
        $('#apiKey').val(data);
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

function checkUserEmail(txt) {
  if (!mswIsValidEmailAddress($('#email').val())) {
    alert(txt);
    return false;
  }
}

function mswIsValidEmailAddress(addy) {
  var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
  return pattern.test(addy);
}


function ms_removeDisputeUser(id) {
  if (id==2) {
    $('#name_2').hide('slow').html('');
    $('#on_1').show();
  } else {
    $('#name_'+id).hide('slow').html('');
    $('#on_'+parseInt(id-1)).show();
    $('#off_'+parseInt(id-1)).show();
  }
  return false;
}

function ms_addDisputeUser(id) {
  $('#on_'+id).hide();
  $('#off_'+id).hide();
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=view-ticket&addDisputeBox='+id,
      dataType: 'html',
      success: function (data) {
        $('#name_'+id).after(data).show('slow');
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

function ms_ticketPreview(url,field) {
  $(document).ready(function() {
    $.post('index.php?p='+url+'&previewMsg=yes', { 
      msg: $('#'+field).val() 
    }, 
    function(data) {
      var string = data.split('|||||');
       $.GB_hide();
       $.GB_show('index.php?p=view-ticket&previewMsg=yes', {
         height: 500,
         width: 900,
         close_text: string[1]
       });
    }); 
  });  
  return false
}

function ms_updateTicketNotes(ticket) {
  $('#notes').css('background','url(templates/images/loading.gif) no-repeat 50% 50%');
  $(document).ready(function() {
   $.ajax({
    type: 'POST',
    url: 'index.php?p=view-ticket&ticketNotes='+ticket,
    data: $("#notesWrapper > form").serialize(),
    cache: false,
    dataType: 'html',
    success: function (data) {
      $('#notes').css('background-image','none');
      if (data!='no-notes-trigger') {
        $('#sysAction').html('<p><span><a href="#" onclick="$(\'#sysAction\').hide(\'slow\');return false">X</a></span>'+data+'</p>');
        $('#sysAction').slideDown('slow');
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

function ms_updateAssignedUsers(ticket) {
  $('#assignWrapper').css('background','#fff url(templates/images/loading.gif) no-repeat 50% 50%');
  $(document).ready(function() {
   $.ajax({
    type: 'POST',
    url: 'index.php?p=view-ticket&ticketAssigned='+ticket,
    data: $("#assignWrapper > form").serialize(),
    cache: false,
    dataType: 'html',
    success: function (data) {
      $('#assignWrapper').css('background-image','none');
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

function getStandardResponse() {
  $('#comments').css('background','url(templates/images/loading.gif) no-repeat 50% 50%');
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=standard-responses&getResponse='+$('#response').val(),
      dataType: 'html',
      success: function (data) {
        $('#comments').css('background-image','none');
        $('#comments').val(data);
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

// Read xml..
function xmlTag(xml,tag) {
  return $(xml).find(tag).text();
}

// Auto pass..
function mswgenerateAutoPass() {
  var letters  = ($('#letters:checked').val()!==undefined ? 'yes' : 'no'); 
  var letters2 = ($('#letters2:checked').val()!==undefined ? 'yes' : 'no'); 
  var numbers  = ($('#numbers:checked').val()!==undefined ? 'yes' : 'no'); 
  var special  = ($('#special:checked').val()!==undefined ? 'yes' : 'no'); 
  var chars    = $('#chars').val();
  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=users&autoPass='+letters+'|'+letters2+'|'+numbers+'|'+special+'|'+chars,
      dataType: 'html',
      success: function (data) {
        var chop = data.split('#####');
        var confirmSub = confirm(chop[1]);
        if (confirmSub) { 
          $('#accpass').val(chop[0]);
          $('#pass').show('slow');
          $('#passOptions').hide();
        } else {
          return false;
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

// Add/remove attachment boxes..
function ms_attachBox(type,max) {
  switch (type) {
    case 'add':
    var n = $('.attachBoxes span').length;
    if (n<max) {
      $('.attachBoxes').append('<span class="bx"><input type="file" class="box" name="attachment[]" /><\/span>').show();
    }
    break;
    case 'remove':
    var n = $('.attachBoxes span').length;
    if (n>1) {
      $('.attachBoxes span').last().remove();
    }
    break;
  }
}

// Calculator Functions..
function loadCalculator(keyStr) {
  var resultsField = document.getElementById('maxsize');
  if (keyStr=='x') {
    keyStr = '*';
  }
  switch (keyStr) {
    case '0':
    case '1':
    case '2':
    case '3':
    case '4':
    case '5':
    case '6':
    case '7':
    case '8':
    case '9':
    case '0':
    case '.':
    if ((this.lastOp==this.opClear) || (this.lastOp==this.opOperator)) {
      resultsField.value = keyStr;
    } else {
      if ((keyStr!=".") || (resultsField.value.indexOf(".")<0)) {
        resultsField.value += keyStr;
      }
    }
    this.lastOp = this.opNumber;
    break;
    case '*':
    case '/':
    case '+':
    case '-':
    if (this.lastOp==this.opNumber) {
      this.Calc();
      this.evalStr += resultsField.value + keyStr;
      this.lastOp   = this.opOperator;
    }
    break;
    case '=':
    this.Calc();
    this.lastOp = this.opClear;
    break;
    case 'c':
    resultsField.value  = '0';
    this.lastOp         = this.opClear;
    break;
  }
}

function Calculator_Calc() {
  var resultsField    = document.getElementById('maxsize');
  resultsField.value  = eval(this.evalStr+resultsField.value);
  this.evalStr        = '';
}

function Calculator() {
  this.evalStr     = '';
  this.opNumber    = 0;
  this.opOperator  = 1;
  this.opClear     = 2;
  this.lastOp      = this.opClear;
  this.OnClick     = loadCalculator;
  this.Calc        = Calculator_Calc;
}

function addResponseBox(txt,txt2,txt3,res_current,res_allowed,version) {
  if (document.getElementById('r1').checked==true) {
    if (parseInt(res_current)>=parseInt(res_allowed) && version=='locked') {
      document.getElementById('r1').checked=false;
      document.getElementById('r2').checked=true;
      alert(txt3);
    } else {
      var name = prompt(txt,txt2);
      if (name!=null && name!='') {
        document.getElementById('prompt').innerHTML = '<input type="hidden" name="response_title" value="'+name+'" />';
        return true;
      } else {
        return false;
      }
    }
  }
}

// Check questions..
function checkBoxes(type,id) {
  switch (type) {
    case 'on':
    $("#"+id+" input:checkbox").each(function() {
      $(this).attr('checked', 'checked');
    });
    break;
    case 'off':
    $("#"+id+" input:checkbox").each(function() {
      $(this).removeAttr('checked');
    });
    break;
  }
}

// Departments/pages..
function selectAllBoxes(which,status) {
  switch (which) {
    case 'dept':
    switch (status) {
      case 'on':
      $("#deptboxes input:checkbox").each(function() {
        $(this).attr('checked', 'checked');
      });
      break;
      case 'off':
      $("#deptboxes input:checkbox").each(function() {
        $(this).removeAttr('checked');
      });
      break;
    }
    break;
    case 'pages':
    switch (status) {
      case 'on':
      $("#pageboxes input:checkbox").each(function() {
        $(this).attr('checked', 'checked');
      });
      break;
      case 'off':
      $("#pageboxes input:checkbox").each(function() {
        $(this).removeAttr('checked');
      });
      break;
    }
    break;
  }
}

// Check/uncheck array of checkboxes..
function selectAll(which) {
  for (var i=0;i<document.forms[''+which+''].elements.length;i++) {
    var e = document.forms[''+which+''].elements[i];
    if ((e.name != 'log') && (e.type=='checkbox') && (e.name != 'clear')) {
      e.checked = document.forms[''+which+''].log.checked;
    }
  }
}

// Scroll to..
function scrollToArea(divArea) {
  $('html, body').animate({
    scrollTop: $('#'+divArea).offset().top
  }, 2000);
}

// Select custom boxes..
function selectAllCustomBoxes(id,state) {
  switch (state) {
    case 'on':
    $("#"+id+" input:checkbox").each(function() {
      $(this).attr('checked', 'checked');
    });
    break;
    case 'off':
    $("#"+id+" input:checkbox").each(function() {
      $(this).removeAttr('checked');
    });
    break;
  }
}

// Confirm message..
function confirmMessage(txt) {
  var confirmSub = confirm(txt);
  if (confirmSub) { 
    return true;
  } else {
    return false;
  }
}

// Toggle div
function toggle_box(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'none')
  e.style.display = 'block';
  else
  e.style.display = 'none';
}