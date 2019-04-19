<html>
<head>
<link href="css/style.css?v7.0" rel="stylesheet">
<script src="https://code.jquery.com/jquery-2.0.3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css" rel="stylesheet" />

<style>
.select2-container .select2-selection--multiple .select2-selection__rendered {
  min-height: 17px;
  max-height: 150px;
  overflow-y: auto !important;
}

.select2-selection__choice{
  background-color: #5A79BC !important;
  color: #ffffff;
}

.select2-results__option--highlighted{
  background-color: #5A79BC !important;
  color: #ffffff;
}

#hidden{
  visibility: collapse;
}

.plus::before{
  content: "+ " !important;
}

.minus::before{
  content: "- ";
}

* {
  margin-left: 5px;
}

</style>


</head>
<body>
<?php 
  if ($message != ""){
    echo "<b>$message</b>";
  }
?>

<h1> Expiration Alerts. </h1>
<form method="POST" action="alertexpire.php">
<p>Set alerts for license expiration warnings. The <u>email recipient</u> will receive an alert email based on <u>warning period</u> before license expiration.</p>

<b>Email Recipient</b><br>
<input  id="emailrecip" name="emailrecip" type="email" value="" maxlength="255" required><br><br>

<b>Warning Period (Days)</b><br>
<input  min=1 max=365 name="days" type="number" value="30" required><br><br>

<b>Licenses</b><br>
<input name="licenseSelect[]" type="text" id="licenseSelect" style="width:300px"/><br><br>
<input type="submit" name="add" value="Submit">
</form>
<?php
$array = array("Daily"=>"Daily","Weekly"=>"Weekly");
?>
<h2>Email Alert Time Interval</h2>
<form method="POST" action="alertexpire.php">
    <p style="font-style:italic">NOTE: This setting applies to all Email Recipients</p>
    <select name="alerttime">
     <?php foreach($array as $key => $value)  {
                                           echo "<option value='$value'";
                                              if($alerttime == $value){
                                                  echo "selected";
                                              }
                                                 echo ">$key</option>";
                                        }?>
</select>
      <input type="submit" name="updateTimeInterval" value="Update" ><br>
</form><br>
   

<h3><font color="FF0000"> <?php
if (!isset($_REQUEST['delete'])) {
	if (isset($_REQUEST['emailrecip'])){
		if (!filter_var($emailrecip, FILTER_VALIDATE_EMAIL)) {
			print "ERROR: incorrect email format, Please correct Email Address: ".$emailrecip."<br>";
		}
	}
}
?>	</font></h3>
<p>	
<hr>

<h2>Current Expiration Alerts</h2>
<form method="GET" id="submitMe" name="submitMe" >
    <!-- input type="hidden" id="nm" name="nm" value=""/ -->
