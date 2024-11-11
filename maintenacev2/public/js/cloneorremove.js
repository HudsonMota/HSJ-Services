// Para usar na tabela do formulário
var openModal = document.getElementById("openModal");
$confirmScript = [];
var limit = 15;

function cloneOrRemove(obj, idx) {
  var counter = $('.limited:checked').size();

  if (jQuery(obj).prop('checked')) {
    if (counter <= limit) {
      var tr = jQuery("table#tb1 tbody")
        .find('[data-index="' + idx + '"]');
      jQuery("table#tb2 tbody")
        .append(jQuery(tr[0]).clone());

      var tr = jQuery("table#tb2 tbody")
        .find('[data-index="' + idx + '"]');

      jQuery(jQuery(tr[0]).find('td')[4]).remove();

    } else {
      jQuery(obj).prop("checked", false);
      locastyle.modal.open("#myAwesomeModal");
    }
    $confirmScript.push(idx);
  }

  if (!jQuery(obj).prop('checked')) {
    var tr = jQuery("table#tb2 tbody")
      .find('[data-index="' + idx + '"]');
    jQuery(tr[0]).remove()
    $confirmScript.splice($confirmScript.indexOf(idx), 1);
  }
}

jQuery(document).ready(function () {

});