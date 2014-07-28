

var default_serving_size = 15;

function convert(amount, measurement, serving_size){
    var multiplier = (serving_size/default_serving_size)
    var new_amount = (amount * multiplier)
    switch(measurement){
      case "tsp":
      case "teaspoon":
        convert_tsp(new_amount);
        break;
      case "tbs":
      case "tablespoon":
      case "tablespoons":
        convert_tbs(new_amount);
        break;
      case "c":
      case "cup":
      case "cups":
        convert_cups(new_amount);
        break;
      case "oz":
        convert_oz(new_amount);
        break;
      default:
        convert_generic(new_amount, measurement);
        break;
    };


}

function convert_tsp(amount){
  if (amount > 3) {
    convert_tbs(amount/3);
  }
  else {
    update_measurement(amount, "tsp");
  }

}

function convert_tbs(amount){
  if (amount > 4) {
    convert_cups(amount/16)
  }
  else {
    update_measurement(amount, "tbs");
  }

}

function convert_cups(amount){
  if (amount > 4) {
    convert_quart(amount/4)
  }
  else {
    update_measurement(amount, "cups");
  }

}

function convert_quart(amount){
  if (amount > 4){
    convert_gallon(amount/4)
  }
  else {
    update_measurement(amount, "quarts")
  }

}

function convert_gallon(amount){
  update_measurement(amount, "gallons");
}

function convert_generic(amount, measurement){
  update_measurement(amount, measurement);
}

function update_measurement(amount, measurement){
  var quantity = roundToNearest(amount, .25);
  var updated_amount = quantity + " "+ measurement;
  console.log(updated_amount);
}


function roundToNearest( number, multiple ){
  var half = multiple/2;
  return number+half - (number+half) % multiple;
}