</form>            
<?php 
$compare = "";
foreach ($saved as $row){
  $rowColor = ($rowColor == "odd" ? "even": "odd");
  $email = $row['emailrecip'];
  $emailId = str_replace("@","-", $email);
  $emailId = str_replace(".", "-", $emailId);

  if (strcmp($compare, $email) != 0){
      echo ($compare != null ? "</table><br>" : "");
      echo("<table style='width: 550px'><tr><th onclick='showTable(\"$emailId\");\$( this ).toggleClass(\"plus\");' style='cursor: pointer; text-align: left' colspan=4 class='minus'>". $row['emailrecip'] ."</th><th><input style='text-align:right;' type='checkbox' class='select_each'/></th></tr>");
      echo("<tr class='$emailId'><th>Multiple Delete</th><th>Tag Name</th><th>Warning Period (Days)</th><th colspan=3>Actions</th></tr>");
      $compare = $email;
  }

  echo("
    <tr class='$emailId $rowColor'>
    <form method='POST'>
    <input id='emailId' name='emailId' readonly type='hidden' value='" . $emailId . "'>
    <input id='id' name='id' readonly type='hidden' value='" . $row['id'] . "'>
    <input name='rowId' readonly type='hidden' value='" . $row['id'] . "'>
    <input name='emailrecip' readonly type='hidden' value='" . $row['emailrecip'] . "'>
    <td><span class='hidden'>&#x2610;</span><input type='checkbox' class='checkbox' name='d_check[]' value=''></td>    
    <td><input style='font-weight: bold;border:none;background-color:transparent;' name='siteName' readonly type='text' value='" . $row['sitename'] . "'></td>
    <td><input required style='border-style: inset; background-color:transparent;' name='days' type='number' min=1 max=365 value='" . $row['days'] . "'></td>
    <td><input type='submit' name='update' value='Update' class='action'></td>
    <td><input type='submit' name='delete' value='Delete' class='action' onclick='return confirm(\"Are you sure you would like to delete this Alert?\")'></td>
    </form>
    </tr>
      ");
}

if (count($saved) === 0) { 
    // since header is set inside the loop, we need to supply one for 0 records
    echo("<table style='width: 550px'><th>Multiple Delete</th><th>Tag Name</th><th>Warning Period (Days)</th><th colspan=3>Actions</th></tr>");    
    echo "<tr><td> -- </td><td> -- </td><td> -- </td><td> -- </td><td> -- </td></tr>";  
}
?>
</table>
<form method="POST">
    <p><input type="submit" id="subdels" value="Delete Selected Alerts" onclick='return confirm("Are you sure you would like to delete the selected Alerts?")'/></p>
    <input type="hidden" id="nm" name="nm" value=""/>
</form>
</body>
<script>
/*
  function showTable(emailId) {
    var tableRow = $( "tr." + emailId);
    tableRow.toggleClass("hidden");
  } */

  var tags = <?php echo json_encode($emaillist); ?>;
  
  //$("#emailrecip" ).autocomplete({source: tags});
  
    var licenseJson = <?php echo json_encode($licensesArray); ?>;

    $("#licenseSelect").select2({
            data:licenseJson,
              multiple: true,
           placeholder: 'Select one or more licenses from the list',
		   closeOnSelect: false
    });	
	
 
</script>
<script language="javascript">
var cklen = $('.checkbox').length; 
var selected = new Array(cklen);   
$("#submitMe" ).submit(function( event ) {
    //debugger;
    // ==============================================================
    var delim = ';';                    // alert id delimiter
    var alertids = '';                  // working alert id string
    var selcount;                       // count of alert ids selected to delete
    for (var ix = 0, selcount = 0; ix < cklen; ix++ ) {
        if (selected[ix] !== undefined) {   // is this element populated?
            if (selected[ix] !== '') {      // is this alert id checked/selected?
                if (alertids.length > 0) {  // any alert ids already added?
                    alertids += delim;      // append the delimiter
                }
                alertids += selected[ix];   // append the alert id
                selcount++;                 // bump selected alert id count
            }
        }
    }
    if (selcount === 0) {
        alert("No alerts selected for deletion. Nothing to do.");
        event.preventDefault();
        return false;                   // indicate no submit
    }
    $("#nm").val(alertids);             // set assembled alert ids string "nm".
    return;    
    // ==============================================================    
});
  
$(document).ready(function () {
	 

$("#subdels").click(function(){
    $("#submitMe").trigger('submit');
});
$(".select_each").change(function(){    // "select each" change 
    var status = this.checked;          // "select each" checked status
    var ckix = $('.select_each').index(this);// get "select_each" index
    var emailidcount = 0;    // email ID count/index at which to start reading ckboxes
    //debugger;
    var ix;                             // current checkbox index
    var alertid;                        // and correcponding alert ID
    var emailid = '';                   // and saved email ID
    var thisemailid = '';               // working email ID
    //debugger;
    $('.checkbox').each(function(){     // iterate all listed checkbox items
        // we need to get ix set to first index for THIS email ID! 
        ix = $('.checkbox').index(this);// get checkbox index
        thisemailid = document.getElementsByName("emailId")[ix].value;// and value
        if (emailid === '') {           // first pass?
            emailid = thisemailid;      // save email ID for loop break
        } else if (thisemailid !== emailid) { // new email ID?
            emailidcount++;             // bump count
            emailid = thisemailid;      // save this email ID for loop break
        }
        if (emailidcount < ckix) {      // not into selected email sublist yet?
            ;                           // do nothing - keep going
        } else if (emailidcount === ckix) { // into desired email ID range?
            if (thisemailid === emailid) {  // process only for this email ID's
                alertid = document.getElementsByName("id")[ix].value;// alert IDs
                //if($(this).is(':visible')){// CAN be hidden w/table collapsed
                this.checked = status;      // change ".checkbox" checked status
                if (status === false) {     // "select each" unchecked?
                    selected[ix] = '';      // clear saved alert id
                } else {                    // what happens in other direction?
                    selected[ix] = alertid; // save all alert ids
                }
                //}
            } // else another email ID, we don't need it...
        }
    });
    $('.action').each(function(){   // calls for reversing all
        this.disabled = status;     // .action class (update/delete) buttons
    });   
});

$('.checkbox').click(function(){            //".checkbox" change 
    // uncheck "select each", if one of the listed checkbox item is unchecked
    var status = this.checked;                  // "checked" (or not) status
    var ix;                                     // working checkbox index
    var ixsave = $('.checkbox').index(this);    // saved input checkbox index
    var startix = 0;                            // starting checkbox index
    var endix = 0;                              // ending checkbox index
    var ckix = 0;                               // calc'd. "select_each" index
    var passcount = 0;                          // read loop pass count
    var match = false;                          // email ID match
    var emailidcount = 0;    // email ID count/index at which to start reading ckboxes    
    var alertid = document.getElementsByName("id")[ixsave].value;// and alert ID
    var emailid = document.getElementsByName("emailId")[ixsave].value;// email ID
    var thisemailid = '';                       // working email ID
    var prevemailid = emailid;                  // previous email ID
    var checkstate = false;                     // working checkbox check state
    var countchecked = 0;                       // # ckboxes checked in this email ID's range
    //debugger;
    // ------------------------------------------------------------------------
    // calculate which select_each index to set/reset
    // ------------------------------------------------------------------------
    $('.checkbox').each(function(){     // iterate all listed checkbox items
        // we need to get ckix set to index for THIS email ID! 
        ix = $('.checkbox').index(this);// get checkbox index
        thisemailid = document.getElementsByName("emailId")[ix].value;// and value
        if (thisemailid !== emailid) {          // no match?
            if (thisemailid !== prevemailid) {  // count only each NEW mismatch
                emailidcount++;                 // save as select_each index                        
                prevemailid = thisemailid;      // and new previous
            }                
        } else if (thisemailid === emailid) {   // match?
            if (match === false) {              // first match?
                startix = ix;                   // set starting checkbox index
                match = true;                   // save match status
                ckix = emailidcount;            // save select_each index                
            }
            endix = ix;                         // save in case last for email ID
            checkstate = ($('.checkbox')[ix].checked === true);
            countchecked += checkstate;         // capture in-range checked count
        }
        passcount++;                            // bump passcount
    });
    
    // ------------------------------------------------------------------------    
    if(status === false){                       // is this item unchecked?
        $('.select_each')[ckix].checked = status;// reset this "select each" checked status
        selected[ixsave] = '';                  // clear saved alert id
    } else {                                    // checking one select checkbox
        selected[ixsave] = alertid;             // save this alert id
        $('.action').each(function(){           // calls for disabling all
            this.disabled = true;               // .action class (update/delete) buttons
        });
    }
    
    // check all "select each" checkboxes if ALL checkbox items are checked
    if ($('.checkbox:checkbox:checked').length === $('.checkbox').length ){ 
        $('.select_each').each(function(){ 
           this.checked = true;    //change "select each" checked status to true
        });
        $('.action').each(function(){       // calls for disabling all
            this.disabled = true;           // .action class (update/delete) buttons
        });       
    // uncheck all "select each" checkboxes if ALL checkbox items are unchecked
    } else if ($('.checkbox:checkbox:checked').length === 0) { // all unchecked?
        $('.select_each').each(function(){ 
           this.checked = false;  //change "select each" checked status to false
        });        
        $('.action').each(function(){       // calls for enabling all
            this.disabled = false;          // .action class (update/delete) buttons
        });       
    // check "select each" checkbox if ALL checkbox items in-range are checked
    } else if (countchecked === ((endix - startix) + 1)) {  // all checked?
        $('.select_each')[ckix].checked = true;             // indicate so
        $('.action').each(function(){       // calls for disabling all
            this.disabled = true;           // .action class (update/delete) buttons
        });       
    // uncheck "select each" checkbox if ALL checkbox items in-range are unchecked
    } else if (countchecked === 0 ) {                       // all unchecked?
        $('.select_each')[ckix].checked = false;            // indicate so
        $('.action').each(function(){       // calls for enabling all
            this.disabled = false;          // .action class (update/delete) buttons
        });       
    }
});

});
</script>

