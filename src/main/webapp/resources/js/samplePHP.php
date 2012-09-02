<?php
$jobID = $_GET['jobID'];
require_once 'mysqldefs.php';
require_once 'forms/formdefs.php';
?>

<div style="width:950px;margin:10px;background:white;">
  <fieldset><legend class="med_blue">BOM Information</legend>
  <div class="formContentWrapper" style="width:900px;margin-left:10px;margin-top:0px;margin-bottom:5px;">
    <strong><label id = "importBomCheckBoxLabel">Import BOM</label></strong>
    <input style="font-size:10px;" type="checkbox" id="importBomCheckBox" name="importBomCheckBox" onclick="showHideImportBomFields(this);">
    <strong><label id = "clearBomCheckBoxLabel" style="margin-left:25px;">Clear BOM</label></strong>
    <input style="font-size:10px;" type="checkbox" id="clearBomCheckBox" name="clearBomCheckBox" onclick="showHideClearBomFields(this);">
    <strong><label id = "saveBomCheckBoxLabel" style="margin-left:25px;">Save BOM</label></strong>
    <input style="font-size:10px;" type="checkbox" id="saveBomCheckBox" name="saveBomCheckBox" onclick="showHideSaveBomFields(this);">
    <strong><label id = "invoiceBomCheckBoxLabel" style="margin-left:25px;">Invoice</label></strong>
    <input style="font-size:10px;" type="checkbox" id="invoiceBomCheckBox" name="invoiceBomCheckBox" onclick="showHideInvoiceBomFields(this);">

      <div id="importBomFields" style="display:none;">
        <fieldset style="width:750px;"><legend id="importBOMFieldSetLabel" class="med_blue">Import a Job BOM</legend>
        <div class="contentWrapper med_blue" style="width:700px;margin:10px;padding:5px;font-size:10px;color:green;background-color:#f0f0f0;">
          Instructions: Copy the Job BOM from the Site Survey excel document.  Select only the cells that contain the Job BOM data (ie. don't copy the column headers).
          Paste the copied cells into the text box below and then press the <strong>Import BOM</strong> button.  It is important that the columns are ordered as shown in the Job BOM table below.
          <div class="clear"></div><div class="med_red" style="font-size:10px;">Note that this import operation will replace any existing Job BOM data.</div>
        </div>
        <div class="clear"></div>
        <textarea id="bomImport" style="margin:10px" tabindex="-1" rows="8" cols="150" maxlength="10000" name="bomImport" wrap="physical"></textarea>
        <div class="clear"></div>
        <?php
          echo "<input style=\"margin:10px;\" type=\"submit\" value=\"Import BOM\" name=\"submit\" onclick=\"importJobBom();\">";
        ?>
        <div class="clear"></div>
        </fieldset>
      </div>

      <div id="clearBomFields" style="display:none;">
        <fieldset style="width:750px;"><legend id="clearBOMFieldSetLabel" class="med_blue">Clear a Job BOM</legend>
        <div class="contentWrapper med_blue" style="width:700px;margin:10px;padding:5px;font-size:10px;color:green;background-color:#f0f0f0;">
          Instructions: Press the <strong>Clear BOM</strong> button to remove all BOM entries for this Job.
          <div class="clear"></div><div class="med_red" style="font-size:10px;">Note that this clear operation will delete all BOM entries in the LG database for this Job.</div>
        </div>
        <div class="clear"></div>
        <?php
          echo "<input style=\"margin:10px;\" type=\"submit\" value=\"Clear BOM\" name=\"submit\" onclick=\"clearJobBom();\">";
        ?>
        <div class="clear"></div>
        </fieldset>
      </div>

      <div id="saveBomFields" style="display:none;">
        <fieldset style="width:750px;"><legend id="saveBOMFieldSetLabel" class="med_blue">Save a Job BOM</legend>
        <div class="contentWrapper med_blue" style="width:700px;margin:10px;padding:5px;font-size:10px;color:green;background-color:#f0f0f0;">
          Instructions: Press the <strong>Save BOM</strong> button to save all of the <b>Is Invoiced</b> checkbox values for all BOM entries for this Job.
          <div class="clear"></div><div class="med_red" style="font-size:10px;">Note that the only fields that can change and thus save on the BOM are the <b>Is Invoiced</b> fields (checked or not checked).</div>
        </div>
        <div class="clear"></div>
        <?php
          echo "<input style=\"margin:10px;\" type=\"submit\" value=\"Save BOM\" name=\"submit\" onclick=\"saveJobBom();\">";
        ?>
        <div class="clear"></div>
        </fieldset>
      </div>

      <div id="invoiceBomFields" style="display:none;">
        <fieldset style="width:750px;"><legend id="invoiceOMFieldSetLabel" class="med_blue">Invoice a Job BOM (or partial BOM)</legend>
        <div class="contentWrapper med_blue" style="width:700px;margin:10px;padding:5px;font-size:10px;color:green;background-color:#f0f0f0;">
          Instructions: Press the <strong>Invoice</strong> button to create a Invoice on the Financial tab that includes all of the BOM items that have the <b>Invoice Now</b> checkbox checked.
          <div class="clear"></div><div class="med_red" style="font-size:10px;">Note that the Amount field will be the sum of all <b>Total Cost</b> cells for each line item entry that has <b>Invoice Now</b> checked.</div>
        </div>
        <div class="clear"></div>
        <?php
          echo "<table width=\"90%\" cellspacing=\"15\"><tbody>";
          echo "<tr>";
          echo "<td>"; insertTextInputField (0, "Invoice Number:<div class=\"clear\"></div>", "invoiceNumber", "", 35, 35, 1, FALSE, $errors); echo "</td>";
          $poList = getPOList($jobID);
          echo "<td>";
          insertSelectFieldArray (0, "PO Number:<div class=\"clear\"></div>", "invoicePoNumber", "", $poList, "", ""); echo "</td>";
          echo "<td>"; insertTextInputField (0, "Amount:<div class=\"clear\"></div>", "invoiceAmount", "0.00", 25, 25, 2, TRUE, null); echo "</td>";
          echo "<td >";
          echo "<strong><label id=\"invoiceDateSentLabel\">Date Sent:</strong><div class=\"clear\"></div></label>";
          echo "<input readonly title=\"Click to change date Invoice was sent\" type=\"text\" size=\"11\" value=\"\" id=\"invoiceDateSent\"/>";
          echo "</td>";
          echo "</tr>";
          echo "</tbody></table>";

          echo "<input style=\"margin:10px;margin-top:15px;\" type=\"submit\" value=\"Invoice\" name=\"submit\" onclick=\"processJobBomInvoiceForm();\">";
        ?>
        <div class="clear"></div>
        </fieldset>
      </div>

   </div>

   <div class="contentWrapper" style="width:925px;margin-top:10px;">
     <table id="jobBomTable" height="100%" width="100%" class="tablesorter" style="margin:0px;" cellpadding="0" cellspacing="1">
     <thead>
     <tr>
     <th colspan="6" class="{sorter:false}" align="center" style="background:orange">Job BOM Entries</th>
     <th  width="8%" class="{sorter:false}" align="center" style="background:orange">Toggle&nbsp;<input id="toggleAllIsInvoicedCheckBox" style="font-size:10px;" type="checkbox" value="No" onclick="toggleAllIsInvoiced(this);"></th>
     <th  width="8%" class="{sorter:false}" align="center" style="background:orange">Toggle&nbsp;<input id="toggleAllInvoiceNowCheckBox" style="font-size:10px;" type="checkbox" value="No" onclick="toggleAllInvoiceNow(this);"></th>
     </tr>
     <tr>
     <th  width="3%">#</th>
     <th  width="5%">QTY</th>
     <th  width="15%">Part Number</th>
     <th  width="30%">Description</th>
     <th  width="8%" align="center">Unit Cost</th>
     <th  width="8%" align="center">Total Cost</th>
     <th class="{sorter:false}" align="center">Is Invoiced</th>
     <th class="{sorter:false}" align="center">Invoice Now</th>
     </tr></thead>
     <?php insertJobBom($jobID); ?>
     </table>
   </div>


   </fieldset>
 </div>

<div id="confirmDialog" title="Job BOM" style="display:none;">
    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0px 0;"></span>
    <p id="confirmText"></p>
</div>
<div id="messageDialog" title="Job BOM" style="display:none;">
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 30px 0;"></span>
    <p id="messageText"></p>
</div>

<div id="errorDialog" title="Job BOM" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div/></p>
    <p id="errorText"></p>
</div>

<style type="text/css">
  .ui-widget { font-family: segoe ui, Arial, sans-serif; font-size: .7em; }
  label, input {margin-top:5px;}
  textarea.text { margin-bottom:12px; width:95%; padding: .4em;}
  fieldset { padding:0; border:0; margin-top:10px; }
  h1 { font-size: 1.2em; margin: .6em 0; }
  .validateTips { border: 1px solid transparent; padding: 0.1em; }
  div.ui-dialog-buttonpane {font-size: 1em; }
  div.ui-dialog-titlebar{font-size: 1.5em; }
</style>

<script type="text/javascript">
  // below so we can use trim function in IE.
  String.prototype.trim = function() {return $.trim(this)}

  var jobID = <?php echo $jobID;?>;
  $('#invoiceDateSent').datepicker({showOn: "both", buttonImage: "images/calendar.gif", buttonImageOnly: true });

  $(document).ready(function()
    {
      //$("#jobBomTable").tablesorter({widgets: ['zebra'],sortList:[[0,0]]});
    }
  );

  function showHideImportBomFields(checkBox, fieldDiv) {
    (checkBox.checked) ? $('#importBomFields').css({display:''}) : $('#importBomFields').css({display:'none'});
    $('#clearBomFields').css({display:'none'});
    $('#clearBomCheckBox').prop("checked", false);
    $('#saveBomFields').css({display:'none'});
    $('#saveBomCheckBox').prop("checked", false);
    $('#invoiceBomFields').css({display:'none'});
    $('#invoiceBomCheckBox').prop("checked", false);
  }
  function showHideClearBomFields(checkBox, fieldDiv) {
    (checkBox.checked) ? $('#clearBomFields').css({display:''}) : $('#clearBomFields').css({display:'none'});
    $('#importBomFields').css({display:'none'});
    $('#importBomCheckBox').prop("checked", false);
    $('#saveBomFields').css({display:'none'});
    $('#saveBomCheckBox').prop("checked", false);
    $('#invoiceBomFields').css({display:'none'});
    $('#invoiceBomCheckBox').prop("checked", false);
  }
  function showHideSaveBomFields(checkBox, fieldDiv) {
    (checkBox.checked) ? $('#saveBomFields').css({display:''}) : $('#saveBomFields').css({display:'none'});
    $('#importBomFields').css({display:'none'});
    $('#importBomCheckBox').prop("checked", false);
    $('#clearBomFields').css({display:'none'});
    $('#clearBomCheckBox').prop("checked", false);
    $('#invoiceBomFields').css({display:'none'});
    $('#invoiceBomCheckBox').prop("checked", false);
  }
  function showHideInvoiceBomFields(checkBox, fieldDiv) {
    var invoiceNowTotal = $("#invoiceNowTotal").text();
    if (invoiceNowTotal == "0.00") {
      $("#errorText").html("Nothing to Invoice!  <div class=\"clear\"></div>There are no checkboxes checked in the Invoice Now column of the BOM");
      $("#errorDialog").show();
      $("#errorDialog").dialog({dialogClass:'error', modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
      $('#invoiceBomCheckBox').prop("checked", false);
      return;
    }

    (checkBox.checked) ? $('#invoiceBomFields').css({display:''}) : $('#invoiceBomFields').css({display:'none'});
    $('#importBomFields').css({display:'none'});
    $('#importBomCheckBox').prop("checked", false);
    $('#clearBomFields').css({display:'none'});
    $('#clearBomCheckBox').prop("checked", false);
    $('#saveBomFields').css({display:'none'});
    $('#saveBomCheckBox').prop("checked", false);

    $("#invoiceNumberLabel").css('color','black');
    $("#invoiceNumber").val("");
    $("#invoiceAmount").val(invoiceNowTotal);

    $("#invoiceDateSent").val($.datepicker.formatDate('mm/dd/yy', new Date()));
  }
  function processJobBomInvoiceForm() {
    var invoiceNumber = $("#invoiceNumber").val();
    var d = new Date($("#invoiceDateSent").val());
    var invoiceAmount = $("#invoiceAmount").val();
    var invoiceDateSent = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
    var invoiceDatePaid = "0000-00-00";

    if (invoiceNumber == "") {
      $("#invoiceNumberLabel").css('color','red');
      return;
    }

    var poDBID = $("#invoicePoNumber").val();
    if (poDBID == -1) {
      $("#errorText").html("Error<div class=\"clear\"></div>You can't create a Invoice without a Purcase Order defined!");
      $("#errorDialog").show();
      $("#errorDialog").dialog({dialogClass:'error', modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
      return;
    }

    $("#confirmText").html("Invoice Job BOM?<div class=\"clear\">&nbsp;</div>An invoice will be created for $" + invoiceAmount + ".  Would you like to proceed?");
    $("#confirmDialog" ).dialog({resizable: true, height:160, modal: true,
      buttons: {
        "Ok": function() {
          var url = "jobFinanceDBActions.php";
          var postData = {action:"createInvoiceItem", jobDBID:jobID, itemDBID:0, invoiceNumber:escape(invoiceNumber), poDBID:poDBID, invoiceAmount:invoiceAmount, invoiceDateSent:invoiceDateSent, invoicePaymentNumber:"", invoiceVoucher:"", invoiceDatePaid:invoiceDatePaid, engineering: "0.00", installation:"0.00", transportation:"0.00", materials:invoiceAmount};
          $.post(url, postData, function(data){processCreateInvoiceResponse(data);});

          $(this).dialog("close");
        },
        Cancel: function() {
          $('#invoiceBomFields').css({display:'none'});
          $('#invoiceBomCheckBox').prop("checked", false);
          $(this).dialog("close");
        }
      }
    });
  }
  function processCreateInvoiceResponse(data) {
    // need to mark all items as invoiced in job bom table and reload table
    var invoicedIds = [];
    $('[id^="invoiceNowCheckBox_"]:checked').each(function(i) {
      var ida = this.id.split("_");
      invoicedIds.push(ida[1]);
      $(this).prop('checked', false);
      $("#isInvoicedCheckBox_" + ida[1]).prop('checked', true);
      });

      var url = "jobDetailsDashBoards/jobBomDBActions.php";
      var postData = {action:"saveBom", jobID:jobID, invoicedIds:invoicedIds};
      $.post(url, postData, function(data){updateInvoiceResponse(data);});
  }
  function updateInvoiceResponse(data) {
    $('#invoiceBomFields').css({display:'none'});
    $('#invoiceBomCheckBox').prop("checked", false);

    if (data.match("LGError:"))
      $("#messageText").html(data);
    else
      $("#messageText").html("Materials Invoice created for amount $" + $("#invoiceAmount").val());

    $("#messageDialog").show();
    $("#messageDialog").dialog({modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
  }
  function toggleAllIsInvoiced(cbox) {
   $('[id^="isInvoicedCheckBox_"]').prop('checked', cbox.checked);
   calcIsInvoicedTotal();
  }
  function toggleAllInvoiceNow(cbox) {
    $('[id^="invoiceNowCheckBox_"]').prop('checked', cbox.checked);
    calcInvoiceNowTotal();
  }
  function calcIsInvoicedTotal() {
    var total = 0.00;
    $('[id^="isInvoicedCheckBox_"]:checked').each(function(index, item){
        var ida = item.id.split("_");
        var id = ida[1];
        total += parseFloat($("#totalCost_" + id).text().replace(",", ""));
      }
    );
    $("#invoicedTotal").text(total.toFixed(2));
  }
  function calcInvoiceNowTotal() {
    var total = 0.00;
    $('[id^="invoiceNowCheckBox_"]:checked').each(function(index, item){
        var ida = item.id.split("_");
        var id = ida[1];
        total += parseFloat($("#totalCost_" + id).text().replace(",", ""));
      }
    );
    $("#invoiceNowTotal").text(total.toFixed(2));
    $("#invoiceAmount").val(total.toFixed(2));
  }


  function importJobBom() {
    $("#confirmText").html("Import Job BOM?");
    $("#confirmDialog" ).dialog({resizable: true, height:160, modal: true,
      buttons: {
        "Ok": function() {
          var bomArray = $('#bomImport').val().trim().split("\n");

          var url = "jobDetailsDashBoards/jobBomDBActions.php";
          var postData = {action:"importBom", jobID:jobID, bomArray:bomArray};
          $.post(url, postData, function(data){importResponse(data);});

          $(this).dialog("close");
        },
        Cancel: function() {
          $(this).dialog("close");
        }
      }
    });
  }
  function importResponse(data) {
    $('#importBomFields').css({display:'none'});
    $('#importBomCheckBox').prop("checked", false);
    $('#bomImport').val("");

    if (! data.match("LGError:")) {
      $("#jobBomTable").find("tr:gt(1)").remove();
      var total = 0.00;
      var invoicedTotal = 0.00;

      var bomArray = $.parseJSON(data);

      $.each(bomArray, function(index, item){
          var rowNumber = index + 1;
          var id = item.id;
          var isInvoiced = item.isInvoiced;
          var totalCost = item.qty * item.unitCost;
          totalCost = totalCost.toFixed(2);
          total += (item.qty * item.unitCost);

          var html = "<tr>" +
                     "<td>" + rowNumber + "</td>" +
                     "<td>" + item.qty + "</td>" +
                     "<td>" + item.partNumber + "</td>" +
                     "<td>" + item.partDescription + "</td>" +
                     "<td align=\"right\">$" + item.unitCost + "</td>" +
                     "<td align=\"right\">$<label id=\"totalCost_" + id + "\">" + totalCost + "</td>" +
                     "<td align=\"center\">" + "<input id=\"isInvoicedCheckBox_" + id + "\" type=\"checkbox\" value=\"0\" onclick=\"calcIsInvoicedTotal()\">" + "</td>" +
                     "<td align=\"center\">" + "<input id=\"invoiceNowCheckBox_" + id + "\" type=\"checkbox\" value=\"0\" onclick=\"calcInvoiceNowTotal()\">" + "</td>" +
                     "</tr>";
          $('#jobBomTable').append(html);

        }
      );

      html = "<thead><tr>" +
             "<th class=\"{sorter:false}\" align=\"right\" colspan=\"5\">Total&nbsp;</th>" +
             "<th class=\"{sorter:false}\" align=\"right\">$" + total.toFixed(2) + "</th>" +
             "<th class=\"{sorter:false}\" align=\"right\">$<label id=\"invoicedTotal\">" + invoicedTotal.toFixed(2) + "</label></th>" +
             "<th class=\"{sorter:false}\" align=\"right\">$<label id=\"invoiceNowTotal\">" + "0.00" + "</label></th>" +
             "</tr></thead>";
      $('#jobBomTable').append(html);

      $("#messageText").html("Job BOM Sucessfully Imported!");
    }
    else {
      $("#messageText").html(data);
    }

    $("#jobBomTable").trigger("update");
    $("#jobBomTable").trigger("appendCache");

    $("#messageDialog").show();
    $("#messageDialog").dialog({modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
  }

  function clearJobBom() {
    $("#confirmText").html("Clear Job BOM?");
    $("#confirmDialog" ).dialog({resizable: true, height:160, modal: true,
      buttons: {
        "Ok": function() {
          var url = "jobDetailsDashBoards/jobBomDBActions.php";
          var postData = {action:"clearBom", jobID:jobID};
          $.post(url, postData, function(data){clearResponse(data);});

          $(this).dialog("close");
        },
        Cancel: function() {
          $(this).dialog("close");
        }
      }
    });
  }
  function clearResponse(data) {
    $('#clearBomFields').css({display:'none'});
    $('#clearBomCheckBox').prop("checked", false);

    if (! data.match("LGError:")) {
      $("#jobBomTable").find("tr:gt(1)").remove();
      $('#jobBomTable').append("<tr><td colspan=\"8\">No Entries Found</td></tr>");
      $('#jobBomTable').append("<thead><tr><th class=\"{sorter:false}\" align=\"right\" colspan=\"7\">Total&nbsp;</th><th class=\"{sorter:false}\" align=\"right\">$0.00</th></tr></thead>");
    }
    $("#messageText").html(data);
    $("#messageDialog").show();
    $("#messageDialog").dialog({modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
  }

  function saveJobBom() {
    var invoicedIds = [];
    $('[id^="isInvoicedCheckBox_"]:checked').each(function(i) {
      var ida = this.id.split("_");
      invoicedIds.push(ida[1]);
      });

    $("#confirmText").html("Save Job BOM?");
    $("#confirmDialog" ).dialog({resizable: true, height:160, modal: true,
      buttons: {
        "Ok": function() {
          var url = "jobDetailsDashBoards/jobBomDBActions.php";
          var postData = {action:"saveBom", jobID:jobID, invoicedIds:invoicedIds};
          $.post(url, postData, function(data){saveResponse(data);});

          $(this).dialog("close");
        },
        Cancel: function() {
          $(this).dialog("close");
        }
      }
    });
  }
  function saveResponse(data) {
    $('#saveBomFields').css({display:'none'});
    $('#saveBomCheckBox').prop("checked", false);

    $("#messageText").html(data);
    $("#messageDialog").show();
    $("#messageDialog").dialog({modal: true, buttons: {Ok: function() {$( this ).dialog( "close");}}});
  }

</script>

<?php

function insertJobBom($jobID) {
  $entryCount = 0;
  $bomTotal = 0.00;
  $invoicedTotal = 0.00;


  $sql = "select * from jobbom where jobID=$jobID";
  $result = mysql_query($sql);
  if (!$result) {
    echo "LGError: Query to show fields from table failed<br />".$sql."<br />".mysql_error()."<br />";
  }
  echo "<tbody>";
  while($row = mysql_fetch_array($result)) {
    $entryCount++;
    echo "<tr>";
    echo "<td>" . $entryCount . "</td>";
    echo "<td>" . $row['qty'] . "</td>";
    echo "<td>" . $row['partNumber'] . "</td>";
    echo "<td>" . $row['partDescription'] . "</td>";
    echo "<td align=\"right\">" . "$" . number_format($row['unitCost'], 2) . "</td>";
    echo "<td align=\"right\">$<label id=\"totalCost_" . $row["id"] . "\">" . number_format(($row['qty'] * $row['unitCost']), 2) . "</label></td>";
    echo "<td align=\"center\">"; insertCheckBoxField (5, "", "isInvoicedCheckBox_" . $row["id"], $row["isInvoiced"], $row["isInvoiced"], "calcIsInvoicedTotal()", null); echo "</td>";
    echo "<td align=\"center\">"; insertCheckBoxField (5, "", "invoiceNowCheckBox_" . $row["id"], 0, 0, "calcInvoiceNowTotal()", null); echo "</td>";
    echo "</tr>";
    $bomTotal += $row['qty'] * $row['unitCost'];
    if ($row["isInvoiced"] == 1)
      $invoicedTotal += $row['qty'] * $row['unitCost'];
  }

  if ($entryCount == 0) {
    echo "<tr><td colspan=\"8\">No Entries Found</td></tr>";
  }
  echo "</tbody>";
  echo "<thead><tr>";
  echo "<th class=\"{sorter:false}\" align=\"right\" colspan=\"5\">Total&nbsp;</th><th class=\"{sorter:false}\" align=\"right\">" . "$" . number_format($bomTotal,2) . "</th>";
  echo "<th class=\"{sorter:false}\" align=\"right\">$<label id=\"invoicedTotal\">" . number_format($invoicedTotal,2) . "</th>";
  echo "<th class=\"{sorter:false}\" align=\"right\">$<label id=\"invoiceNowTotal\">" . "0.00" . "</th>";
  echo "</tr></thead>";

}
function getPOList ($jobID) {
  $poList = array();
  $sql = "select id, number from jobpurchaseorders where jobID=$jobID";
  $result = mysql_query($sql);
  if (!$result) {
    echo "Query to show fields from table failed<br />".$sql."<br />".mysql_error()."<br />";
  }
  while($row = mysql_fetch_array($result)){
    $poList[$row["id"]] = $row["number"];
  }
  if (count($poList) == 0) {
    $poList["-1"] = "None";
  }
  return $poList;
}

?>