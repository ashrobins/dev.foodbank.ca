(function($){
var $default_serving_size = 15,
    small_serving_size = 15,
    medium_serving_size = 50,
    large_serving_size = 100;

acf.add_action('append', function(){
    // update global variable
     $default_serving_size = $('#acf-field_53597ee885779').val();
     console.log($default_serving_size);

  var $trigger              = $('.acf-repeater-add-row'),
      $ingredients          = $('.field_key-field_53597c16bfbb7 tr.acf-row:not(:last-child)'),
      default_amount        = '.field_key-field_53597d4dc9b62 input',
      default_measurement   = '.field_key-field_53597de3d1204 input',
      default_ingredient    = '.field_key-field_53597e17d1205 input',
      small_list            = [],
      medium_list           = [],
      large_list            = [];



      $ingredients.each(function(){
        var measurement = $(this).find(default_measurement).val(),
            amount = convert_fractions($(this).find(default_amount).val()),
            ingredient = $(this).find(default_ingredient).val();

          if (measurement.length > 0) {
            var unit = measurement
          }
          else {
            var unit = "";
          }


        medium_list.push(
          "<li>" +
            convert(amount,unit,medium_serving_size)
            +" " + ingredient + "</li>");

        });
      var medium_ingredient_list = medium_list.join("");


      // $('#mce_173 iframe').contents().find('html').html(small_ingredient_list);


      console.log(medium_ingredient_list);
    });




// Start converter functions
function convert_fractions(amount){
  var array = amount.split(" ");
  if (array.length > 1) {
    var split = array[1].split("/")
    var result = parseInt(split[0], 10) / parseInt(split[1], 10);
    console.log(result);
    console.log(array[0]);
    console.log(parseInt(array[0], 10) + result)
    return (parseInt(array[0], 10) + result);

  }
  else {
    var fraction_test = amount.split("/");
    if (fraction_test.length > 1 ){
      var result = parseInt(fraction_test[0], 10) / parseInt(fraction_test[1], 10);
      return result;

    }
    else{
       return amount;

    }
  }
}
function convert(amount, measurement, serving_size){
    var multiplier = (serving_size/$default_serving_size)
    var new_amount = (amount * multiplier)
    switch(measurement){
      case "tsp":
      case "teaspoon":
        return convert_tsp(new_amount);
        break;
      case "tbs":
      case "tablespoon":
      case "tablespoons":
        return convert_tbs(new_amount);
        break;
      case "c":
      case "cup":
      case "cups":
        return convert_cups(new_amount);
        break;
      case "oz":
        return convert_oz(new_amount);
        break;
      default:
        return convert_generic(new_amount, measurement);
        break;
    };


}

function convert_tsp(amount){
  if (amount > 3) {
    return convert_tbs(amount/3);
  }
  else {
    return update_measurement(amount, "tsp");
  }

}

function convert_tbs(amount){
  if (amount > 4) {
    return convert_cups(amount/16)
  }
  else {
    return update_measurement(amount, "tbs");
  }

}

function convert_cups(amount){
  if (amount > 4) {
    return convert_quart(amount/4)
  }
  else {
    return update_measurement(amount, "cups");
  }

}

function convert_quart(amount){
  if (amount > 4){
    return convert_gallon(amount/4)
  }
  else {
    return update_measurement(amount, "quarts")
  }

}

function convert_gallon(amount){
  return update_measurement(amount, "gallons");
}

function convert_oz(amount, measurement){
  return update_measurement(amount, "oz");
}

function convert_generic(amount, measurement){
  return update_measurement(amount, measurement);
}

function update_measurement(amount, measurement){
  var quantity = roundToNearest(amount, .25);
  var updated_amount = quantity + " " + measurement;
  console.log(updated_amount);
  return updated_amount;
}


function roundToNearest( number, multiple ){
  var half = multiple/2;
  return number+half - (number+half) % multiple;
}






})(jQuery);




