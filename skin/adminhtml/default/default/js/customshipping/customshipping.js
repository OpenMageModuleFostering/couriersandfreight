window.onload = function() {
    document.getElementById('rule_actions_static_fieldset').style.display="";
    document.getElementById('rule_actions_dynamic_fieldset').style.display="none";
    document.getElementById('rule_actions_restrict_fieldset').style.display="none";

}


function checkShippingRateType() {
    myselect = document.getElementById("rule_action_rate_type");
    var shippingRateValue = myselect.options[myselect.selectedIndex].value;


    if(shippingRateValue == 1) {
        document.getElementById('rule_actions_dynamic_fieldset').style.display="none";
        document.getElementById('rule_actions_restrict_fieldset').style.display="none";
        document.getElementById('rule_actions_static_fieldset').style.display="";
    }
    if(shippingRateValue == 2) {
        document.getElementById('rule_actions_static_fieldset').style.display="none";
        document.getElementById('rule_actions_dynamic_fieldset').style.display="none";
        document.getElementById('rule_actions_restrict_fieldset').style.display="none";
    }
    if(shippingRateValue == 3) {
        document.getElementById('rule_actions_static_fieldset').style.display="none";
        document.getElementById('rule_actions_dynamic_fieldset').style.display="";
        document.getElementById('rule_actions_restrict_fieldset').style.display="none";
    }
    if(shippingRateValue == 4) {
        document.getElementById('rule_actions_static_fieldset').style.display="none";
        document.getElementById('rule_actions_dynamic_fieldset').style.display="none";
        document.getElementById('rule_actions_restrict_fieldset').style.display="";
    }
 }

function multiplewarehouseIdChange() {
    myselect = document.getElementById("warehouse_id");
    var multiplewarehouseId = myselect.options[myselect.selectedIndex].value;

    document.getElementById("selected-wahehouseid").value = multiplewarehouseId;
}