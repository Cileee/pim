var amount = document.getElementById("amount");
var currency = document.getElementById("currency");

function getOption() {
  selectElement = document.querySelector("#currency");
  selectOption = selectElement.options[selectElement.selectedIndex];
  selectOptionText = selectOption.textContent;
  exchangeRate = selectOption.getAttribute("data-rate");

  convertedAmount = amount.value * exchangeRate;
  document.querySelector(".converted_amount").textContent =
    convertedAmount.toFixed(2);
  document.querySelector(".currency_chosen").textContent = selectOptionText;
}

$(".cd-popup").on("click", function (event) {
  if (
    $(event.target).is(".cd-popup-close") ||
    $(event.target).is(".cd-popup")
  ) {
    event.preventDefault();
    $(this).removeClass("is-visible");
  }
});

$(document).keyup(function (event) {
  if (event.which == "27") {
    $(".cd-popup").removeClass("is-visible");
  }
});

$("#purchase").submit(function (e) {
  e.preventDefault();
  var currency_id = $("#currency option:selected").val();
  var amount = $("#amount").val();
  $.ajax({
    url: "backend/cronjobs/order_create.php",
    method: "post",
    data: {
      currency_id: currency_id,
      amount: amount,
    },
    context: document.body,
    success: function (response) {
      data = JSON.parse(response);
      let text = "";
      $(".cd-popup").addClass("is-visible");
      $.each(data, function (key, val) {
        text = text + "<b>" + key + "</b>: " + val + "<br />";
      });
      $(".confirmation").html(text);
    },
    error: function (jqXHR, exception) {
      if (jqXHR.status === 0) {
        console.log("Not connect.\n Verify Network.");
      } else if (jqXHR.status == 404) {
        console.log("Requested page not found. [404]");
      } else if (jqXHR.status == 500) {
        console.log("Internal Server Error [500].");
      } else if (exception === "parsererror") {
        console.log("Requested JSON parse failed.");
      } else if (exception === "timeout") {
        console.log("Time out error.");
      } else if (exception === "abort") {
        console.log("Ajax request aborted.");
      } else {
        console.log("Uncaught Error.\n" + jqXHR.responseText);
      }
    },
  });
});
